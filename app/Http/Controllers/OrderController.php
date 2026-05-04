<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Mail\NewOrderNotification;
use App\Mail\CustomerOrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    const DELIVERY_CHARGES = 199;
    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        // Validate the request
        try {
            $validated = $request->validate([
                'c_fname' => 'nullable|string|max:255',
                'c_lname' => 'nullable|string|max:255',
                'c_email_address' => 'nullable|email|max:255',
                'c_phone' => 'required|string|max:255',
                'c_companyname' => 'nullable|string|max:255',
                'c_address' => 'required|string|max:255',
                'c_city' => 'nullable|string|max:255',
                'c_state_country' => 'nullable|string|max:255',
                'c_postal_zip' => 'nullable|string|max:255',
                'c_country' => 'nullable|string|max:255',
                'c_order_notes' => 'nullable|string',
                'coupon_code' => 'nullable|string|max:255',
                'payment_method' => 'nullable|string|max:255',
                'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                $errorMessages = [];
                foreach ($e->errors() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errorMessages[] = $message;
                    }
                }
                return response()->json([
                    'success' => false,
                    'message' => implode('<br>', $errorMessages),
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        // Get cart items
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::with('product')
                ->where('session_id', $sessionId)
                ->get();
        }

        // Check if cart is empty
        if ($cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Check if any product has discount_price
        $hasDiscountedProducts = $cartItems->contains(function ($item) {
            return $item->product && $item->product->discount_price;
        });

        // Validate and apply coupon if provided
        $coupon = null;
        $discountAmount = 0;
        $couponCode = null;
        $couponDiscountPercent = null;

        if ($request->filled('coupon_code') && !$hasDiscountedProducts) {
            $couponCode = strtoupper(trim($request->input('coupon_code')));
            $coupon = Coupon::where('code', $couponCode)->first();

            if (!$coupon) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid coupon code.');
            }

            if (!$coupon->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This coupon is not valid or has expired.');
            }

            $discountAmount = ($subtotal * $coupon->discount_percent) / 100;
            $couponDiscountPercent = $coupon->discount_percent;
        } else {
            if ($hasDiscountedProducts && $request->filled('coupon_code')) {
                if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Coupon cannot be applied to orders with discounted products.'
                    ], 400);
                }
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Coupon cannot be applied to orders with discounted products.');
            }
        }

        // Calculate totals with delivery charges
        $totalAfterDiscount = $subtotal - $discountAmount;
        $deliveryCharges = self::DELIVERY_CHARGES;
        $grandTotal = $totalAfterDiscount + $deliveryCharges;

        // Start database transaction
        DB::beginTransaction();

        try {
            // Handle payment screenshot upload
            $paymentScreenshotPath = null;
            if ($request->hasFile('payment_screenshot')) {
                $file = $request->file('payment_screenshot');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $uploadPath = public_path('uploads/payment_screenshots');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $paymentScreenshotPath = 'uploads/payment_screenshots/' . $filename;
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : Session::getId(),
                'order_number' => Order::generateOrderNumber(),
                'first_name' => $validated['c_fname'] ?? '',
                'last_name' => $validated['c_lname'] ?? '',
                'company_name' => $validated['c_companyname'] ?? null,
                'address' => $validated['c_address'],
                'apartment' => $request->input('apartment') ?? null,
                'state_country' => $validated['c_state_country'] ?? '',
                'postal_zip' => $validated['c_postal_zip'] ?? '',
                'email' => $validated['c_email_address'] ?? '',
                'phone' => $validated['c_phone'],
                'order_notes' => $validated['c_order_notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_charges' => $deliveryCharges,
                'total' => $totalAfterDiscount,
                'grand_total' => $grandTotal,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'] ?? 'cash',
                'payment_screenshot' => $paymentScreenshotPath,
                'coupon_code' => $couponCode,
                'coupon_id' => $coupon ? $coupon->id : null,
                'coupon_discount' => $couponDiscountPercent,
                'discount_amount' => $discountAmount,
            ]);

            // Increment coupon usage if applied
            if ($coupon) {
                $coupon->incrementUsage();
            }

            // Create order items
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'size' => $cartItem->size,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'total' => $cartItem->price * $cartItem->quantity,
                    ]);
                }
            }

            // Clear the cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', Session::getId())->delete();
            }

            DB::commit();

            // Load order relationships for email
            $order->load('items.product');

            // Send email notifications
            try {
                $adminUsers = User::where('type', 1)->get();
                foreach ($adminUsers as $admin) {
                    Mail::to($admin->email)->send(new NewOrderNotification($order));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send admin order notification: ' . $e->getMessage());
            }

            try {
                if ($order->email) {
                    Mail::to($order->email)->send(new CustomerOrderConfirmation($order));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send customer order confirmation: ' . $e->getMessage());
            }

            if ($request->expectsJson() || $request->ajax()) {
                session()->flash('order_number', $order->order_number);
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect' => route('thankyou', ['order' => $order->order_number]),
                    'order_number' => $order->order_number
                ]);
            }

            return redirect()->route('thankyou', ['order' => $order->order_number])->with('order_number', $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your order. Please try again.',
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
    /**
     * Show public order lookup form.
     */
    public function showLookupForm()
    {
        return view('frontend.order_lookup', ['order' => null]);
    }

    /**
     * Handle public order lookup.
     */
    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with('items.product')
            ->where('order_number', $validated['order_number'])
            ->first();

        if (!$order) {
            return redirect()->back()->withInput()->with('error', __('messages.orderLookup.orderNotFound'));
        }

        return view('frontend.order_lookup', ['order' => $order]);
    }
}

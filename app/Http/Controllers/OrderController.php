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
use Illuminate\Support\Facades\Schema;
class OrderController extends Controller
{

    const DELIVERY_CHARGES = 199;
    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        // Debug logging
        \Log::info('Order creation started', [
            'request_data' => $request->except(['payment_screenshot']),
            'has_file' => $request->hasFile('payment_screenshot'),
            'user_id' => Auth::id(),
            'session_id' => Session::getId()
        ]);

        try {
            // Validate the request - make fields optional that might be missing
            $validated = $request->validate([
                'c_fname' => 'nullable|string|max:255',
                'c_lname' => 'nullable|string|max:255',
                'c_email_address' => 'nullable|email|max:255',
                'c_phone' => 'required|string|max:255',
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
            \Log::error('Validation failed: ' . json_encode($e->errors()));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', array_collapse($e->errors())),
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Get cart items
        try {
            if (Auth::check()) {
                $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
            } else {
                $sessionId = Session::getId();
                $cartItems = Cart::with('product')->where('session_id', $sessionId)->get();
            }
        } catch (\Exception $e) {
            \Log::error('Cart retrieval failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve cart items: ' . $e->getMessage()
            ], 500);
        }

        if ($cartItems->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 400);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code.'
                ], 400);
            }

            if (!$coupon->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon is not valid or has expired.'
                ], 400);
            }

            $discountAmount = ($subtotal * $coupon->discount_percent) / 100;
            $couponDiscountPercent = $coupon->discount_percent;
        }

        // Calculate totals
        $totalAfterDiscount = $subtotal - $discountAmount;
        $deliveryCharges = self::DELIVERY_CHARGES;
        $grandTotal = $totalAfterDiscount + $deliveryCharges;

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

            // Prepare order data - handle missing fields gracefully
            $orderData = [
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : Session::getId(),
                'order_number' => Order::generateOrderNumber(),
                'first_name' => $request->input('c_fname', ''),
                'last_name' => $request->input('c_lname', ''),
                'address' => $validated['c_address'],
                'email' => $request->input('c_email_address', ''),
                'phone' => $validated['c_phone'],
                'order_notes' => $request->input('c_order_notes'),
                'subtotal' => $subtotal,
                'delivery_charges' => $deliveryCharges,
                'total' => $totalAfterDiscount,
                'grand_total' => $grandTotal,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_screenshot' => $paymentScreenshotPath,
                'coupon_code' => $couponCode,
                'coupon_id' => $coupon ? $coupon->id : null,
                'coupon_discount' => $couponDiscountPercent,
                'discount_amount' => $discountAmount,
            ];

            // Only add these fields if they exist in the database
            if (Schema::hasColumn('orders', 'company_name')) {
                $orderData['company_name'] = $request->input('c_companyname');
            }
            if (Schema::hasColumn('orders', 'apartment')) {
                $orderData['apartment'] = $request->input('apartment');
            }
            if (Schema::hasColumn('orders', 'city')) {
                $orderData['city'] = $request->input('c_city');
            }
            if (Schema::hasColumn('orders', 'state_country')) {
                $orderData['state_country'] = $request->input('c_state_country');
            }
            if (Schema::hasColumn('orders', 'postal_zip')) {
                $orderData['postal_zip'] = $request->input('c_postal_zip');
            }
            if (Schema::hasColumn('orders', 'country')) {
                $orderData['country'] = $request->input('c_country');
            }

            \Log::info('Attempting to create order with data: ', $orderData);

            // Create order
            $order = Order::create($orderData);

            \Log::info('Order created successfully: ' . $order->id);

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

            // Send emails (wrap in try-catch so order still succeeds even if email fails)
            try {
                $order->load('items.product');
                $adminUsers = User::where('type', 1)->get();
                foreach ($adminUsers as $admin) {
                    Mail::to($admin->email)->send(new NewOrderNotification($order));
                }

                if ($order->email) {
                    Mail::to($order->email)->send(new CustomerOrderConfirmation($order));
                }
            } catch (\Exception $e) {
                \Log::error('Email sending failed but order was created: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'redirect' => route('thankyou', ['order' => $order->order_number]),
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'order_data' => $orderData ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
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

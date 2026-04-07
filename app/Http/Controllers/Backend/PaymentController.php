<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments with screenshots.
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product')
            ->whereNotNull('payment_screenshot')
            ->where('payment_screenshot', '!=', '');
        
        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }
        
        // Search by order number
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('order_number', 'like', '%' . $search . '%');
        }
        
        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('backend.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment with screenshot.
     */
    public function show($id)
    {
        $order = Order::with('user', 'items.product.images', 'coupon')
            ->whereNotNull('payment_screenshot')
            ->where('payment_screenshot', '!=', '')
            ->findOrFail($id);

        return view('backend.payments.view', compact('order'));
    }
}


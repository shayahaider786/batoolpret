<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers (regular users).
     */
    public function index()
    {
        $customers = User::where('type', 0) // type 0 = regular user/customer
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        // Get additional stats for each customer
        foreach ($customers as $customer) {
            $customer->total_spent = Order::where('user_id', $customer->id)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            
            $customer->last_order = Order::where('user_id', $customer->id)
                ->latest()
                ->first();
        }

        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
    {
        $customer = User::with('orders.items.product')
            ->findOrFail($id);

        // Ensure it's a regular user, not admin
        if ($customer->type == 1) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'This is an admin account, not a customer.');
        }

        $totalSpent = Order::where('user_id', $customer->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $totalOrders = $customer->orders()->count();
        $pendingOrders = $customer->orders()->where('status', 'pending')->count();
        $completedOrders = $customer->orders()->where('status', 'completed')->count();

        return view('backend.customers.show', compact(
            'customer',
            'totalSpent',
            'totalOrders',
            'pendingOrders',
            'completedOrders'
        ));
    }
}

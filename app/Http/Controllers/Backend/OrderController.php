<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product.images', 'coupon');

        // Search by order number
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('order_number', 'like', '%' . $search . '%');
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('backend.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('user', 'items.product.images', 'coupon')
            ->findOrFail($id);

        return view('backend.orders.view', compact('order'));
    }

    /**
     * Display the printable version of the order.
     */
    public function print($id)
    {
        $order = Order::with('user', 'items.product.images', 'coupon')
            ->findOrFail($id);

        return view('backend.orders.print', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::with('user', 'items.product.images', 'coupon')
            ->findOrFail($id);

        return view('backend.orders.edit', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|in:pending,processing,completed,cancelled',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state_country' => 'nullable|string|max:255',
            'postal_zip' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'order_notes' => 'nullable|string',
            'subtotal' => 'nullable|numeric',
            'coupon_code' => 'nullable|string|max:255',
            'coupon_discount' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ]);


        $order->update($validated);

        // Update order item sizes if provided
        if ($request->has('items')) {
            foreach ($request->input('items') as $itemId => $itemData) {
                if (array_key_exists('size', $itemData)) {
                    OrderItem::where('id', $itemId)->where('order_id', $order->id)->update(['size' => $itemData['size']]);
                }
            }
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Order items will be deleted automatically due to cascade delete
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', "Order #{$orderNumber} has been deleted successfully.");
    }
}

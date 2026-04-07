@extends('layouts.frontend')

@section('content')

    <div class="bg-white">
        <div class="container p-5">
        </div>
    </div>

    <!-- Dashboard Hero Section -->
    <section class="bg0 p-t-60 p-b-60">
        <div class="container">
            <div class="flex-c-m flex-w p-b-20">
                <div class="text-center" style="width: 100%;">
                    <h1 class="ltext-103 cl2" style="color: #000; margin-bottom: 10px;">
                        My Dashboard
                    </h1>
                    <p class="stext-107 cl6" style="color: #666;">
                        Welcome back, <strong style="color: #000;">{{ Auth::user()->name }}</strong>! Manage your orders and
                        view your account details.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Statistics -->
    <section class="bg0 p-t-20 p-b-50">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"
                    style="background: #f0f0f0; border-left: 4px solid #000; color: #000; border-radius: 0;">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #000;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6 p-b-20">
                    <div class="bg0 p-t-30 p-b-30 p-lr-20"
                        style="border: 2px solid #000; text-align: center; transition: all 0.3s;">
                        <div class="mtext-105 cl2" style="color: #000; font-weight: bold; margin-bottom: 10px;">
                            {{ $totalOrders ?? 0 }}
                        </div>
                        <div class="stext-102 cl3" style="color: #666; text-transform: uppercase; letter-spacing: 1px;">
                            Total Orders
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 p-b-20">
                    <div class="bg0 p-t-30 p-b-30 p-lr-20"
                        style="border: 2px solid #000; text-align: center; transition: all 0.3s;">
                        <div class="mtext-105 cl2" style="color: #000; font-weight: bold; margin-bottom: 10px;">
                            Rs. {{ number_format($totalSpent ?? 0, 0) }}
                        </div>
                        <div class="stext-102 cl3" style="color: #666; text-transform: uppercase; letter-spacing: 1px;">
                            Total Spent
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 p-b-20">
                    <div class="bg0 p-t-30 p-b-30 p-lr-20"
                        style="border: 2px solid #000; text-align: center; transition: all 0.3s;">
                        <div class="mtext-105 cl2" style="color: #000; font-weight: bold; margin-bottom: 10px;">
                            {{ $pendingOrders ?? 0 }}
                        </div>
                        <div class="stext-102 cl3" style="color: #666; text-transform: uppercase; letter-spacing: 1px;">
                            Pending Orders
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 p-b-20">
                    <div class="bg0 p-t-30 p-b-30 p-lr-20"
                        style="border: 2px solid #000; text-align: center; transition: all 0.3s;">
                        <div class="mtext-105 cl2" style="color: #000; font-weight: bold; margin-bottom: 10px;">
                            {{ $completedOrders ?? 0 }}
                        </div>
                        <div class="stext-102 cl3" style="color: #666; text-transform: uppercase; letter-spacing: 1px;">
                            Completed Orders
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Orders Section -->
    <section class="bg0 p-t-30 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg0 p-t-30 p-b-30 p-lr-20" style="border: 2px solid #000;">
                        <div class="p-b-20" style="border-bottom: 2px solid #000; margin-bottom: 30px;">
                            <h3 class="ltext-103 cl2"
                                style="color: #000; margin: 0; text-transform: uppercase; letter-spacing: 2px;">
                                <i class="zmdi zmdi-shopping-bag" style="margin-right: 10px;"></i>My Orders
                            </h3>
                        </div>

                        @if ($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table" style="margin-bottom: 0;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #000;">
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Order Number</th>
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Date</th>
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Items</th>
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Total</th>
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Status</th>
                                            <th class="stext-102 cl2"
                                                style="color: #000; padding: 15px; text-transform: uppercase; font-weight: bold;">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                                <td class="stext-102 cl2"
                                                    style="color: #000; padding: 20px 15px; font-weight: bold;">
                                                    {{ $order->order_number }}
                                                </td>
                                                <td class="stext-102 cl3" style="color: #666; padding: 20px 15px;">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                    <br>
                                                    <small
                                                        style="color: #999;">{{ $order->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td class="stext-102 cl3" style="color: #666; padding: 20px 15px;">
                                                    {{ $order->items->count() }} item(s)
                                                    <br>
                                                    <small style="color: #999;">
                                                        @foreach ($order->items->take(2) as $item)
                                                            {{ $item->product->name ?? 'Product Deleted' }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                        @if ($order->items->count() > 2)
                                                            +{{ $order->items->count() - 2 }} more
                                                        @endif
                                                    </small>
                                                </td>
                                                <td class="stext-102 cl2"
                                                    style="color: #000; padding: 20px 15px; font-weight: bold;">
                                                    Rs. {{ number_format($order->total, 0) }}
                                                    @if ($order->discount_amount > 0)
                                                        <br>
                                                        <small style="color: #666;">
                                                            Saved: Rs. {{ number_format($order->discount_amount, 0) }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="stext-102 cl3" style="padding: 20px 15px;">
                                                    @if ($order->status == 'pending')
                                                        <span
                                                            style="background: #000; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Pending</span>
                                                    @elseif($order->status == 'processing')
                                                        <span
                                                            style="background: #666; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Processing</span>
                                                    @elseif($order->status == 'completed')
                                                        <span
                                                            style="background: #000; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Completed</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span
                                                            style="background: #999; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 20px 15px;">
                                                    <button type="button"
                                                        class="flex-c-m stext-101 cl0 size-107 bg3 bor14 hov-btn3 p-lr-15 trans-04"
                                                        style="background: #000; color: #fff; border: 2px solid #000; padding: 8px 20px; cursor: pointer; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#orderModal{{ $order->id }}">
                                                        View Details
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Order Details Modal -->
                                            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content"
                                                        style="border: 2px solid #000; border-radius: 0;">
                                                        <div class="modal-header"
                                                            style="background: #000; color: #fff; border-bottom: 2px solid #000;">
                                                            <h5 class="modal-title stext-102"
                                                                style="color: #fff; text-transform: uppercase; letter-spacing: 1px;"
                                                                id="orderModalLabel{{ $order->id }}">
                                                                Order Details - {{ $order->order_number }}
                                                            </h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close" style="color: #fff; opacity: 1;">
                                                                <span aria-hidden="true"
                                                                    style="font-size: 28px;">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="background: #fff; padding: 30px;">
                                                            <!-- Order Status -->
                                                            <div class="p-b-20"
                                                                style="border-bottom: 1px solid #e0e0e0; margin-bottom: 20px;">
                                                                <h6 class="stext-102 cl2"
                                                                    style="color: #000; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                                                                    Order Status</h6>
                                                                <p class="p-b-10">
                                                                    @if ($order->status == 'pending')
                                                                        <span
                                                                            style="background: #000; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Pending</span>
                                                                    @elseif($order->status == 'processing')
                                                                        <span
                                                                            style="background: #666; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Processing</span>
                                                                    @elseif($order->status == 'completed')
                                                                        <span
                                                                            style="background: #000; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Completed</span>
                                                                    @elseif($order->status == 'cancelled')
                                                                        <span
                                                                            style="background: #999; color: #fff; padding: 5px 15px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Cancelled</span>
                                                                    @endif
                                                                </p>
                                                                <small class="stext-102 cl3" style="color: #666;">Order
                                                                    placed on
                                                                    {{ $order->created_at->format('F d, Y h:i A') }}</small>
                                                            </div>

                                                            <!-- Billing Details -->
                                                            <div class="p-b-20"
                                                                style="border-bottom: 1px solid #e0e0e0; margin-bottom: 20px;">
                                                                <h6 class="stext-102 cl2"
                                                                    style="color: #000; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">
                                                                    Billing Details</h6>
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th class="stext-102 cl2" width="30%"
                                                                            style="color: #000; padding: 8px 0;">Name:</th>
                                                                        <td class="stext-102 cl3"
                                                                            style="color: #666; padding: 8px 0;">
                                                                            {{ $order->first_name }}
                                                                            {{ $order->last_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="stext-102 cl2"
                                                                            style="color: #000; padding: 8px 0;">Email:
                                                                        </th>
                                                                        <td class="stext-102 cl3"
                                                                            style="color: #666; padding: 8px 0;">
                                                                            {{ $order->email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="stext-102 cl2"
                                                                            style="color: #000; padding: 8px 0;">Phone:
                                                                        </th>
                                                                        <td class="stext-102 cl3"
                                                                            style="color: #666; padding: 8px 0;">
                                                                            {{ $order->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="stext-102 cl2"
                                                                            style="color: #000; padding: 8px 0;">Address:
                                                                        </th>
                                                                        <td class="stext-102 cl3"
                                                                            style="color: #666; padding: 8px 0;">
                                                                            {{ $order->address }}<br>
                                                                            @if ($order->apartment)
                                                                                {{ $order->apartment }}<br>
                                                                            @endif
                                                                            {{ $order->state_country }},
                                                                            {{ $order->postal_zip }}
                                                                        </td>
                                                                    </tr>
                                                                    @if ($order->company_name)
                                                                        <tr>
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 8px 0;">
                                                                                Company:</th>
                                                                            <td class="stext-102 cl3"
                                                                                style="color: #666; padding: 8px 0;">
                                                                                {{ $order->company_name }}</td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <th class="stext-102 cl2"
                                                                            style="color: #000; padding: 8px 0;">Payment
                                                                            Method:</th>
                                                                        <td class="stext-102 cl3"
                                                                            style="color: #666; padding: 8px 0; text-transform: capitalize;">
                                                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <!-- Order Items -->
                                                            <div class="p-b-20"
                                                                style="border-bottom: 1px solid #e0e0e0; margin-bottom: 20px;">
                                                                <h6 class="stext-102 cl2"
                                                                    style="color: #000; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">
                                                                    Order Items</h6>
                                                                <table class="table" style="border: 1px solid #e0e0e0;">
                                                                    <thead>
                                                                        <tr
                                                                            style="background: #f5f5f5; border-bottom: 2px solid #000;">
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 12px; text-transform: uppercase; font-size: 11px;">
                                                                                Product</th>
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 12px; text-transform: uppercase; font-size: 11px;">
                                                                                Quantity</th>
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 12px; text-transform: uppercase; font-size: 11px;">
                                                                                Price</th>
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 12px; text-transform: uppercase; font-size: 11px;">
                                                                                Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($order->items as $item)
                                                                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                                                                <td class="stext-102 cl3"
                                                                                    style="color: #666; padding: 15px;">
                                                                                    @if ($item->product)
                                                                                        <div class="flex-w"
                                                                                            style="display: flex; align-items: center;">
                                                                                            @if ($item->product->image)
                                                                                                <img src="{{ asset($item->product->image) }}"
                                                                                                    alt="{{ $item->product->name }}"
                                                                                                    style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px; border: 1px solid #000;">
                                                                                            @elseif($item->product->images && $item->product->images->count() > 0)
                                                                                                <img src="{{ asset($item->product->images->first()->image) }}"
                                                                                                    alt="{{ $item->product->name }}"
                                                                                                    style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px; border: 1px solid #000;">
                                                                                            @else
                                                                                                <img src="{{ asset('frontend/images/product-1.png') }}"
                                                                                                    alt="{{ $item->product->name }}"
                                                                                                    style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px; border: 1px solid #000;">
                                                                                            @endif
                                                                                            <span class="stext-102 cl2"
                                                                                                style="color: #000;">{{ $item->product->name }}</span>
                                                                                        </div>
                                                                                    @else
                                                                                        <span class="stext-102 cl3"
                                                                                            style="color: #999;">Product
                                                                                            Deleted</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="stext-102 cl3"
                                                                                    style="color: #666; padding: 15px;">
                                                                                    {{ $item->quantity }}</td>
                                                                                <td class="stext-102 cl3"
                                                                                    style="color: #666; padding: 15px;">Rs.
                                                                                    {{ number_format($item->price, 0) }}
                                                                                </td>
                                                                                <td class="stext-102 cl2"
                                                                                    style="color: #000; padding: 15px; font-weight: bold;">
                                                                                    Rs.
                                                                                    {{ number_format($item->total, 0) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Order Summary -->
                                                            <div class="p-b-20">
                                                                <h6 class="stext-102 cl2"
                                                                    style="color: #000; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">
                                                                    Order Summary</h6>
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th class="stext-102 cl2" width="50%"
                                                                            style="color: #000; padding: 8px 0;">Subtotal:
                                                                        </th>
                                                                        <td class="stext-102 cl3 text-end"
                                                                            style="color: #666; padding: 8px 0;">Rs.
                                                                            {{ number_format($order->subtotal, 0) }}</td>
                                                                    </tr>
                                                                    @if ($order->discount_amount > 0)
                                                                        <tr>
                                                                            <th class="stext-102 cl2"
                                                                                style="color: #000; padding: 8px 0;">
                                                                                Discount
                                                                                @if ($order->coupon_code)
                                                                                    ({{ $order->coupon_code }})
                                                                                @endif
                                                                            </th>
                                                                            <td class="stext-102 cl3 text-end"
                                                                                style="color: #666; padding: 8px 0;">-Rs.
                                                                                {{ number_format($order->discount_amount, 0) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr
                                                                        style="border-top: 2px solid #000; margin-top: 10px;">
                                                                        <th class="stext-102 cl2"
                                                                            style="color: #000; padding: 15px 0 8px 0; font-weight: bold;">
                                                                            <strong>Total:</strong></th>
                                                                        <td class="stext-102 cl2 text-end"
                                                                            style="color: #000; padding: 15px 0 8px 0; font-weight: bold;">
                                                                            <strong>Rs.
                                                                                {{ number_format($order->total, 0) }}</strong>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            @if ($order->order_notes)
                                                                <div class="p-t-20"
                                                                    style="border-top: 1px solid #e0e0e0; margin-top: 20px;">
                                                                    <h6 class="stext-102 cl2"
                                                                        style="color: #000; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                                                                        Order Notes</h6>
                                                                    <p class="stext-102 cl3" style="color: #666;">
                                                                        {{ $order->order_notes }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer"
                                                            style="background: #f5f5f5; border-top: 2px solid #000;">
                                                            <button type="button"
                                                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04"
                                                                style="background: #000; color: #fff; border: 2px solid #000; padding: 10px 30px; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; cursor: pointer;"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="p-t-30">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="text-center p-t-50 p-b-50">
                                <i class="zmdi zmdi-shopping-bag"
                                    style="font-size: 64px; color: #999; margin-bottom: 20px; display: block;"></i>
                                <h5 class="stext-102 cl3" style="color: #666; margin-bottom: 10px;">No orders yet</h5>
                                <p class="stext-102 cl3" style="color: #999; margin-bottom: 30px;">Start shopping to see
                                    your orders here!</p>
                                <a href="{{ route('shop') }}"
                                    class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04"
                                    style="background: #000; color: #fff; border: 2px solid #000; padding: 12px 40px; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; display: inline-block; text-decoration: none;">
                                    <i class="zmdi zmdi-shopping-cart" style="margin-right: 8px;"></i>Go Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

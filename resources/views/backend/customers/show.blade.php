@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Customer Details</h4>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Customers
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Customer Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name:</th>
                                                <td><strong>{{ $customer->name }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>
                                                    <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                                    @if($customer->email_verified_at)
                                                        <span class="badge badge-success ml-2">
                                                            <i class="mdi mdi-check-circle"></i> Verified
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning ml-2">
                                                            <i class="mdi mdi-alert-circle"></i> Not Verified
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email Verified:</th>
                                                <td>
                                                    @if($customer->email_verified_at)
                                                        {{ $customer->email_verified_at->format('F d, Y h:i A') }}
                                                    @else
                                                        <span class="text-muted">Not verified</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Account Type:</th>
                                                <td>
                                                    <span class="badge badge-primary">{{ ucfirst($customer->type) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Registered:</th>
                                                <td>{{ $customer->created_at->format('F d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Member Since:</th>
                                                <td>{{ $customer->created_at->diffForHumans() }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Order Statistics</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="50%">Total Orders:</th>
                                                <td><strong>{{ $totalOrders }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Pending Orders:</th>
                                                <td>
                                                    <span class="badge badge-warning">{{ $pendingOrders }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Completed Orders:</th>
                                                <td>
                                                    <span class="badge badge-success">{{ $completedOrders }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Spent:</th>
                                                <td>
                                                    <strong class="text-primary">PKR {{ number_format($totalSpent, 2) }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Order History</h5>
                            </div>
                            <div class="card-body">
                                @if($customer->orders->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order Number</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customer->orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                                                {{ $order->order_number }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                                        <td>{{ $order->items->count() }} item(s)</td>
                                                        <td><strong>PKR {{ number_format($order->total, 2) }}</strong></td>
                                                        <td>
                                                            @if($order->status == 'pending')
                                                                <span class="badge badge-warning">Pending</span>
                                                            @elseif($order->status == 'processing')
                                                                <span class="badge badge-info">Processing</span>
                                                            @elseif($order->status == 'completed')
                                                                <span class="badge badge-success">Completed</span>
                                                            @elseif($order->status == 'cancelled')
                                                                <span class="badge badge-danger">Cancelled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                               class="btn btn-sm btn-info" 
                                                               title="View Order">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center py-4">This customer has not placed any orders yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Payment Screenshot Details</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-cart"></i> View Order
                                </a>
                                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-arrow-left"></i> Back to Payments
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Order Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Order Number:</th>
                                                <td><strong class="text-primary">{{ $order->order_number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
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
                                            </tr>
                                            <tr>
                                                <th>Payment Method:</th>
                                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Amount:</th>
                                                <td><strong class="text-primary">PKR {{ number_format($order->total, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Order Date:</th>
                                                <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Customer Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name:</th>
                                                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>{{ $order->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td>{{ $order->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Type:</th>
                                                <td>
                                                    @if($order->user)
                                                        <span class="badge badge-info">Registered User</span>
                                                        <br><small class="text-muted">User ID: {{ $order->user_id }}</small>
                                                    @else
                                                        <span class="badge badge-secondary">Guest</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Payment Screenshot</h5>
                            </div>
                            <div class="card-body text-center">
                                @if($order->payment_screenshot)
                                    <a href="{{ asset($order->payment_screenshot) }}" target="_blank">
                                        <img src="{{ asset($order->payment_screenshot) }}" 
                                             alt="Payment Screenshot" 
                                             class="img-fluid rounded shadow"
                                             style="max-height: 600px; cursor: pointer; border: 2px solid #ddd;">
                                    </a>
                                    <div class="mt-3">
                                        <a href="{{ asset($order->payment_screenshot) }}" 
                                           target="_blank" 
                                           class="btn btn-primary">
                                            <i class="mdi mdi-download"></i> Download Full Size
                                        </a>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="btn btn-secondary">
                                            <i class="mdi mdi-cart"></i> View Full Order Details
                                        </a>
                                    </div>
                                    <p class="mt-2 mb-0">
                                        <small class="text-muted">Click image to view full size in new tab</small>
                                    </p>
                                @else
                                    <p class="text-muted">No payment screenshot available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


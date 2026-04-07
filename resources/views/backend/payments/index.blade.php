@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Payment Screenshots</h4>
                        </div>
                        
                        <!-- Search and Filter Form -->
                        <div class="mb-4">
                            <form action="{{ route('admin.payments.index') }}" method="GET" class="d-flex align-items-center flex-wrap gap-3">
                                <div class="input-group" style="max-width: 400px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search by order number..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="mdi mdi-magnify"></i> Search
                                        </button>
                                        @if(request('search') || request('payment_method'))
                                            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                                                <i class="mdi mdi-close"></i> Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <select name="payment_method" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Payment Methods</option>
                                        <option value="jazzcash" {{ request('payment_method') == 'jazzcash' ? 'selected' : '' }}>Jazz Cash</option>
                                        <option value="easypaisa" {{ request('payment_method') == 'easypaisa' ? 'selected' : '' }}>Easypaisa</option>
                                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash on Delivery</option>
                                    </select>
                                </div>
                            </form>
                            @if(request('search') || request('payment_method'))
                                <div class="mt-2">
                                    <small class="text-muted">
                                        @if(request('search'))
                                            Showing results for: <strong>"{{ request('search') }}"</strong>
                                        @endif
                                        @if(request('payment_method'))
                                            Payment Method: <strong>{{ ucfirst(str_replace('_', ' ', request('payment_method'))) }}</strong>
                                        @endif
                                        ({{ $payments->total() }} {{ Str::plural('result', $payments->total()) }})
                                    </small>
                                </div>
                            @endif
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Screenshot</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments ?? [] as $payment)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $payment->order_number }}</strong>
                                            </td>
                                            <td>
                                                {{ $payment->first_name }} {{ $payment->last_name }}
                                                @if($payment->user)
                                                    <br><small class="text-muted">User ID: {{ $payment->user_id }}</small>
                                                @else
                                                    <br><small class="text-muted">Guest</small>
                                                @endif
                                            </td>
                                            <td>{{ $payment->email }}</td>
                                            <td>{{ $payment->phone }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>PKR {{ number_format($payment->total, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if($payment->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($payment->status == 'processing')
                                                    <span class="badge badge-info">Processing</span>
                                                @elseif($payment->status == 'completed')
                                                    <span class="badge badge-success">Completed</span>
                                                @elseif($payment->status == 'cancelled')
                                                    <span class="badge badge-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $payment->created_at->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                @if($payment->payment_screenshot)
                                                    <a href="{{ asset($payment->payment_screenshot) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="mdi mdi-image"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="View Details">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.show', $payment->id) }}" 
                                                   class="btn btn-sm btn-secondary" 
                                                   title="View Order">
                                                    <i class="mdi mdi-cart"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <p class="text-muted mb-0">No payment screenshots found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($payments) && $payments->hasPages())
                            <div class="mt-4">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


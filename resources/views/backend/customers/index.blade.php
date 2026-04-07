@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Customers</h4>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Email Verified</th>
                                        <th>Total Orders</th>
                                        <th>Total Spent</th>
                                        <th>Last Order</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers ?? [] as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <strong>{{ $customer->name }}</strong>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                            </td>
                                            <td>
                                                @if($customer->email_verified_at)
                                                    <span class="badge badge-success">
                                                        <i class="mdi mdi-check-circle"></i> Verified
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $customer->email_verified_at->format('M d, Y') }}</small>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="mdi mdi-alert-circle"></i> Not Verified
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $customer->orders_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <strong>PKR {{ number_format($customer->total_spent ?? 0, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if($customer->last_order)
                                                    <a href="{{ route('admin.orders.show', $customer->last_order->id) }}" class="text-primary">
                                                        {{ $customer->last_order->order_number }}
                                                    </a>
                                                    <br>
                                                    <small class="text-muted">{{ $customer->last_order->created_at->format('M d, Y') }}</small>
                                                @else
                                                    <span class="text-muted">No orders</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $customer->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="View Details">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <p class="text-muted mb-0">No customers found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($customers) && $customers->hasPages())
                            <div class="mt-4">
                                {{ $customers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


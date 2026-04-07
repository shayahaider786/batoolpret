@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Orders</h4>
                        </div>
                        
                        <!-- Search Form -->
                        <div class="mb-4">
                            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group" style="max-width: 400px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search orders by order number..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="mdi mdi-magnify"></i> Search
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                                <i class="mdi mdi-close"></i> Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            @if(request('search'))
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Showing results for: <strong>"{{ request('search') }}"</strong>
                                        ({{ $orders->total() }} {{ Str::plural('result', $orders->total()) }})
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
                                        <th>Products</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders ?? [] as $order)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @foreach($order->items->take(3) as $item)
                                                        @if($item->product)
                                                            @if($item->product->image)
                                                                <img src="{{ asset($item->product->image) }}" 
                                                                     alt="{{ $item->product->name }}" 
                                                                     class="img-sm rounded"
                                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                                     title="{{ $item->product->name }}">
                                                            @else
                                                                <div class="img-sm rounded bg-light d-flex align-items-center justify-content-center" 
                                                                     style="width: 40px; height: 40px;"
                                                                     title="{{ $item->product->name }}">
                                                                    <i class="mdi mdi-image"></i>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @if($order->items->count() > 3)
                                                        <span class="badge badge-secondary">+{{ $order->items->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $order->first_name }} {{ $order->last_name }}
                                                @if($order->user)
                                                    <br><small class="text-muted">User ID: {{ $order->user_id }}</small>
                                                @else
                                                    <br><small class="text-muted">Guest</small>
                                                @endif
                                            </td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $order->items->sum('quantity') }} items</span>
                                            </td>
                                            <td>
                                                <strong>PKR {{ number_format($order->total, 2) }}</strong>
                                            </td>
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
                                                {{ $order->created_at->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-grid gap-3">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete order #{{ $order->order_number }}? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <p class="text-muted mb-0">No orders found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($orders) && $orders->hasPages())
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Coupons</h4>
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Coupon
                            </a>
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
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                        <th>Valid From</th>
                                        <th>Valid Until</th>
                                        <th>Usage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($coupons ?? [] as $coupon)
                                        <tr>
                                            <td>{{ $coupon->id }}</td>
                                            <td>
                                                <code class="text-primary">{{ $coupon->code }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $coupon->name }}</strong>
                                                @if($coupon->description)
                                                    <br><small class="text-muted">{{ Str::limit($coupon->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $coupon->discount_percent }}% OFF</span>
                                            </td>
                                            <td>
                                                @if($coupon->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->valid_from)
                                                    {{ \Carbon\Carbon::parse($coupon->valid_from)->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->valid_until)
                                                    {{ \Carbon\Carbon::parse($coupon->valid_until)->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->usage_limit)
                                                    {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                                                @else
                                                    {{ $coupon->used_count }} / <span class="text-muted">∞</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-grid gap-3">
                                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete coupon {{ $coupon->code }}?');">
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
                                                <p class="text-muted mb-0">No coupons found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($coupons) && $coupons->hasPages())
                            <div class="mt-4">
                                {{ $coupons->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


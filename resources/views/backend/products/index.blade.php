@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Products</h4>
                            
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Product
                            </a>
                        </div>
                        
                        <!-- Search Form -->
                        <div class="mb-4">
                            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group" style="max-width: 400px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search products by name..." 
                                           value="{{ request('search') }}"
                                           >
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="mdi mdi-magnify"></i> Search
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
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
                                        ({{ $products->total() }} {{ Str::plural('result', $products->total()) }})
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
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products ?? [] as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ asset($product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="img-sm rounded"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="img-sm rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="mdi mdi-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                @if($product->short_description)
                                                    <br><small class="text-muted">{{ Str::limit($product->short_description, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->sku)
                                                    <code class="text-primary">{{ $product->sku }}</code>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->size)
                                                    @php
                                                        $sizes = is_array($product->size) ? $product->size : [$product->size];
                                                    @endphp
                                                    @foreach($sizes as $size)
                                                        <span class="badge badge-secondary mr-1">{{ strtoupper($size) }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->color)
                                                    <span class="badge badge-light">{{ $product->color }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->category)
                                                    <span class="badge badge-info">{{ $product->category->name }}</span>
                                                @else
                                                    <span class="badge badge-secondary">Uncategorized</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->discount_price)
                                                    <div>
                                                        <span class="text-decoration-line-through text-muted">PKR {{ number_format($product->price, 2) }}</span>
                                                        <br>
                                                        <strong class="text-danger">PKR {{ number_format($product->discount_price, 2) }}</strong>
                                                    </div>
                                                @else
                                                    <strong>PKR {{ number_format($product->price, 2) }}</strong>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->discount_percent)
                                                    <span class="badge badge-danger">{{ $product->discount_percent }}% OFF</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-grid gap-3">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                                            <td colspan="12" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="mdi mdi-package-variant" style="font-size: 48px;"></i>
                                                    <p class="mt-2">No products found</p>
                                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                                        <i class="mdi mdi-plus"></i> Add Your First Product
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($products) && $products->hasPages())
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

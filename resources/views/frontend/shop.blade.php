@extends('layouts.frontend')

@push('canonical')
    @php
        $canonicalParams = [];
        if(request('categories')) {
            $canonicalParams['categories'] = request('categories');
        }
        if(request('tag')) {
            $canonicalParams['tag'] = request('tag');
        }
        if(request('sale')) {
            $canonicalParams['sale'] = request('sale');
        }
    @endphp
    <link rel="canonical" href="{{ route('shop', $canonicalParams) }}">
@endpush

@section('content')

<div class="bg-white">
    <div class="container headerTop p-5">

    </div>
</div>

<!-- Product Section -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <!-- Product Count Display -->
        @if(isset($products) && $products->total() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <p class="stext-107 cl6">
                        Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products
                    </p>
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="row isotope-grid">
            @forelse($products ?? [] as $product)
                @php
                    $primaryImage = $product->image
                        ? asset($product->image)
                        : asset('frontend/images/product-1.png');
                    $secondaryImage = $product->images && $product->images->count() > 0
                        ? asset($product->images->first()->image)
                        : $primaryImage;
                    $discountPercent = $product->discount_price && $product->price > 0
                        ? round((($product->price - $product->discount_price) / $product->price) * 100)
                        : null;
                    $categorySlug = $product->category ? strtolower(str_replace(' ', '', $product->category->name)) : '';
                @endphp
                <div class="col-6 col-lg-3 isotope-item {{ $categorySlug }} mb-4">
                    <div class="product-card">
                        <div class="product-image position-relative">
                            @if ($discountPercent)
                                <span class="pre-order-badge">{{ $discountPercent }}% off</span>
                            @endif
                            <a href="{{ route('productDetail', $product->slug) }}">
                                <img class="img-primary w-100" src="{{ $primaryImage }}" alt="{{ $product->name }}" loading="lazy">
                                <img class="img-secondary w-100" src="{{ $secondaryImage }}" alt="{{ $product->name }} Hover" loading="lazy">
                            </a>
                        </div>
                        <div class="product-info mt-3">
                            <a href="{{ route('productDetail', $product->slug) }}" class="product-name-link text-decoration-none text-dark">
                                <h3 class="product-name h6 mb-1">{{ strtoupper($product->name) }}</h3>
                                <p class="product-price mb-0">
                                    @if ($product->discount_price)
                                        Rs. {{ number_format($product->discount_price, 0) }}
                                        @if ($product->price > $product->discount_price)
                                            <span  style="text-decoration: line-through; color: #999; font-size: 0.9em; margin-left: 5px;">
                                                Rs. {{ number_format($product->price, 0) }}
                                            </span>
                                        @endif
                                    @else
                                        Rs. {{ number_format($product->price, 0) }}
                                    @endif
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found.</p>
                </div>
            @endforelse
        </div>

        <!-- Traditional Pagination -->
        @if(isset($products) && $products->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <div class="shop-pagination">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
    /* Pagination Styles */
    .shop-pagination {
        margin-top: 2rem;
    }

    .shop-pagination .pagination {
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 0;
    }

    .shop-pagination .page-item {
        margin: 0 2px;
    }

    .shop-pagination .page-link {
        color: #333;
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 8px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
        border-radius: 4px;
    }

    .shop-pagination .page-link:hover {
        background-color: #000;
        color: #fff;
        border-color: #000;
        transform: translateY(-2px);
    }

    .shop-pagination .page-item.active .page-link {
        background-color: #000;
        border-color: #000;
        color: #fff;
    }

    .shop-pagination .page-item.disabled .page-link {
        color: #999;
        background-color: #f8f9fa;
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .shop-pagination .page-link {
            padding: 6px 10px;
            font-size: 12px;
        }

        .product-name {
            font-size: 12px;
        }

        .product-price {
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .shop-pagination .page-link {
            padding: 5px 8px;
            font-size: 11px;
        }
    }
</style>
@endpush

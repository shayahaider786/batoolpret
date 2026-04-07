@extends('layouts.frontend')

@push('canonical')
    @php
        $canonicalParams = [];
        if(request('tag')) {
            $canonicalParams['tag'] = request('tag');
        }
        if(request('sort')) {
            $canonicalParams['sort'] = request('sort');
        }
        if(request('min_price') || request('max_price')) {
            if(request('min_price')) $canonicalParams['min_price'] = request('min_price');
            if(request('max_price')) $canonicalParams['max_price'] = request('max_price');
        }
    @endphp
    <link rel="canonical" href="{{ route('shop', $canonicalParams) }}">
@endpush

@section('content')

<div class="bg-white">
    <div class="container headerTop p-5">

    </div>
</div>

<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">

        <div class="row isotope-grid">
            @forelse($products ?? [] as $product)
                @php
                    $primaryImage = $product->image
                        ? asset($product->image)
                        : asset('frontend/images/product-1.png');
                    $secondaryImage =
                        $product->images && $product->images->count() > 0
                            ? asset($product->images->first()->image)
                            : $primaryImage;
                    $discountPercent =
                        $product->discount_price && $product->price > 0
                            ? round((($product->price - $product->discount_price) / $product->price) * 100)
                            : null;
                    $categorySlug = $product->category ? strtolower(str_replace(' ', '', $product->category->name)) : '';

                    // Prepare all product images for Quick View modal
                    $allImages = [$primaryImage];
                    if ($product->images && $product->images->count() > 0) {
                        foreach ($product->images as $img) {
                            $allImages[] = asset($img->image);
                        }
                    }
                @endphp
                <div class="col-6 col-lg-3 isotope-item {{ $categorySlug }}">
                    <div class="product-card">
                        <div class="product-image">
                            @if ($discountPercent)
                                <span class="pre-order-badge">{{ $discountPercent }}% off</span>
                            @endif
                            <a href="{{ route('productDetail', $product->slug) }}">
                                <img class="img-primary" src="{{ $primaryImage }}" alt="{{ $product->name }}" loading="lazy">
                                <img class="img-secondary" src="{{ $secondaryImage }}"
                                    alt="{{ $product->name }} Hover" loading="lazy">
                            </a>

                        </div>
                        <div class="product-info">
                            <a href="{{ route('productDetail', $product->slug) }}" class="product-name-link"
                                style="text-decoration: none; color: inherit;">
                                <h3 class="product-name">{{ strtoupper($product->name) }}</h3>
                                <p class="product-price">
                                    @if ($product->discount_price)
                                        Rs. {{ number_format($product->discount_price, 0) }}
                                        @if ($product->price > $product->discount_price)
                                            <span
                                                style="text-decoration: line-through; color: #999; font-size: 0.9em; margin-left: 5px;">
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
                <div class="col-12 text-center">
                    <p class="text-muted">No products found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>


@endsection

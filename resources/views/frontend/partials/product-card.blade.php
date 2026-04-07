{{-- Product Card Component with Lazy Loading

    Usage:
    @include('frontend.partials.product-card', [
        'product' => $product,
        'isFirst' => $loop->first ?? false,
        'columnClasses' => 'col-6 col-lg-3'
    ])
--}}

@php
    // Set default column classes
    $columnClasses = $columnClasses ?? 'col-6 col-lg-3';
    $isFirst = $isFirst ?? false;

    // Get primary image
    $primaryImage = $product->image
        ? asset($product->image)
        : asset('frontend/images/product-1.png');

    // Get secondary/hover image
    $secondaryImage = $product->images && $product->images->count() > 0
        ? asset($product->images->first()->image)
        : $primaryImage;

    // Calculate discount percentage
    $discountPercent = ($product->discount_price && $product->price > 0)
        ? round((($product->price - $product->discount_price) / $product->price) * 100)
        : null;

    // Determine image type for picture element
    $imageExtension = $product->image ? pathinfo($product->image, PATHINFO_EXTENSION) : 'png';
    $imageType = match(strtolower($imageExtension)) {
        'webp' => 'image/webp',
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        default => 'image/jpeg'
    };

    // Determine loading strategy
    $loadingStrategy = $isFirst ? 'eager' : 'lazy';
@endphp

<div class="{{ $columnClasses }}">
    <div class="product-card">
        <!-- Product Image Container -->
        <div class="product-image">
            <!-- Discount/New Badge -->
            @if ($discountPercent)
                <span class="pre-order-badge" title="Discount {{ $discountPercent }}%">
                    {{ $discountPercent }}% off
                </span>
            @else
                <span class="pre-order-badge">New</span>
            @endif

            <!-- Product Link with Images -->
            <a href="{{ route('productDetail', $product->slug) }}" class="product-image-link">
                <!-- Primary Image with Picture Element for Format Support -->
                <picture>
                    <source srcset="{{ $primaryImage }}" type="{{ $imageType }}">
                    <img
                        class="img-primary"
                        src="{{ $primaryImage }}"
                        alt="{{ $product->name }}"
                        loading="{{ $loadingStrategy }}"
                        decoding="async"
                        width="280"
                        height="280"
                    >
                </picture>

                <!-- Secondary/Hover Image -->
                <img
                    class="img-secondary"
                    src="{{ $secondaryImage }}"
                    alt="{{ $product->name }} - Alternate View"
                    loading="lazy"
                    decoding="async"
                    width="280"
                    height="280"
                >
            </a>
        </div>

        <!-- Product Information -->
        <div class="product-info">
            <a
                href="{{ route('productDetail', $product->slug) }}"
                class="product-name-link"
                style="text-decoration: none; color: inherit;"
            >
                <!-- Product Name -->
                <h3 class="product-name">{{ strtoupper($product->name) }}</h3>

                <!-- Product Price -->
                <p class="product-price">
                    @if ($product->discount_price)
                        <span class="price-current">
                            Rs. {{ number_format($product->discount_price, 0) }}
                        </span>
                        @if ($product->price > $product->discount_price)
                            <span class="price-original" style="text-decoration: line-through; color: #999; font-size: 0.9em; margin-left: 5px;">
                                Rs. {{ number_format($product->price, 0) }}
                            </span>
                        @endif
                    @else
                        <span class="price-current">
                            Rs. {{ number_format($product->price, 0) }}
                        </span>
                    @endif
                </p>
            </a>
        </div>
    </div>
</div>

@extends('layouts.frontend')

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
@endphp

@push('meta')
    <title>{{ $product->meta_title ?? $product->name }} - Zaylish</title>
    <meta name="description"
        content="{{ $product->meta_description ?? ($product->short_description ?? 'Discover ' . $product->name . ' at Zaylish. Premium quality fashion and lifestyle products.') }}">
    @if ($product->meta_keywords)
        <meta name="keywords" content="{{ $product->meta_keywords }}">
    @endif
    @if ($product->meta_tags)
        <meta name="tags" content="{{ $product->meta_tags }}">
    @endif
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ route('productDetail', $product->slug) }}">
    <meta property="og:title" content="{{ $product->meta_title ?? $product->name }}">
    <meta property="og:description" content="{{ $product->meta_description ?? ($product->short_description ?? '') }}">
    @if ($product->image)
        <meta property="og:image" content="{{ asset($product->image) }}">
    @endif
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('productDetail', $product->slug) }}">
    <meta property="twitter:title" content="{{ $product->meta_title ?? $product->name }}">
    <meta property="twitter:description" content="{{ $product->meta_description ?? ($product->short_description ?? '') }}">
    @if ($product->image)
        <meta property="twitter:image" content="{{ asset($product->image) }}">
    @endif

    <!-- Preload critical images for faster loading -->
    @if ($product->image)
        <link rel="preload" as="image" href="{{ asset($product->image) }}" fetchpriority="high">
    @endif
@endpush

@push('canonical')
    <link rel="canonical" href="{{ route('productDetail', $product->slug) }}">
@endpush

@section('content')

    <!-- Facebook ViewContent Tracking -->
    @push('scripts')
    <script>
        // Track product view when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', {
                    content_ids: ['{{ $product->id }}'],
                    content_type: 'product',
                    value: {{ $product->discount_price ?? $product->price }},
                    currency: 'PKR'
                });
            }

            // TikTok ViewContent Tracking
            if (typeof ttq !== 'undefined') {
                ttq.track('ViewContent', {
                    content_id: '{{ $product->id }}',
                    content_type: 'product',
                    content_name: '{{ $product->name }}',
                    content_category: '{{ $product->category ? $product->category->name : '' }}',
                    value: {{ $product->discount_price ?? $product->price }},
                    currency: 'PKR'
                });
            }
        });

        // AddToCart tracking function (Facebook & TikTok)
        function trackAddToCart() {
            if (typeof fbq !== 'undefined') {
                fbq('track', 'AddToCart', {
                    content_ids: ['{{ $product->id }}'],
                    content_type: 'product',
                    value: {{ $product->discount_price ?? $product->price }},
                    currency: 'PKR'
                });
            }

            if (typeof ttq !== 'undefined') {
                ttq.track('AddToCart', {
                    content_id: '{{ $product->id }}',
                    content_type: 'product',
                    content_name: '{{ $product->name }}',
                    content_category: '{{ $product->category ? $product->category->name : '' }}',
                    quantity: document.getElementById('product-quantity')?.value || 1,
                    value: {{ $product->discount_price ?? $product->price }},
                    currency: 'PKR'
                });
            }
        }

        // Enhanced AddToCart with size and quantity
        function trackAddToCartWithDetails(size, quantity) {
            if (typeof ttq !== 'undefined') {
                ttq.track('AddToCart', {
                    content_id: '{{ $product->id }}',
                    content_type: 'product',
                    content_name: '{{ $product->name }}',
                    content_category: '{{ $product->category ? $product->category->name : '' }}',
                    content_size: size,
                    quantity: quantity,
                    value: ({{ $product->discount_price ?? $product->price }} * quantity),
                    currency: 'PKR'
                });
            }
        }
    </script>
    @endpush

    <div class="bg-white">
        <div class="container headerTop p-3">

        </div>
    </div>

    @if (session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 20px;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 20px;">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('index') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            @if ($product->category)
                <a href="{{ route('shop', ['categories' => [$product->category->id]]) }}"
                    class="stext-109 cl8 hov-cl1 trans-04">
                    {{ $product->category->name }}
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>
            @endif

            <span class="stext-109 cl4">
                {{ $product->name }}
            </span>
        </div>
    </div>


    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <!-- Product Image Gallery -->
                        <div class="product-gallery-wrapper">
                            <!-- Main Image Container -->
                            <div class="main-image-container pos-relative">
                                <!-- Main Image with Navigation -->
                                <div class="wrap-slick3-main">
                                    <div class="wrap-slick3-arrows-main">
                                        <button class="arrow-slick3-main prev-slick3-main" type="button">
                                            <i class="zmdi zmdi-chevron-left"></i>
                                        </button>
                                        <button class="arrow-slick3-main next-slick3-main" type="button">
                                            <i class="zmdi zmdi-chevron-right"></i>
                                        </button>
                                    </div>

                                    <div class="slick3-main gallery-lb">
                                        @php
                                            $allImages = collect();
                                            if ($product->image) {
                                                $allImages->push(['path' => $product->image, 'type' => 'main']);
                                            }
                                            if ($product->images && $product->images->count() > 0) {
                                                foreach ($product->images as $img) {
                                                    $allImages->push(['path' => $img->image, 'type' => 'additional']);
                                                }
                                            }
                                            if ($allImages->isEmpty()) {
                                                $allImages->push([
                                                    'path' => 'frontend/images/product-1.png',
                                                    'type' => 'default',
                                                ]);
                                            }
                                        @endphp
                                        @foreach ($allImages as $index => $img)
                                            <div class="item-slick3-main" data-thumb="{{ asset($img['path']) }}">
                                                <div class="wrap-pic-w pos-relative">
                                                    <img src="{{ asset($img['path']) }}"
                                                        alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                                        fetchpriority="{{ $index === 0 ? 'high' : 'low' }}"
                                                        decoding="{{ $index === 0 ? 'sync' : 'async' }}" width="800"
                                                        height="800">
                                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                        href="{{ asset($img['path']) }}">
                                                        <i class="fa fa-expand"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnail Row -->
                            <div class="product-thumbnails">
                                @foreach ($allImages as $index => $img)
                                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                        data-index="{{ $index }}">
                                        <img src="{{ asset($img['path']) }}" alt="Thumbnail {{ $index + 1 }}"
                                            loading="lazy" decoding="async" width="100" height="100">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>

                        <span class="mtext-106 cl2">
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
                        </span>

                        @if ($product->short_description)
                            <p class="stext-102 cl3 p-t-23">
                                {{ $product->short_description }}
                            </p>
                        @endif

                        <!--  -->
                        <div class="det">
                            <!-- Product Attributes Section -->
                            <div class="product-attribute-section p-t-0">
                                @if ($product->fabric)
                                    <!-- Fabric Info -->
                                    <div class="attribute-group">
                                        <div class="fabric-info-container">
                                            <div class="fabric-info-text">
                                                <span class="attribute-label">Fabric Type</span>
                                                <div class="fabric-info">{{ $product->fabric }}</div>
                                            </div>
                                            {{-- <div class="quality-badge">
                                                <i class="zmdi zmdi-check"></i>
                                                <span>Premium Quality</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endif

                                @if ($product->size && is_array($product->size) && count($product->size) > 0)
                                    <!-- Size Selection -->
                                    <div class="attribute-group">
                                        <div class="size-label-header">
                                            <span class="attribute-label">Select Size</span>
                                            @if ($product->size_guide_image)
                                                <a href="#" class="size-guide-link js-show-size-guide-modal"
                                                    data-size-guide-image="{{ asset($product->size_guide_image) }}">📏
                                                    Size Guide</a>
                                            @else
                                                <span class="size-guide-link"
                                                    style="opacity: 0.5; cursor: not-allowed;">📏 Size Guide</span>
                                            @endif
                                        </div>
                                        <div class="size-options-wrapper">
                                            @foreach ($product->size as $index => $size)
                                                @php
                                                    $sizeId = 'size-' . strtolower($size) . '-detail';
                                                    $sizeValue = strtolower($size);
                                                @endphp
                                                <input type="radio" id="{{ $sizeId }}" class="attribute-input"
                                                    name="product-size" value="{{ $size }}"
                                                    {{ $index === 0 ? 'checked' : '' }}>
                                                <label for="{{ $sizeId }}" class="size-options-wrapper label"
                                                    data-size="{{ $size }}">{{ strtoupper($size) }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="product-actions">
                                <!-- Quantity Selector -->
                                <div class="wrap-num-product">
                                    <button type="button" class="btn-num-product-down">
                                        <i class="zmdi zmdi-minus"></i>
                                    </button>
                                    <input class="num-product" type="number" name="quantity" id="product-quantity"
                                        value="1" min="1" max="{{ $product->stock ?? 999 }}">
                                    <button type="button" class="btn-num-product-up">
                                        <i class="zmdi zmdi-plus"></i>
                                    </button>
                                </div>

                                <!-- Add to Cart Button -->
                                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form"
                                    style="display: flex; flex: 1; width: 100%;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="cart-quantity-input" value="1">
                                    <input type="hidden" name="size" id="cart-size-input" value="">
                                    <button type="submit" class="js-addcart-detail add-to-cart-btn">
                                        <i class="zmdi zmdi-shopping-cart"></i>Add to Cart
                                    </button>
                                </form>

                                <!-- Order Now Button -->
                                <form action="{{ route('cart.add') }}" method="POST" id="order-now-form"
                                    style="display: flex; flex: 1; width: 100%; margin-left: 10px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="order-quantity-input" value="1">
                                    <input type="hidden" name="size" id="order-size-input" value="">
                                    <input type="hidden" name="redirect_to_checkout" value="1">
                                    <button type="submit" class="js-addcart-detail order-now-btn"
                                        style="background: #000; color: #fff;">
                                        <i class="zmdi zmdi-check"></i>Order Now
                                    </button>
                                </form>
                            </div>

                            @push('scripts')
                                <script defer>
                                    $(document).ready(function() {
                                        // Set initial size (first checked or first available)
                                        var initialSize = $('input[name="product-size"]:checked').val();
                                        if (!initialSize && $('input[name="product-size"]').length > 0) {
                                            $('input[name="product-size"]').first().prop('checked', true);
                                            initialSize = $('input[name="product-size"]').first().val();
                                        }
                                        // Ensure size is set in the hidden inputs
                                        if (initialSize) {
                                            $('#cart-size-input').val(initialSize);
                                            $('#order-size-input').val(initialSize);
                                        }

                                        // Update size when size selection changes
                                        $('input[name="product-size"]').on('change', function() {
                                            var selectedSize = $(this).val();
                                            $('#cart-size-input').val(selectedSize);
                                            $('#order-size-input').val(selectedSize);
                                        });

                                        // Quantity increase/decrease
                                        $('.product-actions .btn-num-product-up').off('click').on('click', function(e) {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            var $input = $('#product-quantity');
                                            var currentVal = parseInt($input.val());
                                            var maxVal = parseInt($input.attr('max'));
                                            if (currentVal < maxVal) {
                                                $input.val(currentVal + 1);
                                                $('#cart-quantity-input').val(currentVal + 1);
                                                $('#order-quantity-input').val(currentVal + 1);
                                            }
                                        });

                                        $('.product-actions .btn-num-product-down').off('click').on('click', function(e) {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            var $input = $('#product-quantity');
                                            var currentVal = parseInt($input.val());
                                            if (currentVal > 1) {
                                                $input.val(currentVal - 1);
                                                $('#cart-quantity-input').val(currentVal - 1);
                                                $('#order-quantity-input').val(currentVal - 1);
                                            }
                                        });

                                        $('#product-quantity').on('change', function() {
                                            var qty = $(this).val();
                                            $('#cart-quantity-input').val(qty);
                                            $('#order-quantity-input').val(qty);
                                        });

                                        // Add to cart form submission with TikTok tracking
                                        $('#add-to-cart-form').on('submit', function(e) {
                                            e.preventDefault();
                                            var $form = $(this);
                                            var $button = $form.find('button[type="submit"]');
                                            var selectedSize = $('input[name="product-size"]:checked').val();
                                            var quantity = $('#product-quantity').val();

                                            // Track TikTok AddToCart event before submission
                                            if (typeof ttq !== 'undefined') {
                                                ttq.track('AddToCart', {
                                                    content_id: '{{ $product->id }}',
                                                    content_type: 'product',
                                                    content_name: '{{ $product->name }}',
                                                    content_category: '{{ $product->category ? $product->category->name : '' }}',
                                                    content_size: selectedSize || '',
                                                    quantity: parseInt(quantity),
                                                    value: {{ $product->discount_price ?? $product->price }} * parseInt(quantity),
                                                    currency: 'PKR'
                                                });
                                            }

                                            if ($button.prop('disabled')) return false;
                                            $button.prop('disabled', true).html('<i class="zmdi zmdi-shopping-cart"></i>Adding...');

                                            if (!selectedSize && $('input[name="product-size"]').length > 0) {
                                                selectedSize = $('input[name="product-size"]').first().val();
                                                $('input[name="product-size"]').first().prop('checked', true);
                                            }
                                            $('#cart-size-input').val(selectedSize || '');

                                            $.ajax({
                                                url: $form.attr('action'),
                                                method: 'POST',
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    window.location.href = '{{ route('cart') }}';
                                                },
                                                error: function(xhr) {
                                                    $button.prop('disabled', false).html(
                                                        '<i class="zmdi zmdi-shopping-cart"></i>Add to Cart');
                                                    var errorMsg = xhr.responseJSON?.message ||
                                                        'Error adding product to cart';
                                                    if (typeof swal !== 'undefined') {
                                                        swal("Error!", errorMsg, "error");
                                                    } else {
                                                        alert(errorMsg);
                                                    }
                                                }
                                            });
                                        });

                                        // Order Now form submission with TikTok tracking
                                        $('#order-now-form').on('submit', function(e) {
                                            e.preventDefault();
                                            var $form = $(this);
                                            var $button = $form.find('button[type="submit"]');
                                            var selectedSize = $('input[name="product-size"]:checked').val();
                                            var quantity = $('#product-quantity').val();

                                            // Track TikTok AddToCart event before submission
                                            if (typeof ttq !== 'undefined') {
                                                ttq.track('AddToCart', {
                                                    content_id: '{{ $product->id }}',
                                                    content_type: 'product',
                                                    content_name: '{{ $product->name }}',
                                                    content_category: '{{ $product->category ? $product->category->name : '' }}',
                                                    content_size: selectedSize || '',
                                                    quantity: parseInt(quantity),
                                                    value: {{ $product->discount_price ?? $product->price }} * parseInt(quantity),
                                                    currency: 'PKR'
                                                });
                                            }

                                            if ($button.prop('disabled')) return false;
                                            $button.prop('disabled', true).html('<i class="zmdi zmdi-check"></i>Processing...');

                                            if (!selectedSize && $('input[name="product-size"]').length > 0) {
                                                selectedSize = $('input[name="product-size"]').first().val();
                                                $('input[name="product-size"]').first().prop('checked', true);
                                            }
                                            $('#order-size-input').val(selectedSize || '');

                                            $.ajax({
                                                url: $form.attr('action'),
                                                method: 'POST',
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    window.location.href = '{{ route('checkout') }}';
                                                },
                                                error: function(xhr) {
                                                    $button.prop('disabled', false).html(
                                                        '<i class="zmdi zmdi-check"></i>Order Now');
                                                    var errorMsg = xhr.responseJSON?.message || 'Error processing order';
                                                    if (typeof swal !== 'undefined') {
                                                        swal("Error!", errorMsg, "error");
                                                    } else {
                                                        alert(errorMsg);
                                                    }
                                                }
                                            });
                                        });
                                    });
                                </script>
                            @endpush

                            <!-- Social and WhatsApp -->
                            <div class="product-social-section">
                                @php
                                    $whatsappMessage = "Hi! I'm interested in this product:\n\n";
                                    $whatsappMessage .= 'Product: ' . $product->name . "\n";
                                    $whatsappMessage .=
                                        'Price: Rs. ' .
                                        number_format($product->discount_price ?? $product->price, 0) .
                                        "\n";
                                    $whatsappMessage .= 'Link: ' . route('productDetail', $product->slug);
                                    $whatsappMessage = urlencode($whatsappMessage);
                                @endphp
                                <a href="https://wa.me/923144707099?text={{ $whatsappMessage }}" target="_blank"
                                    rel="noopener noreferrer" class="whatsapp-order-btn" title="Order on WhatsApp">
                                    <i class="fa fa-whatsapp"></i>
                                    <span>Order On WhatsApp</span>
                                </a>

                                <!-- Social Share Buttons -->
                                <div class="social-buttons">
                                    <a href="https://www.instagram.com/zaylishstudio" class="social-btn"
                                        title="Instagram">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="p-t-43 p-b-40">
                        <!-- Additional Information Section -->
                        <div class="additional-info-section">
                            <div class="additional-info-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="mtext-108 cl2 p-b-30">Description</h3>
                                        <ul class="stext-102 cl6 p-lr-20 p-lr-15-sm" style="list-style: disc;">
                                            @if ($product->fabric)
                                                <li class="p-b-7"><b>Fabric: </b> {{ $product->fabric }}</li>
                                            @endif

                                            @if ($product->color)
                                                <li class="p-b-7"><b>Color: </b> {{ $product->color }}</li>
                                            @endif

                                            @if ($product->size && is_array($product->size) && count($product->size) > 0)
                                                <li class="p-b-7"><b>Size: </b>
                                                    {{ implode(', ', array_map('strtoupper', $product->size)) }}</li>
                                            @endif

                                            @if ($product->outfit_type)
                                                <li class="p-b-7"><b>Outfit Type: </b> {{ $product->outfit_type }}</li>
                                            @endif

                                            @if ($product->design_details)
                                                <li class="p-b-7"><b>Design Details: </b> {{ $product->design_details }}
                                                </li>
                                            @endif

                                            @if ($product->includes)
                                                <li class="p-b-7"><b>Includes: </b> {{ $product->includes }}</li>
                                            @endif

                                            @if ($product->care_instructions)
                                                <li class="p-b-7"><b>Care Instructions: </b>
                                                    {{ $product->care_instructions }}</li>
                                            @endif

                                            @if ($product->disclaimer)
                                                <li class="p-b-7"> <b>Disclaimer: </b>{{ $product->disclaimer }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- review section --}}
            <div class="row">
                <div class="col-md-6 m-4">
                    <div class="p-b-30 m-lr-15-sm">
                        @if ($product->approvedReviews && $product->approvedReviews->count() > 0)
                            @foreach ($product->approvedReviews as $review)
                                <!-- Review -->
                                <div class="flex-w flex-t p-b-68">
                                    <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                        @php
                                            $reviewerName = $review->user ? $review->user->name : ($review->name ?? 'Anonymous');
                                            $initial = strtoupper(substr($reviewerName, 0, 1));
                                        @endphp
                                        <div class="avatar-initial" style="width: 100%; height: 100%; border-radius: 50%; background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(0, 0, 0) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; font-weight: bold; text-transform: uppercase;">
                                            {{ $initial }}
                                        </div>
                                    </div>

                                    <div class="size-207">
                                        <div class="flex-w flex-sb-m p-b-17">
                                            <div>
                                                <span class="mtext-107 cl2 p-r-20">
                                                    {{ $review->user ? $review->user->name : ($review->name ?? 'Anonymous') }}
                                                </span>
                                                @if($review->title)
                                                    <div class="stext-101 cl2 p-t-5" style="font-weight: 600;">
                                                        {{ $review->title }}
                                                    </div>
                                                @endif
                                            </div>

                                            <span class="fs-18 cl11">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($review->rating))
                                                        <i class="zmdi zmdi-star"></i>
                                                    @elseif($i - 0.5 <= $review->rating)
                                                        <i class="zmdi zmdi-star-half"></i>
                                                    @else
                                                        <i class="zmdi zmdi-star-outline"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                        </div>

                                        @if ($review->comment)
                                            <p class="stext-102 cl6">
                                                {{ $review->comment }}
                                            </p>
                                        @endif

                                        @if ($review->images && is_array($review->images) && count($review->images) > 0)
                                            <div class="review-images mt-3">
                                                <span class="stext-102 cl3">Images </span>
                                                <div class="d-flex flex-wrap mt-2">
                                                    @foreach ($review->images as $img)
                                                        <a href="{{ asset($img) }}" target="_blank" style="margin-right: 8px; margin-bottom: 8px;">
                                                            <img src="{{ asset($img) }}" alt="Review Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="stext-102 cl6">No reviews yet. Be the first to review this product!
                            </p>
                        @endif

                        <!-- Add review -->
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

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <form action="{{ route('reviews.store') }}" method="POST" class="w-full" id="review-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <h5 class="mtext-108 cl2 p-b-7">
                                Add a review
                            </h5>

                            <div class="flex-w flex-m p-t-50 p-b-23">
                                <span class="stext-102 cl3 m-r-16">
                                    Your Rating <span class="text-danger">*</span>
                                </span>

                                <span class="wrap-rating fs-18 cl11 pointer" id="rating-wrapper">
                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-rating="1"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-rating="2"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-rating="3"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-rating="4"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-rating="5"></i>
                                    <input class="dis-none" type="number" name="rating" id="rating-input" value="" required>
                                </span>
                            </div>

                            <div class="row p-b-25">
                                <div class="col-12 p-b-5">
                                    <label class="stext-102 cl3" for="title">Review Title (Optional)</label>
                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="title"
                                        type="text" name="title" value="{{ old('title') }}" placeholder="Brief summary of your review">
                                </div>

                                <div class="col-12 p-b-5">
                                    <label class="stext-102 cl3" for="comment">Your review <span class="text-danger">*</span></label>
                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="comment" name="comment" rows="5" required minlength="10" placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
                                    <small class="text-muted">Minimum 10 characters required</small>
                                </div>

                                <div class="col-12 p-b-5">
                                    <label class="stext-102 cl3" for="images">Upload Images (Optional)</label>
                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="images" type="file" name="images[]" multiple accept="image/*">
                                    <small class="text-muted">You can upload multiple images.</small>
                                </div>

                                @guest
                                    <div class="col-sm-6 p-b-5">
                                        <label class="stext-102 cl3" for="name">Name <span class="text-danger">*</span></label>
                                        <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name"
                                            type="text" name="name" value="{{ old('name') }}" required>
                                    </div>

                                    <div class="col-sm-6 p-b-5">
                                        <label class="stext-102 cl3" for="email">Email</label>
                                        <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                            type="email" name="email" value="{{ old('email') }}">
                                    </div>
                                @else
                                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                @endguest
                            </div>

                            <button type="submit"
                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                Submit Review
                            </button>
                        </form>

                        @push('scripts')
                        <script defer>
                            $(document).ready(function() {
                                // Ensure rating is set before form submission
                                $('#review-form').on('submit', function(e) {
                                    var rating = $('#rating-input').val();
                                    if (!rating || rating == 0) {
                                        e.preventDefault();
                                        if (typeof swal !== 'undefined') {
                                            swal("Rating Required", "Please select a rating before submitting your review.", "warning");
                                        } else {
                                            alert('Please select a rating before submitting your review.');
                                        }
                                        return false;
                                    }
                                });

                                // Update rating display when clicking stars (enhancement to main.js)
                                $('#rating-wrapper .item-rating').on('click', function() {
                                    var rating = $(this).data('rating');
                                    $('#rating-input').val(rating);
                                    // Color stars
                                    $('#rating-wrapper .item-rating').each(function(i) {
                                        if (i < rating) {
                                            $(this).removeClass('zmdi-star-outline zmdi-star-half').addClass('zmdi-star').css('color', '#FFD700');
                                        } else {
                                            $(this).removeClass('zmdi-star zmdi-star-half').addClass('zmdi-star-outline').css('color', '');
                                        }
                                    });
                                });

                                // Restore colored stars if form is reloaded with old value
                                var oldRating = $('#rating-input').val();
                                if (oldRating) {
                                    $('#rating-wrapper .item-rating').each(function(i) {
                                        if (i < oldRating) {
                                            $(this).removeClass('zmdi-star-outline zmdi-star-half').addClass('zmdi-star').css('color', '#FFD700');
                                        } else {
                                            $(this).removeClass('zmdi-star zmdi-star-half').addClass('zmdi-star-outline').css('color', '');
                                        }
                                    });
                                }
                            });
                        </script>
                        @endpush
                    </div>
                </div>
            </div>

        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            @if ($product->sku)
                <span class="stext-107 cl6 p-lr-25">
                    SKU: {{ $product->sku }}
                </span>
            @endif

            @if ($product->category)
                <span class="stext-107 cl6 p-lr-25">
                    Categories: {{ $product->category->name }}
                </span>
            @endif
        </div>
    </section>


    @if ($product->youtube_link)
        <section class="sec-product-detail bg0 p-t-65 p-b-60">
            <div class="container">
                <div class="row">
                    @if ($product->youtube_link)
                        <div class="col-md-12">
                            <div class="video-container" style="width: 80%; margin: 0 auto;">
                                @php
                                    $videoId = '';
                                    $url = $product->youtube_link;
                                    if (
                                        preg_match(
                                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
                                            $url,
                                            $matches,
                                        )
                                    ) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if ($videoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" frameborder="0"
                                        allowfullscreen loading="lazy"
                                        style="width: 100%; height: 500px; display: block;"></iframe>
                                @else
                                    <iframe src="{{ $product->youtube_link }}" frameborder="0" allowfullscreen
                                        loading="lazy" style="width: 100%; height: 500px; display: block;"></iframe>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    You may also like
                </h3>
            </div>

            <!-- Products Slider -->
            <div class="related-products-slider-wrapper">
                <div class="swiper related-products-swiper">
                    <div class="swiper-wrapper">
                        @forelse($relatedProducts ?? [] as $relatedProduct)
                            @php
                                $primaryImage = $relatedProduct->image
                                    ? asset($relatedProduct->image)
                                    : asset('frontend/images/product-1.png');
                                $secondaryImage =
                                    $relatedProduct->images && $relatedProduct->images->count() > 0
                                        ? asset($relatedProduct->images->first()->image)
                                        : $primaryImage;
                            @endphp
                            <div class="swiper-slide">
                                <div class="product-card">
                                    <div class="product-image">
                                        <a href="{{ route('productDetail', $relatedProduct->slug) }}">
                                            <img class="img-primary" src="{{ $primaryImage }}"
                                                alt="{{ $relatedProduct->name }}" loading="lazy" decoding="async"
                                                width="400" height="400">
                                            <img class="img-secondary" src="{{ $secondaryImage }}"
                                                alt="{{ $relatedProduct->name }} Hover" loading="lazy" decoding="async"
                                                width="400" height="400">
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: hidden; opacity: 0;"
                                            data-product-id="{{ $relatedProduct->id }}">
                                            Quick View
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('productDetail', $relatedProduct->slug) }}"
                                            class="product-name-link" style="text-decoration: none; color: inherit;">
                                            <h3 class="product-name">{{ strtoupper($relatedProduct->name) }}</h3>
                                            <p class="product-price">
                                                @if ($relatedProduct->discount_price)
                                                    Rs. {{ number_format($relatedProduct->discount_price, 0) }}
                                                    @if ($relatedProduct->price > $relatedProduct->discount_price)
                                                        <span
                                                            style="text-decoration: line-through; color: #999; font-size: 0.9em; margin-left: 5px;">
                                                            Rs. {{ number_format($relatedProduct->price, 0) }}
                                                        </span>
                                                    @endif
                                                @else
                                                    Rs. {{ number_format($relatedProduct->price, 0) }}
                                                @endif
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <p class="text-center text-muted">No related products available.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Slider Navigation Buttons -->
                <div class="related-products-nav">
                    <button class="related-products-prev">
                        <i class="zmdi zmdi-chevron-left"></i>
                    </button>
                    <button class="related-products-next">
                        <i class="zmdi zmdi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Size Guide Modal -->
    <div class="wrap-modal-size-guide js-modal-size-guide">
        <div class="overlay-modal-size-guide js-hide-size-guide-modal"></div>
        <div class="container" style="max-width: 800px; position: relative; z-index: 9001;">
            <div class="bg0 p-t-30 p-b-30 p-lr-15-lg p-lr-15-md p-lr-15-sm"
                style="position: relative; border-radius: 8px;">
                <button class="how-pos3 hov3 trans-04 js-hide-size-guide-modal"
                    style="position: absolute; top: 15px; right: 15px; z-index: 9002; background: rgba(255, 255, 255, 0.9); border: none; padding: 10px; border-radius: 50%; cursor: pointer; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="zmdi zmdi-close" style="font-size: 24px; color: #333;"></i>
                </button>
                <div class="p-t-20 p-b-20" style="text-align: center;">
                    <h3 class="mtext-105 cl2 p-b-20" style="text-transform: uppercase; letter-spacing: 1px;">Size Guide
                    </h3>
                    <div class="size-guide-image-container"
                        style="max-width: 100%; overflow: hidden; border-radius: 4px;">
                        <img id="size-guide-modal-image" src="" alt="Size Guide"
                            style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <style>
        .wrap-modal-size-guide {
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 9001;
            overflow: auto;
            visibility: hidden;
            opacity: 0;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrap-modal-size-guide.show-size-guide-modal {
            visibility: visible;
            opacity: 1;
        }

        .overlay-modal-size-guide {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            cursor: pointer;
        }

        .size-guide-link {
            color: #717fe0;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .size-guide-link:hover {
            color: #5a6fd8;
            text-decoration: underline;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Show size guide modal
            $(document).on('click', '.js-show-size-guide-modal', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var sizeGuideImage = $(this).attr('data-size-guide-image');
                console.log('Size guide clicked, image:', sizeGuideImage); // Debug

                if (sizeGuideImage && sizeGuideImage.trim() !== '') {
                    var $modal = $('.js-modal-size-guide');
                    var $img = $('#size-guide-modal-image');

                    // Set image source
                    $img.attr('src', sizeGuideImage);

                    // Handle image load error
                    $img.on('error', function() {
                        console.error('Failed to load size guide image:', sizeGuideImage);
                        alert('Failed to load size guide image. Please try again later.');
                    });

                    // Show modal
                    $modal.addClass('show-size-guide-modal');
                    $('body').css('overflow', 'hidden');

                    console.log('Modal should be visible now');
                } else {
                    console.error('No size guide image provided');
                }
            });

            // Hide size guide modal
            $(document).on('click', '.js-hide-size-guide-modal, .overlay-modal-size-guide', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.js-modal-size-guide').removeClass('show-size-guide-modal');
                $('body').css('overflow', '');
            });

            // Close modal on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    if ($('.js-modal-size-guide').hasClass('show-size-guide-modal')) {
                        $('.js-modal-size-guide').removeClass('show-size-guide-modal');
                        $('body').css('overflow', '');
                    }
                }
            });
        });
    </script>
@endpush

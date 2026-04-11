@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('checkout') }}">
@endpush

@section('content')

    <!-- Facebook & TikTok Tracking Scripts -->
    @push('scripts')
        <script>
            // Track Checkout Initiation when page loads
            document.addEventListener('DOMContentLoaded', function() {
                // Get cart items for tracking
                var cartItems = [];
                var productIds = [];
                var productNames = [];
                var totalValue = {{ isset($total) ? $total : (isset($subtotal) ? $subtotal : 0) }};
                var itemCount = {{ isset($cartItems) ? $cartItems->count() : 0 }};

                @if (isset($cartItems) && $cartItems->count() > 0)
                    @foreach ($cartItems as $item)
                        cartItems.push({
                            id: '{{ $item->product_id }}',
                            name: '{{ $item->product ? addslashes($item->product->name) : 'Product' }}',
                            quantity: {{ $item->quantity }},
                            price: {{ $item->price }}
                        });
                        productIds.push('{{ $item->product_id }}');
                        productNames.push('{{ $item->product ? addslashes($item->product->name) : 'Product' }}');
                    @endforeach
                @endif

                // Facebook InitiateCheckout
                if (typeof fbq !== 'undefined') {
                    fbq('track', 'InitiateCheckout', {
                        content_ids: productIds,
                        content_type: 'product',
                        value: totalValue,
                        currency: 'PKR',
                        num_items: itemCount
                    });
                }

                // TikTok InitiateCheckout
                if (typeof ttq !== 'undefined') {
                    ttq.track('InitiateCheckout', {
                        content_id: productIds.join(','),
                        content_type: 'product',
                        content_name: productNames.join(', '),
                        quantity: itemCount,
                        value: totalValue,
                        currency: 'PKR'
                    });
                }
            });

            // Function to track purchase after successful order
            function trackPurchase(orderData) {
                // Facebook Purchase tracking
                if (typeof fbq !== 'undefined' && orderData) {
                    fbq('track', 'Purchase', {
                        content_ids: orderData.product_ids || [],
                        content_type: 'product',
                        value: orderData.total || 0,
                        currency: 'PKR',
                        num_items: orderData.item_count || 0
                    });
                }

                // TikTok CompletePayment tracking
                if (typeof ttq !== 'undefined' && orderData) {
                    ttq.track('CompletePayment', {
                        content_id: orderData.order_number || orderData.order_id,
                        content_name: orderData.order_number ? 'Order #' + orderData.order_number : 'Order',
                        content_type: 'product',
                        content_category: 'checkout',
                        quantity: orderData.item_count || 0,
                        value: orderData.total || 0,
                        currency: 'PKR',
                        description: 'Order completed successfully'
                    });

                    // Also track individual products in the order (optional, for better analytics)
                    if (orderData.products && orderData.products.length > 0) {
                        orderData.products.forEach(function(product) {
                            ttq.track('CompletePayment', {
                                content_id: product.id,
                                content_name: product.name,
                                content_type: 'product',
                                quantity: product.quantity,
                                value: product.price * product.quantity,
                                currency: 'PKR'
                            });
                        });
                    }
                }
            }

            // Store order data globally for access after successful submission
            window.currentOrderData = {
                product_ids: [],
                product_names: [],
                products: [],
                item_count: {{ isset($cartItems) ? $cartItems->count() : 0 }},
                total: {{ isset($total) ? $total : (isset($subtotal) ? $subtotal : 0) }}
            };

            @if (isset($cartItems) && $cartItems->count() > 0)
                @foreach ($cartItems as $item)
                    window.currentOrderData.product_ids.push('{{ $item->product_id }}');
                    window.currentOrderData.product_names.push('{{ $item->product ? addslashes($item->product->name) : 'Product' }}');
                    window.currentOrderData.products.push({
                        id: '{{ $item->product_id }}',
                        name: '{{ $item->product ? addslashes($item->product->name) : 'Product' }}',
                        quantity: {{ $item->quantity }},
                        price: {{ $item->price }}
                    });
                @endforeach
            @endif
        </script>
    @endpush

    <style>
        /* Bank Details Section */
        .bank-details-section {
            margin-bottom: 20px;
            width: 100%;
        }

        .bank-details-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .bank-detail-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .bank-detail-row:last-of-type {
            border-bottom: none;
        }

        .bank-detail-label {
            font-weight: 600;
            color: #495057;
            width: 120px;
            font-size: 14px;
        }

        .bank-detail-value {
            color: #212529;
            font-size: 14px;
            font-weight: 500;
            flex: 1;
        }

        .bank-note {
            margin-top: 20px !important;
            padding: 12px 15px !important;
            background-color: #e3f2fd !important;
            border-radius: 6px !important;
            font-size: 13px !important;
            color: #0c5460 !important;
            border-left: 3px solid #2196f3;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .bank-note i {
            color: #1976d2 !important;
            font-size: 16px;
            margin-right: 5px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .bank-note strong {
            color: #0b5e8a;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .bank-detail-row {
                flex-direction: column;
                padding: 8px 0;
            }

            .bank-detail-label {
                width: 100%;
                margin-bottom: 4px;
                font-size: 13px;
            }

            .bank-detail-value {
                font-size: 14px;
            }

            .bank-details-card {
                padding: 15px;
            }

            .bank-note {
                flex-direction: column;
                gap: 5px;
            }

            .bank-note i {
                margin-bottom: 4px;
            }
        }
    </style>

    <div class="bg-white">
        <div class="container headerTop p-5">

        </div>
    </div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="shoping-cart.html" class="stext-109 cl8 hov-cl1 trans-04">
                Cart
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Checkout
            </span>
        </div>
    </div>

    <!-- Error Messages -->
    @if (session('error'))
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger"
                style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger"
                style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                <strong>Please fix the following errors:</strong>
                <ul style="margin-top: 10px; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <!-- Checkout -->
    <section class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Billing Information -->
                    <div class="checkout-section">
                        <h3 class="section-title">Billing Information</h3>
                        <form id="billing-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">First Name</label>
                                        <input type="text" name="c_fname" class="form-input-checkout" placeholder="John">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Last Name</label>
                                        <input type="text" name="c_lname" class="form-input-checkout" placeholder="Doe">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Email Address</label>
                                <input type="email" name="c_email_address" class="form-input-checkout"
                                    placeholder="john.doe@example.com">
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Phone Number <span class="required-field">*</span></label>
                                <input type="tel" name="c_phone" class="form-input-checkout"
                                    placeholder="+1 234 567 8900" required>
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Street Address <span class="required-field">*</span></label>
                                <input type="text" name="c_address" class="form-input-checkout"
                                    placeholder="123 Main Street" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">City</label>
                                        <input type="text" name="c_city" class="form-input-checkout"
                                            placeholder="New York">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">State/Province</label>
                                        <input type="text" name="c_state_country" class="form-input-checkout"
                                            placeholder="NY">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Postal Code</label>
                                        <input type="text" name="c_postal_zip" class="form-input-checkout"
                                            placeholder="10001">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Country</label>
                                        <input type="text" name="c_country" class="form-input-checkout"
                                            placeholder="country">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>



                    <!-- Payment Method -->
                    <div class="checkout-section">
                        <h3 class="section-title">Payment Method</h3>
                        <div class="payment-methods-wrapper">
                             <div class="payment-method">
                                <input type="radio" id="payment-cash" name="payment" value="cash" checked>
                                <label for="payment-cash" class="payment-label">
                                    <i class="zmdi zmdi-money payment-icon"></i>
                                    <span>Cash on Delivery</span>
                                </label>
                                <div class="radio-checkmark">✓</div>
                            </div>

                            <div class="payment-method">
                                <input type="radio" id="payment-bank" name="payment" value="bank" >
                                <label for="payment-bank" class="payment-label">
                                    <i class="fa fa-university payment-icon"></i>
                                    <span>Bank Transfer</span>
                                </label>
                                <div class="radio-checkmark">✓</div>
                            </div>

                        </div>

                        <!-- Payment Screenshot Upload Section -->
                        <div class="payment-screenshot-section" id="screenshot-section">
                            <h4 style="margin-bottom: 15px;">
                                <i class="zmdi zmdi-cloud-upload" style="margin-right: 8px;"></i>
                                Upload Payment Screenshot
                            </h4>

                            <!-- Bank Details Section (shown when Bank Transfer is selected) -->
                            <div class="bank-details-section" id="bank-details-section">
                                <div class="bank-details-card">

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Bank Name:</span>
                                        <span class="bank-detail-value">Bank</span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Account Title:</span>
                                        <span class="bank-detail-value">Batool pret</span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Account Number:</span>
                                        <span class="bank-detail-value">00000000000000 </span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">IBAN:</span>
                                        <span class="bank-detail-value">PK00MEZN00000000000000</span>
                                    </div>

                                    <div class="bank-note"
                                        style="margin-top: 15px; padding: 10px; background-color: #e3f2fd; border-radius: 4px; font-size: 13px;">
                                        <i class="zmdi zmdi-info" style="color: #1976d2; margin-right: 5px;"></i>
                                        <strong>Note:</strong> Please include your order number in the transfer description.
                                        After making the payment, upload the screenshot below for verification.
                                    </div>
                                </div>
                            </div>


                            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                                Please upload a screenshot of your payment confirmation for verification.
                            </p>

                            <div class="screenshot-input-wrapper" style="display: block;">
                                <div class="file-input-custom">
                                    <input type="file" id="payment-screenshot-input" accept="image/*"
                                        style="display: none;">
                                    <label for="payment-screenshot-input" class="file-input-custom-label"
                                        style="display: block; padding: 20px; border: 2px dashed #ddd; text-align: center; cursor: pointer; background-color: #f9f9f9;">
                                        <i class="zmdi zmdi-camera"
                                            style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                                        <span style="display: block; margin-bottom: 5px;">Click to upload or drag and
                                            drop</span>
                                        <span class="small-text"
                                            style="display: block; font-size: 12px; color: #999;">PNG, JPG, GIF up to
                                            5MB</span>
                                    </label>
                                </div>

                                <div class="file-preview" id="file-preview"
                                    style="display: none; margin-top: 15px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9;">
                                    <img id="preview-img" class="file-preview-img" alt="Preview"
                                        style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                    <div class="file-preview-name" id="preview-name" style="margin-bottom: 10px;"></div>
                                    <button type="button" class="remove-file-btn" id="remove-file-btn"
                                        style="padding: 8px 15px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px;">Remove
                                        File</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary-card">
                        <div class="order-summary-header">
                            <h3 class="order-summary-title">Order Summary</h3>
                            {{-- <span class="order-number">Order #12345</span> --}}
                        </div>

                        <!-- Coupon Section -->
                        <div class="coupon-section">
                            <div class="coupon-header">
                                <div class="coupon-icon">
                                    <i class="zmdi zmdi-local-offer"></i>
                                </div>
                                <div>
                                    <h4 class="coupon-title">Have a Coupon?</h4>
                                    <p class="coupon-subtitle">Save more with promo codes</p>
                                    @if (isset($hasDiscountedProducts) && $hasDiscountedProducts)
                                        <p class="coupon-warning"
                                            style="color: #ff9800; font-size: 12px; margin-top: 5px;">
                                            <i class="zmdi zmdi-info"></i> Coupons cannot be applied to discounted products
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <form method="POST" action="{{ route('checkout.applyCoupon') }}" class="coupon-form"
                                id="coupon-form">
                                @csrf
                                <div class="coupon-input-wrapper">
                                    <input type="text" name="coupon_code" id="coupon_code" class="coupon-input"
                                        placeholder="Enter coupon code" @if (isset($hasDiscountedProducts) && $hasDiscountedProducts) disabled @endif
                                        value="{{ isset($coupon) ? $coupon->code : '' }}">
                                    <button type="submit" class="coupon-apply-btn"
                                        @if (isset($hasDiscountedProducts) && $hasDiscountedProducts) disabled @endif>Apply</button>
                                </div>
                            </form>

                            @if (session('coupon_error'))
                                <div
                                    style="margin-top: 10px; padding: 10px; background-color: #ffebee; border-radius: 4px; color: #f44336; font-size: 13px;">
                                    <i class="zmdi zmdi-close-circle"></i> {{ session('coupon_error') }}
                                </div>
                            @endif

                            @if (isset($coupon) && $coupon)
                                <div class="coupon-applied"
                                    style="margin-top: 10px; padding: 10px; background-color: #e8f5e9; border-radius: 4px;">
                                    <span style="color: #4caf50; font-weight: bold;">
                                        <i class="zmdi zmdi-check-circle"></i> Coupon "{{ $coupon->code }}" applied
                                        ({{ $coupon->discount_percent }}% off)
                                    </span>
                                    <button type="button" id="remove-coupon-btn"
                                        style="float: right; background: none; border: none; color: #f44336; cursor: pointer;">
                                        <i class="zmdi zmdi-close"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Order Items -->
                        <div class="order-items">
                            @if (isset($cartItems) && $cartItems->count() > 0)
                                @foreach ($cartItems as $cartItem)
                                    @php
                                        $product = $cartItem->product;
                                        $productImage =
                                            $product && $product->image
                                                ? asset($product->image)
                                                : asset('frontend/images/item-cart-04.jpg');
                                        $itemTotal = $cartItem->price * $cartItem->quantity;
                                    @endphp
                                    <div class="order-item">
                                        <img src="{{ $productImage }}" alt="{{ $product ? $product->name : 'Product' }}"
                                            class="order-item-img" loading="lazy">
                                        <div class="order-item-details">
                                            <div class="order-item-name">
                                                {{ $product ? $product->name : 'Product Not Available' }}</div>
                                            <div class="order-item-info">
                                                Qty: {{ $cartItem->quantity }} × Rs.
                                                {{ number_format($cartItem->price, 0) }}
                                                @if ($cartItem->size)
                                                    <br><small style="color: #666;">Size:
                                                        {{ strtoupper($cartItem->size) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="order-item-price">Rs. {{ number_format($itemTotal, 0) }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="order-item">
                                    <p>No items in cart</p>
                                </div>
                            @endif
                        </div>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="total-row">
                                <span>Subtotal</span>
                                <span id="subtotal-amount">Rs.
                                    {{ isset($subtotal) ? number_format($subtotal, 0) : '0' }}</span>
                            </div>
                            @if (isset($discountAmount) && $discountAmount > 0)
                                <div class="total-row" id="discount-row">
                                    <span>Discount ({{ isset($coupon) ? $coupon->code : '' }})</span>
                                    <span id="discount-amount" style="color: #4caf50;">-Rs.
                                        {{ number_format($discountAmount, 0) }}</span>
                                </div>
                            @else
                                <div class="total-row" id="discount-row" style="display: none;">
                                    <span>Discount</span>
                                    <span id="discount-amount" style="color: #4caf50;">-Rs. 0</span>
                                </div>
                            @endif
                            <div class="total-row final">
                                <span>Total</span>
                                <span id="total-amount">Rs.
                                    {{ isset($total) ? number_format($total, 0) : (isset($subtotal) ? number_format($subtotal, 0) : '0') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="c_fname" id="checkout-fname">
                            <input type="hidden" name="c_lname" id="checkout-lname">
                            <input type="hidden" name="c_email_address" id="checkout-email">
                            <input type="hidden" name="c_phone" id="checkout-phone">
                            <input type="hidden" name="c_address" id="checkout-address">
                            <input type="hidden" name="c_city" id="checkout-city">
                            <input type="hidden" name="c_state_country" id="checkout-state">
                            <input type="hidden" name="c_postal_zip" id="checkout-postal">
                            <input type="hidden" name="c_country" id="checkout-country">
                            <input type="hidden" name="payment_method" id="checkout-payment" value="bank">
                            <input type="hidden" name="coupon_code" id="checkout-coupon"
                                value="{{ isset($coupon) ? $coupon->code : '' }}">
                            <input type="file" name="payment_screenshot" id="checkout-screenshot"
                                style="display: none;" accept="image/*">
                            <button type="submit" class="checkout-btn">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script defer>
            // Wait for jQuery to be loaded
            (function() {
                function initCheckoutScript() {
                    if (typeof jQuery === 'undefined') {
                        setTimeout(initCheckoutScript, 100);
                        return;
                    }

                    var $ = jQuery;

                    $(document).ready(function() {
                        // Handle payment method change - show/hide screenshot section
                        function toggleScreenshotSection() {
                            var $checkedPayment = $('input[name="payment"]:checked');
                            if ($checkedPayment.length === 0) {
                                return;
                            }

                            var paymentMethod = $checkedPayment.val();
                            var $screenshotSection = $('#screenshot-section');

                            // Show screenshot section only for bank transfer
                            if (paymentMethod === 'bank') {
                                // Add 'active' class to show the section (CSS uses .active class)
                                $screenshotSection.addClass('active');
                            } else {
                                // Hide for cash on delivery - remove 'active' class
                                $screenshotSection.removeClass('active');
                                // Clear file input
                                $('#payment-screenshot-input').val('');
                                $('#file-preview').hide();
                                $('#preview-img').attr('src', '');
                                $('#preview-name').text('');
                            }
                        }

                        // Handle payment method change - use direct event binding
                        $('input[name="payment"]').on('change', function() {
                            toggleScreenshotSection();
                        });

                        // Also use event delegation as backup
                        $(document).on('change', 'input[name="payment"]', function() {
                            toggleScreenshotSection();
                        });

                        // Trigger on page load to set initial state
                        setTimeout(function() {
                            toggleScreenshotSection();
                        }, 200);

                        // Handle file preview
                        $(document).on('change', '#payment-screenshot-input', function(e) {
                            var file = e.target.files[0];
                            if (file) {
                                // Validate file type
                                if (!file.type.startsWith('image/')) {
                                    alert('Please select a valid image file (PNG, JPG, GIF)');
                                    $(this).val('');
                                    return;
                                }

                                // Validate file size (5MB max)
                                if (file.size > 5 * 1024 * 1024) {
                                    alert('File size must be less than 5MB');
                                    $(this).val('');
                                    return;
                                }

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#preview-img').attr('src', e.target.result);
                                    $('#preview-name').text(file.name + ' (' + (file.size / 1024)
                                        .toFixed(2) + ' KB)');
                                    $('#file-preview').show();
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        // Handle remove file button
                        $(document).on('click', '#remove-file-btn', function() {
                            $('#payment-screenshot-input').val('');
                            $('#file-preview').hide();
                            $('#preview-img').attr('src', '');
                            $('#preview-name').text('');
                        });

                        // Handle remove coupon
                        $('#remove-coupon-btn').on('click', function() {
                            window.location.href = '{{ route('checkout') }}?remove_coupon=1';
                        });

                        // Handle checkout form submission
                        $('#checkout-form').on('submit', function(e) {
                            e.preventDefault();

                            // Validate only required fields (phone and address)
                            if (!$('input[name="c_phone"]').val()) {
                                if (typeof swal !== 'undefined') {
                                    swal("Error!", "Please enter your phone number", "error");
                                } else {
                                    alert('Please enter your phone number');
                                }
                                return false;
                            }

                            if (!$('input[name="c_address"]').val()) {
                                if (typeof swal !== 'undefined') {
                                    swal("Error!", "Please enter your address", "error");
                                } else {
                                    alert('Please enter your address');
                                }
                                return false;
                            }

                            // Validate payment screenshot for non-cash payments
                            var selectedPayment = $('input[name="payment"]:checked').val();
                            if (selectedPayment === 'bank') {
                                var screenshotFile = $('#payment-screenshot-input')[0].files[0];
                                if (!screenshotFile) {
                                    if (typeof swal !== 'undefined') {
                                        swal("Error!",
                                            "Please upload a payment screenshot for Bank Transfer",
                                            "error");
                                    } else {
                                        alert("Please upload a payment screenshot for Bank Transfer.");
                                    }
                                    return false;
                                }
                            }

                            // Get values from billing form and populate hidden fields
                            $('#checkout-fname').val($('input[name="c_fname"]').val() || '');
                            $('#checkout-lname').val($('input[name="c_lname"]').val() || '');
                            $('#checkout-email').val($('input[name="c_email_address"]').val() || '');
                            $('#checkout-phone').val($('input[name="c_phone"]').val());
                            $('#checkout-address').val($('input[name="c_address"]').val());
                            $('#checkout-city').val($('input[name="c_city"]').val() || '');
                            $('#checkout-state').val($('input[name="c_state_country"]').val() || '');
                            $('#checkout-postal').val($('input[name="c_postal_zip"]').val() || '');
                            $('#checkout-country').val($('input[name="c_country"]').val() || '');
                            $('#checkout-payment').val($('input[name="payment"]:checked').val() || 'cash');

                            // Get payment screenshot if uploaded and copy to hidden input
                            var screenshotFile = $('#payment-screenshot-input')[0].files[0];
                            if (screenshotFile) {
                                var dataTransfer = new DataTransfer();
                                dataTransfer.items.add(screenshotFile);
                                $('#checkout-screenshot')[0].files = dataTransfer.files;
                            }

                            // Show loading state
                            var $submitBtn = $(this).find('button[type="submit"]');
                            var originalText = $submitBtn.html();
                            $submitBtn.prop('disabled', true).html('Processing...');

                            // Prepare order data for tracking
                            var orderData = {
                                product_ids: window.currentOrderData?.product_ids || [],
                                products: window.currentOrderData?.products || [],
                                item_count: window.currentOrderData?.item_count || 0,
                                total: window.currentOrderData?.total || 0,
                                order_number: null // Will be set from response
                            };

                            // Submit the form using FormData for file upload
                            var formData = new FormData(this);

                            $.ajax({
                                url: $(this).attr('action'),
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                success: function(response) {
                                    // Add order number to tracking data if available
                                    if (response.order_number) {
                                        orderData.order_number = response.order_number;
                                    }

                                    // Track purchase event on successful order
                                    if (typeof window.trackPurchase === 'function' && orderData
                                        .product_ids.length > 0) {
                                        window.trackPurchase(orderData);
                                    }

                                    // If response is a redirect, follow it
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else if (response.order_number) {
                                        // Redirect with order number in URL
                                        window.location.href =
                                            '{{ route('thankyou') }}?order=' + response
                                            .order_number;
                                    } else {
                                        // Otherwise redirect to thankyou page
                                        window.location.href = '{{ route('thankyou') }}';
                                    }
                                },
                                error: function(xhr) {
                                    $submitBtn.prop('disabled', false).html(originalText);

                                    var errorMsg = 'An error occurred. Please try again.';

                                    // Check for validation errors
                                    if (xhr.responseJSON) {
                                        // First try to get the message
                                        if (xhr.responseJSON.message) {
                                            errorMsg = xhr.responseJSON.message;
                                        }
                                        // Then try to get errors object
                                        else if (xhr.responseJSON.errors) {
                                            var errors = [];
                                            $.each(xhr.responseJSON.errors, function(key,
                                                value) {
                                                if (Array.isArray(value)) {
                                                    errors.push(value[0]);
                                                } else {
                                                    errors.push(value);
                                                }
                                            });
                                            errorMsg = errors.join('<br>');
                                        }
                                    }

                                    // Log to console for debugging
                                    console.error('Order submission error:', xhr.responseJSON ||
                                        xhr.responseText);

                                    if (typeof swal !== 'undefined') {
                                        swal({
                                            title: "Error!",
                                            html: true,
                                            text: errorMsg,
                                            type: "error"
                                        });
                                    } else {
                                        alert(errorMsg);
                                    }

                                    // Don't reload on validation errors - let user fix them
                                    // Only reload on server errors
                                    if (xhr.status >= 500) {
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                }
                            });

                            return false;
                        });
                    });
                }

                // Start initialization
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initCheckoutScript);
                } else {
                    initCheckoutScript();
                }
            })();
        </script>
    @endpush

@endsection

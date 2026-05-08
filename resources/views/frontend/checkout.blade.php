@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('checkout') }}">
@endpush

@section('content')

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

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <div class="bg-white">
        <div class="container headerTop p-5">

        </div>
    </div>

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('cart') }}" class="stext-109 cl8 hov-cl1 trans-04">
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
                        <div id="billing-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">First Name</label>
                                        <input type="text" name="c_fname" id="c_fname" class="form-input-checkout" placeholder="John" value="{{ old('c_fname') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Last Name</label>
                                        <input type="text" name="c_lname" id="c_lname" class="form-input-checkout" placeholder="Doe" value="{{ old('c_lname') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Email Address</label>
                                <input type="email" name="c_email_address" id="c_email_address" class="form-input-checkout"
                                    placeholder="john.doe@example.com" value="{{ old('c_email_address') }}">
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Phone Number <span class="required-field">*</span></label>
                                <input type="tel" name="c_phone" id="c_phone" class="form-input-checkout"
                                    placeholder="+1 234 567 8900" required value="{{ old('c_phone') }}">
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Street Address <span class="required-field">*</span></label>
                                <input type="text" name="c_address" id="c_address" class="form-input-checkout"
                                    placeholder="123 Main Street" required value="{{ old('c_address') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">City</label>
                                        <input type="text" name="c_city" id="c_city" class="form-input-checkout"
                                            placeholder="New York" value="{{ old('c_city') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">State/Province</label>
                                        <input type="text" name="c_state_country" id="c_state_country" class="form-input-checkout"
                                            placeholder="NY" value="{{ old('c_state_country') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Postal Code</label>
                                        <input type="text" name="c_postal_zip" id="c_postal_zip" class="form-input-checkout"
                                            placeholder="10001" value="{{ old('c_postal_zip') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-checkout">
                                        <label class="form-label-checkout">Country</label>
                                        <input type="text" name="c_country" id="c_country" class="form-input-checkout"
                                            placeholder="Pakistan" value="{{ old('c_country', 'Pakistan') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-checkout">
                                <label class="form-label-checkout">Order Notes (Optional)</label>
                                <textarea name="c_order_notes" id="c_order_notes" class="form-input-checkout" rows="3" placeholder="Special instructions for delivery...">{{ old('c_order_notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-section">
                        <h3 class="section-title">Payment Method</h3>
                        <div class="payment-methods-wrapper">
                            <div class="payment-method">
                                <input type="radio" id="payment-cash" name="payment_method" value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}>
                                <label for="payment-cash" class="payment-label">
                                    <i class="zmdi zmdi-money payment-icon"></i>
                                    <span>Cash on Delivery</span>
                                </label>
                                <div class="radio-checkmark">✓</div>
                            </div>

                            <div class="payment-method">
                                <input type="radio" id="payment-bank" name="payment_method" value="bank" {{ old('payment_method') == 'bank' ? 'checked' : '' }}>
                                <label for="payment-bank" class="payment-label">
                                    <i class="fa fa-university payment-icon"></i>
                                    <span>Bank Transfer</span>
                                </label>
                                <div class="radio-checkmark">✓</div>
                            </div>
                        </div>

                        <!-- Payment Screenshot Upload Section -->
                        <div class="payment-screenshot-section" id="screenshot-section" style="display: none;">
                            <h4 style="margin-bottom: 15px;">
                                <i class="zmdi zmdi-cloud-upload" style="margin-right: 8px;"></i>
                                Upload Payment Screenshot
                            </h4>

                            <!-- Bank Details Section -->
                            <div class="bank-details-section">
                                <div class="bank-details-card">
                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Bank Name:</span>
                                        <span class="bank-detail-value">Meezan Bank</span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Account Title:</span>
                                        <span class="bank-detail-value">AHSAN SAEED</span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">Account Number:</span>
                                        <span class="bank-detail-value">02930111855908</span>
                                    </div>

                                    <div class="bank-detail-row">
                                        <span class="bank-detail-label">IBAN:</span>
                                        <span class="bank-detail-value">PK57MEZN0002930111855908</span>
                                    </div>

                                    <div class="bank-note">
                                        <i class="zmdi zmdi-info"></i>
                                        <strong>Note:</strong> Please include your order number in the transfer description.
                                        After making the payment, upload the screenshot below for verification.
                                    </div>
                                </div>
                            </div>

                            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                                Please upload a screenshot of your payment confirmation for verification.
                            </p>

                            <div class="screenshot-input-wrapper">
                                <div class="file-input-custom">
                                    <input type="file" id="payment-screenshot-input" name="payment_screenshot" accept="image/*">
                                    <label for="payment-screenshot-input" class="file-input-custom-label"
                                        style="display: block; padding: 20px; border: 2px dashed #ddd; text-align: center; cursor: pointer; background-color: #f9f9f9;">
                                        <i class="zmdi zmdi-camera"
                                            style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                                        <span style="display: block; margin-bottom: 5px;">Click to upload or drag and drop</span>
                                        <span class="small-text" style="display: block; font-size: 12px; color: #999;">PNG, JPG, GIF up to 5MB</span>
                                    </label>
                                </div>

                                <div class="file-preview" id="file-preview" style="display: none; margin-top: 15px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9;">
                                    <img id="preview-img" class="file-preview-img" alt="Preview" style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                    <div class="file-preview-name" id="preview-name" style="margin-bottom: 10px;"></div>
                                    <button type="button" class="remove-file-btn" id="remove-file-btn"
                                        style="padding: 8px 15px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px;">Remove File</button>
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
                                </div>
                            </div>

                            <form method="POST" action="{{ route('checkout.applyCoupon') }}" class="coupon-form" id="coupon-form">
                                @csrf
                                <div class="coupon-input-wrapper">
                                    <input type="text" name="coupon_code" id="coupon_code" class="coupon-input"
                                        placeholder="Enter coupon code" value="{{ isset($coupon) ? $coupon->code : '' }}">
                                    <button type="submit" class="coupon-apply-btn">Apply</button>
                                </div>
                            </form>

                            @if (session('coupon_error'))
                                <div style="margin-top: 10px; padding: 10px; background-color: #ffebee; border-radius: 4px; color: #f44336; font-size: 13px;">
                                    <i class="zmdi zmdi-close-circle"></i> {{ session('coupon_error') }}
                                </div>
                            @endif

                            @if (isset($coupon) && $coupon)
                                <div class="coupon-applied" style="margin-top: 10px; padding: 10px; background-color: #e8f5e9; border-radius: 4px;">
                                    <span style="color: #4caf50; font-weight: bold;">
                                        <i class="zmdi zmdi-check-circle"></i> Coupon "{{ $coupon->code }}" applied ({{ $coupon->discount_percent }}% off)
                                    </span>
                                    <button type="button" id="remove-coupon-btn" style="float: right; background: none; border: none; color: #f44336; cursor: pointer;">
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
                                        $productImage = $product && $product->image ? asset($product->image) : asset('frontend/images/item-cart-04.jpg');
                                        $itemTotal = $cartItem->price * $cartItem->quantity;
                                    @endphp
                                    <div class="order-item">
                                        <img src="{{ $productImage }}" alt="{{ $product ? $product->name : 'Product' }}" class="order-item-img" loading="lazy">
                                        <div class="order-item-details">
                                            <div class="order-item-name">{{ $product ? $product->name : 'Product Not Available' }}</div>
                                            <div class="order-item-info">
                                                Qty: {{ $cartItem->quantity }} × Rs. {{ number_format($cartItem->price, 0) }}
                                                @if ($cartItem->size)
                                                    <br><small style="color: #666;">Size: {{ strtoupper($cartItem->size) }}</small>
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
                                <span id="subtotal-amount">Rs. {{ isset($subtotal) ? number_format($subtotal, 0) : '0' }}</span>
                            </div>

                            @if (isset($discountAmount) && $discountAmount > 0)
                                <div class="total-row" id="discount-row">
                                    <span>Discount ({{ isset($coupon) ? $coupon->code : '' }})</span>
                                    <span id="discount-amount" style="color: #4caf50;">-Rs. {{ number_format($discountAmount, 0) }}</span>
                                </div>
                            @endif

                            <div class="total-row" id="delivery-row">
                                <span>Delivery Charges</span>
                                <span id="delivery-amount" style="color: #666;">Rs. 199</span>
                            </div>

                            <div class="total-row final">
                                <span>Grand Total</span>
                                <span id="grand-total-amount">
                                    Rs. {{ isset($total) ? number_format($total + 199, 0) : (isset($subtotal) ? number_format($subtotal + 199, 0) : '199') }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" enctype="multipart/form-data">
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
                            <input type="hidden" name="c_order_notes" id="checkout-notes">
                            <input type="hidden" name="payment_method" id="checkout-payment" value="">
                            <input type="hidden" name="coupon_code" id="checkout-coupon" value="{{ isset($coupon) ? $coupon->code : '' }}">
                            <input type="file" name="payment_screenshot" id="checkout-screenshot" style="display: none;" accept="image/*">
                            <button type="submit" class="checkout-btn" id="place-order-btn">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function() {
                function initCheckout() {
                    if (typeof jQuery === 'undefined') {
                        setTimeout(initCheckout, 100);
                        return;
                    }

                    var $ = jQuery;
                    var DELIVERY_CHARGES = 199;

                    function toggleScreenshotSection() {
                        var paymentMethod = $('input[name="payment_method"]:checked').val();
                        var $screenshotSection = $('#screenshot-section');

                        if (paymentMethod === 'bank') {
                            $screenshotSection.show();
                        } else {
                            $screenshotSection.hide();
                            $('#payment-screenshot-input').val('');
                            $('#file-preview').hide();
                            $('#preview-img').attr('src', '');
                            $('#preview-name').text('');
                        }
                    }

                    $(document).ready(function() {
                        // Initial setup
                        toggleScreenshotSection();

                        // Payment method change
                        $('input[name="payment_method"]').on('change', function() {
                            toggleScreenshotSection();
                        });

                        // File preview
                        $('#payment-screenshot-input').on('change', function(e) {
                            var file = e.target.files[0];
                            if (file) {
                                if (!file.type.startsWith('image/')) {
                                    alert('Please select a valid image file (PNG, JPG, GIF)');
                                    $(this).val('');
                                    return;
                                }

                                if (file.size > 5 * 1024 * 1024) {
                                    alert('File size must be less than 5MB');
                                    $(this).val('');
                                    return;
                                }

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#preview-img').attr('src', e.target.result);
                                    $('#preview-name').text(file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)');
                                    $('#file-preview').show();
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        // Remove file
                        $('#remove-file-btn').on('click', function() {
                            $('#payment-screenshot-input').val('');
                            $('#file-preview').hide();
                            $('#preview-img').attr('src', '');
                            $('#preview-name').text('');
                        });

                        // Remove coupon
                        $('#remove-coupon-btn').on('click', function() {
                            window.location.href = '{{ route('checkout') }}?remove_coupon=1';
                        });

                        // Form submission
                        $('#checkout-form').on('submit', function(e) {
                            e.preventDefault();

                            // Validate required fields
                            var phone = $('#c_phone').val();
                            var address = $('#c_address').val();

                            if (!phone) {
                                alert('Please enter your phone number');
                                $('#c_phone').focus();
                                return false;
                            }

                            if (!address) {
                                alert('Please enter your address');
                                $('#c_address').focus();
                                return false;
                            }

                            // Validate payment screenshot for bank transfer
                            var selectedPayment = $('input[name="payment_method"]:checked').val();
                            if (selectedPayment === 'bank') {
                                var screenshotFile = $('#payment-screenshot-input')[0].files[0];
                                if (!screenshotFile) {
                                    alert("Please upload a payment screenshot for Bank Transfer.");
                                    return false;
                                }
                            }

                            // Populate hidden fields
                            $('#checkout-fname').val($('#c_fname').val() || '');
                            $('#checkout-lname').val($('#c_lname').val() || '');
                            $('#checkout-email').val($('#c_email_address').val() || '');
                            $('#checkout-phone').val(phone);
                            $('#checkout-address').val(address);
                            $('#checkout-city').val($('#c_city').val() || '');
                            $('#checkout-state').val($('#c_state_country').val() || '');
                            $('#checkout-postal').val($('#c_postal_zip').val() || '');
                            $('#checkout-country').val($('#c_country').val() || 'Pakistan');
                            $('#checkout-notes').val($('#c_order_notes').val() || '');
                            $('#checkout-payment').val(selectedPayment);
                            $('#checkout-coupon').val($('#coupon_code').val() || '');

                            // Copy screenshot file
                            if (selectedPayment === 'bank') {
                                var screenshotFile = $('#payment-screenshot-input')[0].files[0];
                                if (screenshotFile) {
                                    var dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(screenshotFile);
                                    $('#checkout-screenshot')[0].files = dataTransfer.files;
                                }
                            }

                            // Disable submit button
                            var $submitBtn = $('#place-order-btn');
                            var originalText = $submitBtn.html();
                            $submitBtn.prop('disabled', true).html('<span class="loading-spinner"></span> Processing...');

                            // Submit form via AJAX
                            var formData = new FormData(this);

                            $.ajax({
                                url: $(this).attr('action'),
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log('Success:', response);

                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else if (response.order_number) {
                                        window.location.href = '{{ route('thankyou') }}?order=' + response.order_number;
                                    } else {
                                        window.location.href = '{{ route('thankyou') }}';
                                    }
                                },
                                error: function(xhr) {
                                    $submitBtn.prop('disabled', false).html(originalText);

                                    var errorMsg = 'An error occurred while processing your order. Please try again.';

                                    if (xhr.responseJSON) {
                                        if (xhr.responseJSON.message) {
                                            errorMsg = xhr.responseJSON.message;
                                        }
                                    }

                                    console.error('Error:', xhr.responseJSON || xhr.responseText);
                                    alert(errorMsg);
                                }
                            });

                            return false;
                        });
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initCheckout);
                } else {
                    initCheckout();
                }
            })();
        </script>
    @endpush

@endsection

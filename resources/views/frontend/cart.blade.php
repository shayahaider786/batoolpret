@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('cart') }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/cart.css') }}">
@endpush
@section('content')

<!-- Cart Header Section -->
<div class="cart-header-section">
    <div class="container">
        <h1 class="cart-main-title">Shopping Cart</h1>
        <div class="cart-breadcrumb">
            <a href="{{ route('index') }}" class="breadcrumb-link">Home</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Cart</span>
        </div>
    </div>
</div>


<!-- Cart Content Section -->
<div class="cart-content-section">
	<form action="{{ route('cart.updateAll') }}" method="POST" class="cart-form">
		@csrf
		@method('PUT')
		<div class="container">
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

			<div class="cart-layout">
				<!-- Cart Items Section -->
				<div class="cart-items-wrapper">
					@if(isset($cartItems) && $cartItems->count() > 0)
						@foreach($cartItems as $cartItem)
							@php
								$product = $cartItem->product;
								$productImage = $product && $product->image
									? asset($product->image)
									: asset('frontend/images/item-cart-04.jpg');
								$itemTotal = $cartItem->price * $cartItem->quantity;
							@endphp
							<div class="cart-item">
								<div class="cart-item-image">
									<img src="{{ $productImage }}" alt="{{ $product ? $product->name : 'Product' }}" loading="lazy">
								</div>
								<div class="cart-item-details">
									<h3 class="cart-item-name">{{ $product ? $product->name : 'Product Not Available' }}</h3>
									@if($cartItem->size)
										<p class="cart-item-size">Size: {{ strtoupper($cartItem->size) }}</p>
									@endif
									<p class="cart-item-price">Rs. {{ number_format($cartItem->price, 0) }}</p>

									<!-- Mobile Quantity & Remove -->
									<div class="cart-item-mobile-actions">
										<div class="quantity-selector">
											<button type="button" class="qty-btn qty-minus" data-cart-id="{{ $cartItem->id }}">
												<i class="zmdi zmdi-minus"></i>
											</button>
											<input type="number"
												class="qty-input"
												name="quantities[{{ $cartItem->id }}]"
												value="{{ $cartItem->quantity }}"
												min="1"
												max="{{ $product ? $product->stock : 1 }}"
												data-price="{{ $cartItem->price }}"
												data-cart-id="{{ $cartItem->id }}"
												readonly>
											<button type="button" class="qty-btn qty-plus" data-cart-id="{{ $cartItem->id }}">
												<i class="zmdi zmdi-plus"></i>
											</button>
										</div>
										<a href="{{ route('cart.remove', $cartItem->id) }}"
											class="remove-item-btn"
											data-product-name="{{ $cartItem->product->title }}"
											onclick="event.preventDefault(); confirmDelete(this);">
											<i class="zmdi zmdi-delete"></i>
										</a>
									</div>
								</div>

								<!-- Desktop Quantity -->
								<div class="cart-item-quantity">
									<div class="quantity-selector">
										<button type="button" class="qty-btn qty-minus" data-cart-id="{{ $cartItem->id }}">
											<i class="zmdi zmdi-minus"></i>
										</button>
										<input type="number"
											class="qty-input"
											name="quantities[{{ $cartItem->id }}]"
											value="{{ $cartItem->quantity }}"
											min="1"
											max="{{ $product ? $product->stock : 1 }}"
											data-price="{{ $cartItem->price }}"
											data-cart-id="{{ $cartItem->id }}"
											readonly>
										<button type="button" class="qty-btn qty-plus" data-cart-id="{{ $cartItem->id }}">
											<i class="zmdi zmdi-plus"></i>
										</button>
									</div>
								</div>

								<!-- Desktop Total -->
								<div class="cart-item-total">
									<p class="item-total-price" data-cart-id="{{ $cartItem->id }}">Rs. {{ number_format($itemTotal, 0) }}</p>
								</div>

								<!-- Desktop Remove -->
								<div class="cart-item-remove">
									<a href="{{ route('cart.remove', $cartItem->id) }}"
										class="remove-item-btn"
										data-product-name="{{ $cartItem->product->title }}"
										onclick="event.preventDefault(); confirmDelete(this);">
										<i class="zmdi zmdi-delete"></i>
									</a>
								</div>
							</div>
						@endforeach
					@else
						<div class="empty-cart">
							<i class="zmdi zmdi-shopping-cart"></i>
							<h3>Your cart is empty</h3>
							<p>Add some products to get started</p>
							<a href="{{ route('shop') }}" class="continue-shopping-btn">Continue Shopping</a>
						</div>
					@endif
				</div>

				<!-- Cart Summary Section -->
				<div class="cart-summary-wrapper">
					<div class="cart-summary">
						<h2 class="summary-title">Order Summary</h2>

						@php
							$subtotal = isset($cartItems) && $cartItems->count() > 0
								? $cartItems->sum(function($item) {
									return $item->price * $item->quantity;
								})
								: 0;
						@endphp

						<div class="summary-row">
							<span class="summary-label">Subtotal</span>
							<span class="summary-value" id="cart-subtotal">Rs. {{ number_format($subtotal, 0) }}</span>
						</div>

						<div class="summary-row">
							<span class="summary-label">Shipping</span>
							<span class="summary-value">Calculated at checkout</span>
						</div>

						<div class="summary-divider"></div>

						<div class="summary-row summary-total">
							<span class="summary-label">Total</span>
							<span class="summary-value" id="cart-total">Rs. {{ number_format($subtotal, 0) }}</span>
						</div>

						@if(isset($cartItems) && $cartItems->count() > 0)
							<button type="submit" class="checkout-btn" id="proceed-to-checkout-btn">
								<span>Proceed to Checkout</span>
							</button>
							<a href="{{ route('shop') }}" class="continue-shopping-link">Continue Shopping</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

@push('scripts')
<script defer>
	// Beautiful Delete Confirmation Popup
	function confirmDelete(element) {
		var productName = $(element).data('product-name');
		var deleteUrl = $(element).attr('href');

		swal({
			title: "Remove Item?",
			text: "Are you sure you want to remove \"" + productName + "\" from your cart?",
			icon: "warning",
			buttons: {
				cancel: {
					text: "Cancel",
					value: null,
					visible: true,
					className: "swal-button-cancel",
					closeModal: true,
				},
				confirm: {
					text: "Yes, Remove",
					value: true,
					visible: true,
					className: "swal-button-confirm",
					closeModal: true
				}
			},
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				// Show loading state
				swal({
					title: "Removing...",
					text: "Please wait",
					icon: "info",
					buttons: false,
					closeOnClickOutside: false,
					closeOnEsc: false,
				});

				// Redirect to delete URL
				window.location.href = deleteUrl;
			}
		});
	}

	$(document).ready(function() {
		// Quantity increase button
		$('.qty-plus').off('click').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var $btn = $(this);
			var cartId = $btn.data('cart-id');
			var $input = $('input[name="quantities[' + cartId + ']"]').first();
			var currentQty = parseInt($input.val());
			var maxQty = parseInt($input.attr('max'));

			if (currentQty < maxQty) {
				var newQty = currentQty + 1;
				// Update all inputs with same cart-id
				$('input[name="quantities[' + cartId + ']"]').val(newQty).trigger('change');
			}
		});

		// Quantity decrease button
		$('.qty-minus').off('click').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var $btn = $(this);
			var cartId = $btn.data('cart-id');
			var $input = $('input[name="quantities[' + cartId + ']"]').first();
			var currentQty = parseInt($input.val());

			if (currentQty > 1) {
				var newQty = currentQty - 1;
				// Update all inputs with same cart-id
				$('input[name="quantities[' + cartId + ']"]').val(newQty).trigger('change');
			}
		});

		// Update item total when quantity changes
		$('input[name^="quantities"]').on('change', function() {
			var $input = $(this);
			var cartId = $input.data('cart-id');
			var quantity = parseInt($input.val());
			var price = parseFloat($input.data('price'));
			var total = price * quantity;

			// Update all total displays for this cart item
			$('.item-total-price[data-cart-id="' + cartId + '"]').text('Rs. ' + total.toLocaleString('en-US', {maximumFractionDigits: 0}));

			// Update cart totals
			updateCartTotals();
		});

		function updateCartTotals() {
			var subtotal = 0;
			$('.item-total-price').each(function() {
				var totalText = $(this).text();
				var total = parseFloat(totalText.replace('Rs. ', '').replace(/,/g, ''));
				subtotal += total;
			});

			$('#cart-subtotal').text('Rs. ' + subtotal.toLocaleString('en-US', {maximumFractionDigits: 0}));
			$('#cart-total').text('Rs. ' + subtotal.toLocaleString('en-US', {maximumFractionDigits: 0}));
		}

		// Handle form submission - update cart then redirect to checkout
		$('.cart-form').on('submit', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $button = $('#proceed-to-checkout-btn');
			var originalText = $button.find('span').text();

			// Disable button to prevent multiple clicks
			if ($button.prop('disabled')) {
				return false;
			}
			$button.prop('disabled', true).find('span').text('Processing...');

			// Update cart via AJAX
			$.ajax({
				url: $form.attr('action'),
				method: 'PUT',
				data: $form.serialize(),
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				success: function(response) {
					// Redirect to checkout page after successful update
					window.location.href = '{{ route("checkout") }}';
				},
				error: function(xhr) {
					// Re-enable button on error
					$button.prop('disabled', false).find('span').text(originalText);

					var errorMsg = 'Error updating cart';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					} else if (xhr.responseJSON && xhr.responseJSON.errors) {
						var errors = [];
						$.each(xhr.responseJSON.errors, function(key, value) {
							if (Array.isArray(value)) {
								errors.push(value[0]);
							} else {
								errors.push(value);
							}
						});
						errorMsg = errors.join('<br>');
					}

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
@endsection

// ==================== SHIPPING TOGGLE ====================
		const shippingCheckbox = document.getElementById('shipping-different');
		if (shippingCheckbox) {
			shippingCheckbox.addEventListener('change', function() {
				const shippingSection = document.getElementById('shipping-section');
				if (this.checked) {
					shippingSection.style.display = 'block';
					shippingSection.style.animation = 'slideDown 0.3s ease';
				} else {
					shippingSection.style.display = 'none';
				}
			});
		}

		// ==================== PAYMENT METHOD HANDLING ====================
		// Payment method handling is now done in checkout.blade.php using jQuery
		// This section has been removed to avoid conflicts

		// Initialize on page load
		document.addEventListener('DOMContentLoaded', function() {
			// ==================== FILE INPUT HANDLING ====================
			// File input handling is now done in checkout.blade.php using jQuery
			// This section has been removed to avoid conflicts

			// ==================== FORM VALIDATION ====================
			const checkoutBtn = document.querySelector('.checkout-btn');
			const billingForm = document.getElementById('billing-form');
			const shippingSection = document.getElementById('shipping-section');

			function validateField(field) {
				const value = field.value.trim();
				
				if (!value || value === 'Select Country') {
					field.style.borderColor = '#e74c3c';
					
					// Highlight Select2 if applicable
					if (field.classList.contains('js-select2')) {
						const select2Container = field.nextElementSibling;
						if (select2Container) {
							const selection = select2Container.querySelector('.select2-selection');
							if (selection) selection.style.borderColor = '#e74c3c';
						}
					}
					return false;
				} else {
					field.style.borderColor = '#e6e6e6';
					
					// Reset Select2 styling
					if (field.classList.contains('js-select2')) {
						const select2Container = field.nextElementSibling;
						if (select2Container) {
							const selection = select2Container.querySelector('.select2-selection');
							if (selection) selection.style.borderColor = '';
						}
					}
					return true;
				}
			}

			// Checkout button handling is now done in checkout.blade.php
			// This validation code has been removed to avoid conflicts with form submission

			// Remove error styling on input
			document.querySelectorAll('.form-input-checkout').forEach(field => {
				field.addEventListener('input', function() {
					this.style.borderColor = '#e6e6e6';
					
					if (this.classList.contains('js-select2')) {
						const select2Container = this.nextElementSibling;
						if (select2Container) {
							const selection = select2Container.querySelector('.select2-selection');
							if (selection) selection.style.borderColor = '';
						}
					}
				});
			});

			// Remove error styling on Select2 change
			document.querySelectorAll('.js-select2').forEach(field => {
				field.addEventListener('change', function() {
					this.style.borderColor = '#e6e6e6';
					const select2Container = this.nextElementSibling;
					if (select2Container) {
						const selection = select2Container.querySelector('.select2-selection');
						if (selection) selection.style.borderColor = '';
					}
				});
			});
		});
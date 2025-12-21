@extends('web.web-layout')

@section('header')
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets/web/css/order-sign_up.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/web/css/detail-page.css') }}" rel="stylesheet">
@endsection

@section('main')
<div class="container margin_60_20 mt-6">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Processing...</span>
            </div>
            <p class="mt-3">Processing your order...</p>
        </div>
    </div>

    <!-- Error Alert -->
    <div id="error-alert" class="alert alert-danger" style="display: none;" role="alert">
        <strong>Error!</strong> <span id="error-message"></span>
    </div>

    <!-- Success Alert -->
    <div id="success-alert" class="alert alert-success" style="display: none;" role="alert">
        <strong>Success!</strong> <span id="success-message"></span>
    </div>

	<div class="row justify-content-center">
		<div class="col-xl-4 col-lg-6" id="sidebar_fixed">
			<div class="box_order">
				<div class="head">
					<h3>Order Summary</h3>
				</div>
				<!-- /head -->
				<div class="main d-flex flex-column justify-content-between">
					<div class="items-area">
						@forelse($items as $item)
						<div class="checkout-item d-flex justify-content-between align-items-center mb-3">
							<div class="d-flex">
								<figure class="me-2">
									<img class="img-fluid object-fit-cover" src="{{ asset('storage/' . $item->menuItem->images->first()->image_path) }}" alt="">
								</figure>
								<div>
									<p class="fw-semibold mb-0">{{ $item->menuItem->name }}</p>
									@if($item->variations->isNotEmpty())
										<small class="text-nowrap item-variation-name">
											@foreach($item->variations as $variation)
											{{ $variation->name }}
											@if(!$loop->last), @endif
											@endforeach
										</small>
									@endif
								</div>
							</div>
							<span>{{ $item->quantity }} x <b>{{ number_format($item->variations->first()->price * $item->quantity, 2) }}</b></span>
						</div>
						@empty
						<div class="text-center py-3">Your cart is empty</div>
						@endforelse
					</div>
					
					<div class="summary-area">
						<ul class="clearfix">
							<li>Subtotal<span id="checkout_subtotal">{{ config('app.currency') }}{{ number_format($cartTotal, 2) }}</span></li>
							<li class="total">Total<span id="checkout_total">{{ config('app.currency') }}{{ number_format($cartTotal, 2) }}</span></li>
						</ul>
						<button type="submit" form="checkout-form" class="btn_1 gradient full-width mb_5" id="place-order-btn">
							<span class="btn-text">Order Now</span>
							<span class="btn-loading" style="display: none;">
								<span class="spinner-border spinner-border-sm me-2" role="status"></span>
								Processing...
							</span>
						</button>
						<div class="text-center"><small>Or Call Us at <strong>0432 48432854</strong></small></div>
					</div>
				</div>
			</div>
			<!-- /box_booking -->
		</div>
		<!-- /col -->

		<div class="col-xl-6 col-lg-6">
			<form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
				@csrf
				<div class="box_order_form">
					<div class="head">
						<div class="title">
							<h3>Personal Details</h3>
						</div>
					</div>
					<!-- /head -->
					<div class="main">
						<div class="form-group">
							<label for="customer_name">First and Last Name *</label>
							<input type="text" class="form-control" id="customer_name" name="customer_name" 
								   placeholder="First and Last Name" required>
							<div class="invalid-feedback"></div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="customer_email">Email Address *</label>
									<input type="email" class="form-control" id="customer_email" name="customer_email" 
										   placeholder="Email Address" required>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="customer_phone">Phone *</label>
									<input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
										   placeholder="Phone" required>
									<div class="invalid-feedback"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="delivery_address">Full Address *</label>
							<textarea class="form-control" id="delivery_address" name="delivery_address" 
									  placeholder="Full Address" rows="3" required></textarea>
							<div class="invalid-feedback"></div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="city">City *</label>
									<input type="text" class="form-control" id="city" name="city" 
										   placeholder="City" required>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="postal_code">Postal Code *</label>
									<input type="text" class="form-control" id="postal_code" name="postal_code" 
										   placeholder="0123" required>
									<div class="invalid-feedback"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="delivery_instructions">Delivery Instructions</label>
							<textarea class="form-control" id="delivery_instructions" name="delivery_instructions" 
									  placeholder="Any special delivery instructions (optional)" rows="2"></textarea>
						</div>
					</div>
				</div>
				<!-- /box_order_form -->
				<div class="box_order_form">
					<div class="head">
						<div class="title">
							<h3>Payment Method</h3>
						</div>
					</div>
					<!-- /head -->
					<div class="main">
						<div class="payment_select" id="razorpay-payment">
							<label class="container_radio">Pay with Razorpay
								<input type="radio" value="card" name="payment_method" checked>
								<span class="checkmark"></span>
							</label>
						</div>
						<div class="payment_select">
							<label class="container_radio">Cash On Delivery
								<input type="radio" value="cod" name="payment_method">
								<span class="checkmark"></span>
							</label>
							<i class="icon_wallet"></i>
						</div>

						<!-- COD Information -->
						<div id="cod-info" class="mt-3 p-3 bg-light rounded" style="display: none;">
							<div class="d-flex align-items-center">
								<i class="fas fa-info-circle text-info me-2"></i>
								<div>
									<strong>Cash on Delivery</strong>
									<p class="mb-0 small text-muted">Pay cash when your order is delivered. No online payment required.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /box_order_form -->
			</form>
		</div>
		<!-- /col -->

	</div>
	<!-- /row -->
</div>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-spinner {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
}
</style>
@endsection

@section('custom-js')
<script src="{{ asset('assets/web/js/sticky_sidebar.min.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>

	$('#sidebar_fixed').theiaStickySidebar({
		minWidth: 991,
		updateSidebarHeight: false,
		additionalMarginTop: 30
	});

	// Handle payment method selection
	$('input[name="payment_method"]').change(function() {
		if ($(this).val() === 'cod') {
			$('#cod-info').show();
		} else {
			$('#cod-info').hide();
		}
	});

	// Form validation
	function validateForm() {
		let isValid = true;
		const requiredFields = [
			'customer_name', 'customer_email', 'customer_phone', 
			'delivery_address', 'city', 'postal_code'
		];

		requiredFields.forEach(fieldName => {
			const field = $(`[name="${fieldName}"]`);
			const value = field.val().trim();
			
			if (!value) {
				field.addClass('is-invalid');
				field.siblings('.invalid-feedback').text('This field is required');
				isValid = false;
			} else {
				field.removeClass('is-invalid');
				field.siblings('.invalid-feedback').text('');
			}
		});

		// Email validation
		const email = $('#customer_email').val();
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (email && !emailRegex.test(email)) {
			$('#customer_email').addClass('is-invalid');
			$('#customer_email').siblings('.invalid-feedback').text('Please enter a valid email address');
			isValid = false;
		}

		// Phone validation
		const phone = $('#customer_phone').val();
		const phoneRegex = /^[0-9]{10}$/;
		if (phone && !phoneRegex.test(phone)) {
			$('#customer_phone').addClass('is-invalid');
			$('#customer_phone').siblings('.invalid-feedback').text('Please enter a valid 10-digit phone number');
			isValid = false;
		}

		return isValid;
	}

	// Handle form submission
	$('#checkout-form').on('submit', async function(e) {
		e.preventDefault();

		if (!validateForm()) {
			showError('Please fill in all required fields correctly.');
			return;
		}

		const paymentMethod = $('input[name="payment_method"]:checked').val();
		const formData = new FormData(this);
		
		// Show loading state
		showLoading(true);

		try {
			if (paymentMethod === 'cod') {
				// Handle COD directly
				await processCODOrder(formData);
			} else {
				// Handle Razorpay payment
				await processRazorpayPayment(formData);
			}
		} catch (error) {
			console.error('Order submission error:', error);
			showError('An error occurred while processing your order. Please try again.');
		} finally {
			showLoading(false);
		}
	});

	async function processCODOrder(formData) {
		const orderData = {
			customer_name: formData.get('customer_name'),
			customer_email: formData.get('customer_email'),
			customer_phone: formData.get('customer_phone'),
			delivery_address: formData.get('delivery_address'),
			city: formData.get('city'),
			postal_code: formData.get('postal_code'),
			delivery_instructions: formData.get('delivery_instructions'),
			payment_method: 'cod',
			payment_gateway: 'cod'
		};

		console.log('Processing COD order:', orderData);

		const response = await fetch('/api/orders/checkout', {
			method: 'POST',
			headers: headers,
			body: JSON.stringify(orderData)
		});

		const result = await response.json();
		console.log('COD order response:', result);

		if (result.success) {
			showSuccess('Order placed successfully! You will pay cash on delivery. Redirecting...');
			setTimeout(() => {
				window.location.href = '/order-placed?order=' + result.order.order_number + '&payment=cod';
			}, 2000);
		} else {
			if (result.redirect) {
				window.location.href = result.redirect;
			}
			showError(result.message || 'Failed to place order. Please try again.');
		}
	}

	async function processRazorpayPayment(formData) {
		// First create Razorpay order
		const orderResponse = await fetch('/api/razorpay/create-order', {
			method: 'POST',
			headers: headers,
			body: JSON.stringify({
				amount: {{ $cartTotal }},
				currency: 'INR'
			})
		});

		const orderResult = await orderResponse.json();

		if (!orderResult.success) {
			showError('Failed to create payment order. Please try again.');
			return;
		}

		// Configure Razorpay options
		const options = {
			key: '{{ config("services.razorpay.key_id") }}',
			amount: orderResult.order.amount,
			currency: orderResult.order.currency,
			name: '{{ config("app.name") }}',
			description: 'Order Payment',
			order_id: orderResult.order.id,
			handler: async function (response) {
				// Payment successful, now create the order
				const orderData = {
					customer_name: formData.get('customer_name'),
					customer_email: formData.get('customer_email'),
					customer_phone: formData.get('customer_phone'),
					delivery_address: formData.get('delivery_address'),
					city: formData.get('city'),
					postal_code: formData.get('postal_code'),
					delivery_instructions: formData.get('delivery_instructions'),
					payment_method: 'card',
					payment_gateway: 'razorpay',
					razorpay_order_id: response.razorpay_order_id,
					razorpay_payment_id: response.razorpay_payment_id,
					razorpay_signature: response.razorpay_signature
				};

				const orderResponse = await fetch('/api/orders/checkout', {
					method: 'POST',
					headers: headers,
					body: JSON.stringify(orderData)
				});

				const result = await orderResponse.json();

				if (result.success) {
					showSuccess('Order placed successfully! Redirecting...');
					setTimeout(() => {
						window.location.href = '/order-placed?order=' + result.order.order_number + '&payment=online';
					}, 2000);
				} else {
					showError(result.message || 'Failed to place order. Please try again.');
				}
			},
			prefill: {
				name: formData.get('customer_name'),
				email: formData.get('customer_email'),
				contact: formData.get('customer_phone')
			},
			notes: {
				address: formData.get('delivery_address')
			},
			theme: {
				color: '#3399cc'
			}
		};

		// Open Razorpay checkout
		const rzp = new Razorpay(options);
		rzp.on('payment.failed', function (response) {
			showError('Payment failed. Please try again.');
		});
		rzp.open();
	}

	function showLoading(show) {
		if (show) {
			$('#loading-overlay').show();
			$('#place-order-btn .btn-text').hide();
			$('#place-order-btn .btn-loading').show();
			$('#place-order-btn').prop('disabled', true);
		} else {
			$('#loading-overlay').hide();
			$('#place-order-btn .btn-text').show();
			$('#place-order-btn .btn-loading').hide();
			$('#place-order-btn').prop('disabled', false);
		}
	}

	function showError(message) {
		$('#error-message').text(message);
		$('#error-alert').show();
		$('#success-alert').hide();
		$('html, body').animate({scrollTop: 0}, 500);
	}

	function showSuccess(message) {
		$('#success-message').text(message);
		$('#success-alert').show();
		$('#error-alert').hide();
		$('html, body').animate({scrollTop: 0}, 500);
	}

	// Initialize payment method visibility
	$('input[name="payment_method"]:checked').trigger('change');
</script>
@endsection
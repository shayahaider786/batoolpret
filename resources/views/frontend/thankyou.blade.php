@extends('layouts.frontend')

@push('canonical')
    @php
        $canonicalParams = [];
        if(isset($order_number) && $order_number) {
            $canonicalParams['order'] = $order_number;
        } elseif(session('order_number')) {
            $canonicalParams['order'] = session('order_number');
        }
    @endphp
    <link rel="canonical" href="{{ route('thankyou', $canonicalParams) }}">
@endpush

@section('content')
<div class="bg-white"> 
    <div class="container headerTop p-5">
       
    </div>
   </div>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{ route('index') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="{{ route('cart') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Cart
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="{{ route('checkout') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Checkout
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Thank You
			</span>
		</div>
	</div>

	<!-- Thank You Section -->
	<section class="bg0 p-t-75 p-b-85 thankyou-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-xl-6 col-md-10 col-sm-12 m-lr-auto">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm p-t-20-sm p-b-20-sm" style="margin-left: 0 !important; margin-right: 0 !important;">
						<!-- Success Icon -->
						<div class="flex-c-m flex-w w-full p-b-20 p-b-15-sm">
							<div class="flex-c-m w-full">
								<div class="flex-c-m flex-col-c-m bor2 p-t-6 p-b-6 p-l-10 p-r-10" style="width: 120px; height: 120px; border-radius: 50%; border: 3px solid #717fe0; background-color: #f8f9ff;">
									<i class="zmdi zmdi-check-circle cl1" style="font-size: 60px;"></i>
								</div>
							</div>
						</div>

						<!-- Success Message -->
						<div class="flex-c-m flex-w w-full p-b-20 p-b-15-sm">
							<div class="w-full">
								<h2 class="mtext-40 cl2 p-b-10 text-center" style="font-size: 32px;">
									Thank You!
								</h2>
								<p class="stext-15 cl6 text-center" style="font-size: 16px; line-height: 1.6;">
									Your order has been placed successfully. We have received your order and will begin processing it right away.
								</p>
							</div>
						</div>

						<!-- Order Number -->
						@if(isset($order_number) && $order_number)
							<div class="flex-c-m flex-w w-full p-b-30 p-b-20-sm">
								<div class="flex-c-m w-full">
									<div class="bor12 p-lr-20 p-t-15 p-b-15 p-lr-15-sm" style="background-color: #f8f9ff; border: 2px solid #717fe0;">
										<div class="flex-w flex-m">
											<div class="flex-c-m w-full">
												<span class="stext-18 cl2" style="font-weight: 600; display: block; font-size: 16px;">
													Order Number : 
												</span>
												<span class="stext-24 cl1" style="font-weight: 700; letter-spacing: 1px; font-size: 20px; word-break: break-all;">
													{{ $order_number }}
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						@elseif(session('order_number'))
							<div class="flex-c-m flex-w w-full p-b-30 p-b-20-sm">
								<div class="flex-c-m w-full">
									<div class="bor12 p-lr-20 p-t-15 p-b-15 p-lr-15-sm" style="background-color: #f8f9ff; border: 2px solid #717fe0;">
										<div class="flex-w flex-m">
											<div class="flex-c-m w-full">
												<span class="stext-18 cl2" style="font-weight: 600; display: block; font-size: 16px;">
													Order Number : 
												</span>
												<span class="stext-24 cl1" style="font-weight: 700; letter-spacing: 1px; font-size: 20px; word-break: break-all;">
													{{ session('order_number') }}
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif

						<!-- Information Box -->
						<div class="p-b-20 p-b-15-sm">
							<div class="bor12 p-lr-30 p-t-30 p-b-30 p-lr-20-sm p-t-20-sm p-b-20-sm" style="background: #ffffff; border: 1px solid #e6e6e6; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
								<!-- Email Info Card -->
								<div style="padding-bottom: 25px; margin-bottom: 25px; border-bottom: 1px solid #e6e6e6;">
									<div style="display: inline-block; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #717fe0 0%, #8b9aff 100%); margin-right: 20px; vertical-align: top; text-align: center; line-height: 50px;">
										<i class="zmdi zmdi-email" style="font-size: 24px; color: #ffffff;"></i>
									</div>
									<div style="display: inline-block; width: calc(100% - 75px); vertical-align: top;">
										<span class="stext-16 cl2" style="font-weight: 600; display: block; margin-bottom: 8px; color: #333; font-size: 16px;">
											Email Confirmation
										</span>
										<span class="stext-14 cl6" style="line-height: 1.6; color: #666; font-size: 14px; display: block;">
											We've sent a confirmation email to your registered email address with all the order details.
										</span>
									</div>
								</div>
								
								<!-- Time Info Card -->
								<div style="padding-bottom: 25px; margin-bottom: 25px; border-bottom: 1px solid #e6e6e6;">
									<div style="display: inline-block; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%); margin-right: 20px; vertical-align: top; text-align: center; line-height: 50px;">
										<i class="zmdi zmdi-time-countdown" style="font-size: 24px; color: #ffffff;"></i>
									</div>
									<div style="display: inline-block; width: calc(100% - 75px); vertical-align: top;">
										<span class="stext-16 cl2" style="font-weight: 600; display: block; margin-bottom: 8px; color: #333; font-size: 16px;">
											Order Update
										</span>
										<span class="stext-14 cl6" style="line-height: 1.6; color: #666; font-size: 14px; display: block;">
											You will receive an update on your order status within 24-48 hours.
										</span>
									</div>
								</div>
								
								<!-- Support Info Card -->
								<div>
									<div style="display: inline-block; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #ff9800 0%, #ffb74d 100%); margin-right: 20px; vertical-align: top; text-align: center; line-height: 50px;">
										<i class="zmdi zmdi-phone-in-talk" style="font-size: 24px; color: #ffffff;"></i>
									</div>
									<div style="display: inline-block; width: calc(100% - 75px); vertical-align: top;">
										<span class="stext-16 cl2" style="font-weight: 600; display: block; margin-bottom: 8px; color: #333; font-size: 16px;">
											Need Help?
										</span>
										<span class="stext-14 cl6" style="line-height: 1.6; color: #666; font-size: 14px; display: block;">
											If you have any questions, please feel free to contact our customer support team.
										</span>
									</div>
								</div>
							</div>
						</div>

						<!-- Action Buttons -->
						<div class="flex-c-m flex-w w-full p-t-20 p-t-15-sm">
							<div class="flex-c-m flex-w w-full" style="flex-direction: column;">
								<a href="{{ route('shop') }}" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-b-15-sm mb-3" style="width: 100%; max-width: 100%; margin-right: 0 !important;">
									Continue Shopping
								</a>
								<a href="{{ route('index') }}" class="flex-c-m stext-101 cl0 size-103 bg2 bor1 hov-btn2 p-lr-15 trans-04" style="width: 100%; max-width: 100%;">
									Back to Home
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<style>
		@media (max-width: 767px) {
			.thankyou-section {
				padding-top: 30px !important;
				padding-bottom: 30px !important;
			}
			
			.thankyou-section .bor10 {
				margin-left: 0 !important;
				margin-right: 0 !important;
				padding-left: 20px !important;
				padding-right: 20px !important;
			}
			
			.thankyou-section .mtext-40 {
				font-size: 28px !important;
			}
			
			.thankyou-section .stext-24 {
				font-size: 18px !important;
			}
			
			.thankyou-section .stext-18 {
				font-size: 16px !important;
			}
			
			.thankyou-section .stext-15 {
				font-size: 14px !important;
			}
			
			.thankyou-section .stext-101 {
				font-size: 14px !important;
				padding: 12px 20px !important;
			}
			
			.thankyou-section .size-103 {
				width: 100% !important;
				max-width: 100% !important;
			}
			
			.thankyou-section .flex-c-m.flex-w[style*="flex-direction: column"] {
				flex-direction: column !important;
			}
			
			.thankyou-section .bor2[style*="width: 120px"] {
				width: 100px !important;
				height: 100px !important;
			}
			
			.thankyou-section .bor2[style*="width: 120px"] i {
				font-size: 50px !important;
			}
		}
		
		@media (max-width: 575px) {
			.thankyou-section {
				padding-top: 20px !important;
				padding-bottom: 20px !important;
			}
			
			.thankyou-section .bor10 {
				padding-left: 15px !important;
				padding-right: 15px !important;
				padding-top: 20px !important;
				padding-bottom: 20px !important;
			}
			
			.thankyou-section .mtext-40 {
				font-size: 24px !important;
			}
			
			.thankyou-section .stext-24 {
				font-size: 16px !important;
			}
			
			.thankyou-section .bor2[style*="width: 120px"] {
				width: 80px !important;
				height: 80px !important;
			}
			
			.thankyou-section .bor2[style*="width: 120px"] i {
				font-size: 40px !important;
			}
		}
	</style>

@endsection

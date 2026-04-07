@extends('layouts.frontend')

@section('content')
		<!-- Start Hero Section -->
        <div class="hero">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h1>{{ __('messages.about.title') }}</h1>
                            <p class="mb-4">{{ __('messages.about.description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Hero Section -->

    

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">{{ __('messages.whyChoose.title') }}</h2>
                    <p>{{ __('messages.about.whyChooseDesc') }}</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="frontend/images/truck.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>{{ __('messages.whyChoose.fastShipping') }}</h3>
                                <p>{{ __('messages.whyChoose.fastShippingDesc') }}</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="frontend/images/bag.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>{{ __('messages.whyChoose.easyShop') }}</h3>
                                <p>{{ __('messages.whyChoose.easyShopDesc') }}</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="frontend/images/support.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>{{ __('messages.whyChoose.support') }}</h3>
                                <p>{{ __('messages.whyChoose.supportDesc') }}</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="frontend/images/return.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>{{ __('messages.whyChoose.returns') }}</h3>
                                <p>{{ __('messages.whyChoose.returnsDesc') }}</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="frontend/images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">{{ __('messages.testimonials.title') }}</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">
                            
                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;{{ __('messages.testimonials.testimonial1') }}&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="frontend/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">{{ __('messages.testimonials.author1') }}</h3>
                                                <span class="position d-block mb-3">{{ __('messages.testimonials.position1') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> 
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;{{ __('messages.testimonials.testimonial1') }}&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="frontend/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">{{ __('messages.testimonials.author1') }}</h3>
                                                <span class="position d-block mb-3">{{ __('messages.testimonials.position1') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> 
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;{{ __('messages.testimonials.testimonial1') }}&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="frontend/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">{{ __('messages.testimonials.author1') }}</h3>
                                                <span class="position d-block mb-3">{{ __('messages.testimonials.position1') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> 
                            <!-- END item -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->

@endsection

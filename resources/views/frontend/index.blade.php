@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('index') }}">
@endpush

@section('content')

    <!-- new slider -->
    @if(isset($sliders) && $sliders->isNotEmpty())
        <section class="new-slider">
            <div class="hero-slider-wrapper">
                <div class="hero-slider-container">
                    @foreach($sliders as $index => $slider)
                        <div class="hero-slide-item {{ $index === 0 ? 'hero-active-slide' : '' }}">
                            @if ($slider->website_slider_image)
                                @php
                                    $desktopImagePath = $slider->website_slider_image;
                                    $desktopImageUrl = file_exists(public_path($desktopImagePath))
                                        ? asset($desktopImagePath)
                                        : asset('frontend/images-limelight/slider-image.webp');
                                @endphp
                                <img class="hero-slide-img-desktop" src="{{ $desktopImageUrl }}"
                                    alt="Slide {{ $index + 1 }} Desktop" loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/images-limelight/slider-image.webp') }}';">
                            @endif

                            @if ($slider->mobile_slider_image)
                                @php
                                    $mobileImagePath = $slider->mobile_slider_image;
                                    $mobileImageUrl = file_exists(public_path($mobileImagePath))
                                        ? asset($mobileImagePath)
                                        : asset('frontend/images-limelight/slider-image-mobile-1.webp');
                                @endphp
                                <img class="hero-slide-img-mobile" src="{{ $mobileImageUrl }}"
                                    alt="Slide {{ $index + 1 }} Mobile" loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/images-limelight/slider-image-mobile-1.webp') }}';">
                            @endif

                            <div class="hero-slide-overlay"></div>

                            @if ($slider->title || $slider->description || $slider->link)
                                <div class="hero-slide-content">
                                    @if ($slider->title)
                                        <h1 class="hero-slide-title">{{ $slider->title }}</h1>
                                    @endif
                                    @if ($slider->description)
                                        <p class="hero-slide-description">{{ $slider->description }}</p>
                                    @endif
                                    @if ($slider->link)
                                        <a href="{{ $slider->link }}" class="hero-slide-btn">Shop Now</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Pagination Dots -->
                    <div class="hero-pagination-dots">
                        @foreach($sliders as $index => $slider)
                            <div class="hero-pagination-dot {{ $index === 0 ? 'hero-dot-active' : '' }}"
                                onclick="heroGoToSlide({{ $index }})"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- categories -->
    <div class="sec-banner bg0 p-t-40 p-b-25">
        <div class="container-fluid text-center">
            <div class="p-b-30">
                <h2 class="ltext-103 cl5">
                    Collections
                </h2>
            </div>

            <!-- Collections Slider Container -->
            <div class="collections-slider-wrapper">
                <div class="collections-slider-track" id="collectionsSliderTrack">
                    @forelse($categories ?? [] as $index => $category)
                        <div class="collections-slider-item">
                            <a href="{{ route('shop', ['categories' => [$category->id]]) }}" class="block1-gradient-card">
                                <div class="block1-img-wrapper">
                                    @if ($category->banner_image)
                                        <img src="{{ asset($category->banner_image) }}" alt="{{ $category->name }}"
                                            loading="lazy">
                                    @elseif($category->image)
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                            loading="lazy">
                                    @endif
                                    <div class="block1-overlay"></div>
                                    <div class="block1-content">
                                        @if ($category->name)
                                            <h3 class="block1-name ltext-102 trans-04">
                                                {{ $category->name }}
                                            </h3>
                                        @endif

                                        <div class="block1-link stext-101 trans-09">
                                            Shop Now
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <!-- Default cards if no categories exist -->
                        <div class="collections-slider-item">
                            <a href="{{ route('shop') }}" class="block1-gradient-card">
                                <div class="block1-img-wrapper">
                                    <img src="{{ asset('frontend/images-limelight/md-1.webp') }}" alt="Collection"
                                        loading="lazy">
                                    <div class="block1-overlay"></div>
                                    <div class="block1-content">
                                        <h3 class="block1-name ltext-102 trans-04">
                                            Collection
                                        </h3>
                                        <p class="block1-info stext-102 trans-04">
                                            Explore Our Products
                                        </p>
                                        <div class="block1-link stext-101 trans-09">
                                            Shop Now
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Navigation Arrows -->
                <button class="collections-slider-nav collections-slider-prev" id="collectionsPrevBtn">
                    <i class="zmdi zmdi-chevron-left"></i>
                </button>
                <button class="collections-slider-nav collections-slider-next" id="collectionsNextBtn">
                    <i class="zmdi zmdi-chevron-right"></i>
                </button>
            </div>

            <!-- Navigation Dots -->
            @if (isset($categories) && $categories->count() > 0)
                <div class="collections-slider-dots" id="collectionsSliderDots">
                    @foreach ($categories as $index => $category)
                        <button class="collections-dot {{ $index === 0 ? 'collections-dot-active' : '' }}"
                            onclick="collectionsGoToSlide({{ $index }})"></button>
                    @endforeach
                </div>
            @else
                <div class="collections-slider-dots" id="collectionsSliderDots">
                    <button class="collections-dot collections-dot-active" onclick="collectionsGoToSlide(0)"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Summer Collection Products Section -->
    {{-- @if(isset($summerCollectionProducts) && $summerCollectionProducts->count() > 0)
    <section class="bg0 p-t-10 p-b-10">
        <div class="container trending-section">
            <div class="title-divider">
                <hr>
                <h2 class="section-title">Summer Collection</h2>
                <hr>
            </div>

            <div class="row mt-5">
                @forelse($summerCollectionProducts ?? [] as $product)
                    @include('frontend.partials.product-card', [
                        'product' => $product,
                        'isFirst' => $loop->first,
                        'columnClasses' => 'col-6 col-lg-3'
                    ])
                @empty
                    <!-- Fallback if no summer collection products -->
                    <div class="col-12 text-center">
                        <p class="text-muted">No Summer Collection products available at the moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('shop') }}" class="view-more-btn btn btn-outline-dark">
                    View More
                </a>
            </div>
        </div>
    </section>
    @endif --}}

    <!-- new arrivals Products Section -->
    <section class="bg0 p-t-10 p-b-10">
        <div class="container trending-section">
            <div class="title-divider">
                <hr>
                <h2 class="section-title">New Arrivals</h2>
                <hr>
            </div>

            <div class="row mt-5">
                @forelse($newArrivalProducts ?? [] as $product)
                    @include('frontend.partials.product-card', [
                        'product' => $product,
                        'isFirst' => $loop->first,
                        'columnClasses' => 'col-6 col-lg-3'
                    ])
                @empty
                    <!-- Fallback if no new arrival products -->
                    <div class="col-12 text-center">
                        <p class="text-muted">No new arrival products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="view-more-btn btn btn-outline-dark">
                        View More
                    </a>
            </div>

            {{-- @if(isset($newArrivalProducts) && $newArrivalTotal > 4)
                <div class="text-center mt-4">
                    <button class="view-more-btn btn btn-outline-dark" data-section="new_arrival" data-offset="4">View More</button>
                </div>
            @endif --}}
        </div>
    </section>

    {{-- banner section  --}}
    <section class="banner-section">
        <div class="container-fluid p-0">
            <div class="banner-grid">
                <!-- Casual Banner -->
                <a href="{{ url('/shop?categories[0]=4') }}" class="banner-link">
                    <div class="banner-item">
                        <img src="{{ asset('frontend/images/banner.jpg') }}" alt="Batool Pret Casual Collection"
                            class="banner-image">
                        <div class="banner-content">
                            <h2 class="banner-title">Casuals</h2>
                            <p class="banner-description">
                                Batool Pret brings modern casual wear for women—comfortable, stylish, and perfect for everyday
                                fashion.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Formal Banner -->
                <a href="{{ url('/shop?categories[0]=3') }}" class="banner-link">
                    <div class="banner-item marginLeft">
                        <img src="{{ asset('frontend/images/banner2.jpg') }}" alt="Batool Pret Formal Collection"
                            class="banner-image">
                        <div class="banner-content">
                            <h2 class="banner-title">Formals</h2>
                            <p class="banner-description">
                                Batool Pret formal wear blends timeless elegance with modern design, perfect for festive events
                                and special occasions.
                            </p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- Trending Products Section -->

    <section class="bg0 p-t-10 p-b-10">
        <div class="container trending-section">
            <div class="title-divider">
                <hr>
                <h2 class="section-title">Trending</h2>
                <hr>
            </div>

            <div class="row mt-5">
                @forelse($trendingProducts ?? [] as $product)
                    @include('frontend.partials.product-card', [
                        'product' => $product,
                        'isFirst' => $loop->first,
                        'columnClasses' => 'col-6 col-lg-3'
                    ])
                @empty
                    <!-- Fallback if no trending products -->
                    <div class="col-12 text-center">
                        <p class="text-muted">No trending products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('shop') }}" class="view-more-btn btn btn-outline-dark">
                    View More
                </a>
            </div>
            {{-- @if(isset($trendingProducts) && $trendingTotal > 4)
                <div class="text-center mt-4">
                    <button class="view-more-btn btn btn-outline-dark" data-section="trending" data-offset="4">View More</button>
                </div>
            @endif --}}
        </div>
    </section>


    <!-- Trending Products Section -->

    <section class="bg0 p-t-10 p-b-10">
        <div class="container trending-section">
            <div class="title-divider">
                <hr>
                <h2 class="section-title">Best Selling</h2>
                <hr>
            </div>

            <div class="row mt-5">
                @forelse($bestSellingProducts ?? [] as $product)
                    @include('frontend.partials.product-card', [
                        'product' => $product,
                        'isFirst' => $loop->first,
                        'columnClasses' => 'col-6 col-lg-3'
                    ])
                @empty
                    <!-- Fallback if no best selling products -->
                    <div class="col-12 text-center">
                        <p class="text-muted">No best selling products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('shop') }}" class="view-more-btn btn btn-outline-dark">
                    View More
                </a>
            </div>

            {{-- @if(isset($bestSellingProducts) && $bestSellingTotal > 4)
                <div class="text-center mt-4">
                    <button class="view-more-btn btn btn-outline-dark" data-section="best_selling" data-offset="4">View More</button>
                </div>
            @endif --}}
        </div>
    </section>


    <!-- Video Testimonials Section -->
    {{-- <section class="video-testimonials-section">
        <div class="video-testimonials-title">
            <h2>Customer Reviews</h2>
            <p>See what our customers are saying</p>
        </div>

        @if (isset($testimonials) && $testimonials->count() > 0)
        <div class="video-testimonials-carousel">
            <div class="video-testimonials-track" id="videoTestimonialsTrack">
                @foreach ($testimonials as $testimonial)
                    <div class="video-testimonial-card"
                         data-video="{{ $testimonial->video ? asset($testimonial->video) : '' }}"
                         onclick="openVideoModal(this)">
                        <div class="video-testimonial-media">
                            @if($testimonial->video)
                                <!-- Video Thumbnail -->
                                <video preload="metadata" muted>
                                    <source src="{{ asset($testimonial->video) }}#t=0.1" type="video/mp4">
                                </video>
                                <!-- Play Button Overlay -->
                                <div class="video-play-overlay">
                                    <div class="video-play-button">
                                        <i class="fa fa-play"></i>
                                    </div>
                                </div>
                            @elseif($testimonial->image)
                                <!-- Image Only -->
                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}">
                            @else
                                <!-- Placeholder -->
                                <img src="{{ asset('frontend/images/placeholder-testimonial.jpg') }}" alt="{{ $testimonial->name }}">
                            @endif

                            <!-- Customer Info Overlay -->
                            <div class="video-testimonial-info">
                                <div class="video-testimonial-name">
                                    {{ $testimonial->name }}
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="video-testimonial-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <div class="video-testimonials-nav">
                <button class="video-testimonials-prev" onclick="scrollTestimonials('left')" aria-label="Previous">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="video-testimonials-next" onclick="scrollTestimonials('right')" aria-label="Next">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted">No testimonials available at the moment.</p>
        </div>
        @endif
    </section> --}}

    <!-- Video Modal -->
    {{-- <div class="video-modal" id="videoModal" onclick="closeVideoModal(event)">
        <div class="video-modal-content">
            <button class="video-modal-close" onclick="closeVideoModal(event)">
                <i class="fa fa-times"></i>
            </button>
            <video id="modalVideo" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div> --}}

@endsection

@push('scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/video-testimonials.css') }}">
    <script src="{{ asset('frontend/js/video-testimonials.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.view-more-btn').on('click', function() {
                var section = $(this).data('section');
                var offset = $(this).data('offset');
                var btn = $(this);
                var row = btn.closest('.trending-section').find('.row');

                btn.prop('disabled', true).text('Loading...');

                $.ajax({
                    url: '{{ route("loadMoreProducts") }}',
                    method: 'GET',
                    data: { section: section, offset: offset },
                    success: function(data) {
                        if (data.products && data.products.length > 0) {
                            row.append(data.products.join(''));
                            if (data.hasMore) {
                                btn.data('offset', parseInt(offset) + 4);
                                btn.prop('disabled', false).text('View More');
                            } else {
                                btn.hide();
                            }
                        } else {
                            btn.hide();
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('View More');
                        let errorMessage = 'Error loading more products. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
@endpush

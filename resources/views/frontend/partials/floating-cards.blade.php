<!-- Floating Cards Section -->
<section class="floating-cards-section">
    <div class="floating-cards-container">
        <!-- Header -->
        <div class="floating-cards-header">
            <h2>Featured Picks</h2>
            <p>Discover our handpicked selection of premium pieces</p>
        </div>

        <!-- Floating Cards Grid -->
        <div class="floating-cards-grid">
            @forelse($featuredProducts ?? [] as $index => $product)
                <div class="floating-card card-{{ ($index % 5) + 1 }}" 
                     data-link="{{ route('productDetail', $product->slug) }}">
                    
                    <!-- Card Image -->
                    <div class="floating-card-image">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 loading="lazy"
                                 onerror="this.src='{{ asset('frontend/images-limelight/placeholder.webp') }}'">
                        @else
                            <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" 
                                 alt="{{ $product->name }}">
                        @endif
                    </div>

                    <!-- Card Overlay -->
                    <div class="floating-card-overlay"></div>

                    <!-- Card Content -->
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">{{ $product->name }}</h3>
                        
                        <div class="floating-card-meta">
                            <span class="floating-card-price">
                                @if($product->discount_price)
                                    Rs.{{ number_format($product->discount_price, 2) }}
                                @else
                                    Rs.{{ number_format($product->price, 2) }}
                                @endif
                            </span>
                            @if($product->discount_price)
                                <span class="floating-card-discount">
                                    -{{ $product->discount_percent ?? 0 }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <button class="floating-card-cta" onclick="window.location.href='{{ route('productDetail', $product->slug) }}'">
                        View Details
                    </button>
                </div>

                @if($loop->count >= 5)
                    @break
                @endif
            @empty
                <!-- Fallback cards if no products -->
                <div class="floating-card card-1" onclick="window.location.href='{{ route('shop') }}'">
                    <div class="floating-card-image">
                        <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" alt="Featured Product 1">
                    </div>
                    <div class="floating-card-overlay"></div>
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">Featured Product</h3>
                        <div class="floating-card-meta">
                            <span class="floating-card-price">Explore Now</span>
                        </div>
                    </div>
                    <button class="floating-card-cta">View Collection</button>
                </div>

                <div class="floating-card card-2" onclick="window.location.href='{{ route('shop') }}'">
                    <div class="floating-card-image">
                        <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" alt="Featured Product 2">
                    </div>
                    <div class="floating-card-overlay"></div>
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">Premium Selection</h3>
                        <div class="floating-card-meta">
                            <span class="floating-card-price">Curated</span>
                        </div>
                    </div>
                    <button class="floating-card-cta">Browse Collection</button>
                </div>

                <div class="floating-card card-3" onclick="window.location.href='{{ route('shop') }}'">
                    <div class="floating-card-image">
                        <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" alt="Featured Product 3">
                    </div>
                    <div class="floating-card-overlay"></div>
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">Trending Now</h3>
                        <div class="floating-card-meta">
                            <span class="floating-card-price">Latest Drops</span>
                        </div>
                    </div>
                    <button class="floating-card-cta">Discover</button>
                </div>

                <div class="floating-card card-4" onclick="window.location.href='{{ route('shop') }}'">
                    <div class="floating-card-image">
                        <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" alt="Featured Product 4">
                    </div>
                    <div class="floating-card-overlay"></div>
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">Exclusive Picks</h3>
                        <div class="floating-card-meta">
                            <span class="floating-card-price">Limited</span>
                        </div>
                    </div>
                    <button class="floating-card-cta">Explore</button>
                </div>

                <div class="floating-card card-5" onclick="window.location.href='{{ route('shop') }}'">
                    <div class="floating-card-image">
                        <img src="{{ asset('frontend/images-limelight/placeholder.webp') }}" alt="Featured Product 5">
                    </div>
                    <div class="floating-card-overlay"></div>
                    <div class="floating-card-content">
                        <h3 class="floating-card-title">New Collection</h3>
                        <div class="floating-card-meta">
                            <span class="floating-card-price">Special</span>
                        </div>
                    </div>
                    <button class="floating-card-cta">View More</button>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="floating-cards-footer">
            <p>Explore our complete collection of premium fashion pieces</p>
            <a href="{{ route('shop') }}" class="floating-cards-view-all">View All Collection</a>
        </div>
    </div>
</section>

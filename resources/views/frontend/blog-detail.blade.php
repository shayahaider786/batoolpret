@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('blog.detail', $blog->slug) }}">
@endpush

@section('content')

    <div class="bg-white">
        <div class="container headerTop p-5">

        </div>
    </div>
    <!-- Blog Detail Hero Section -->
    @if ($blog->featured_image)
        <section class="blog-detail-hero"
            style="position: relative; min-height: 550px; display: flex; align-items: center; background: #000; overflow: hidden;">
            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="blog-hero-bg-image"
                style="position: absolute; width: 100%; height: 100%; object-fit: cover; opacity: 0.25; top: 0; left: 0;">
            <div class="container" style="position: relative; z-index: 2;">
                <div class="row">
                    <div class="col-lg-10 col-md-12 mx-auto">
                        <div class="blog-detail-header">
                            <div class="blog-detail-meta-top">
                                <span class="blog-category-tag">FASHION</span>
                                <span class="blog-meta-separator">•</span>
                                <span
                                    class="blog-date-detail">{{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}</span>
                                @if ($blog->views > 0)
                                    <span class="blog-meta-separator">•</span>
                                    <span class="blog-views-count">{{ $blog->views }}
                                        {{ Str::plural('view', $blog->views) }}</span>
                                @endif
                            </div>
                            <h1 class="blog-detail-heading">{{ $blog->title }}</h1>
                            <div class="blog-author-detail">
                                <span class="blog-by-text">BY</span>
                                <span class="blog-author-name">{{ $blog->author }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="blog-detail-hero-simple" style="background: #000; padding: 100px 0 70px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-12 mx-auto text-center">
                        <div class="blog-detail-header">
                            <div class="blog-detail-meta-top">
                                <span class="blog-category-tag">FASHION</span>
                                <span class="blog-meta-separator">•</span>
                                <span
                                    class="blog-date-detail">{{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}</span>
                                @if ($blog->views > 0)
                                    <span class="blog-meta-separator">•</span>
                                    <span class="blog-views-count">{{ $blog->views }}
                                        {{ Str::plural('view', $blog->views) }}</span>
                                @endif
                            </div>
                            <h1 class="blog-detail-heading">{{ $blog->title }}</h1>
                            <div class="blog-author-detail">
                                <span class="blog-by-text">BY</span>
                                <span class="blog-author-name">{{ $blog->author }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Blog Content Section -->
    <section class="blog-content-section" style="background: #fff; padding: 70px 0 100px;">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 col-md-12">
                    <article class="blog-article-content">
                        @if ($blog->excerpt)
                            <div class="blog-excerpt-block">
                                <p class="blog-excerpt-text">{{ $blog->excerpt }}</p>
                            </div>
                        @endif

                        <div class="blog-content-body">
                            {!! nl2br(e($blog->content)) !!}
                        </div>

                        <!-- Share Section -->
                        <div class="blog-share-section">
                            <div class="share-section-divider"></div>
                            <div class="share-content">
                                <h5 class="share-title">Share This Story</h5>
                                <div class="share-buttons-grid">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.detail', $blog->slug)) }}"
                                        target="_blank" class="share-button share-facebook" title="Share on Facebook">
                                        <i class="zmdi zmdi-facebook"></i>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.detail', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                        target="_blank" class="share-button share-twitter" title="Share on Twitter">
                                        <i class="zmdi zmdi-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.detail', $blog->slug)) }}"
                                        target="_blank" class="share-button share-linkedin" title="Share on LinkedIn">
                                        <i class="zmdi zmdi-linkedin"></i>
                                        <span>LinkedIn</span>
                                    </a>
                                    <a href="whatsapp://send?text={{ urlencode($blog->title . ' ' . route('blog.detail', $blog->slug)) }}"
                                        target="_blank" class="share-button share-whatsapp" title="Share on WhatsApp">
                                        <i class="zmdi zmdi-whatsapp"></i>
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Related Articles -->
                    @if ($relatedBlogs && $relatedBlogs->count() > 0)
                        <section class="related-articles-section">
                            <div class="section-divider-line"></div>
                            <h3 class="related-section-title">You May Also Like</h3>
                            <div class="related-articles-grid">
                                @foreach ($relatedBlogs as $relatedBlog)
                                    <article class="related-article-card">
                                        @if ($relatedBlog->featured_image)
                                            <a href="{{ route('blog.detail', $relatedBlog->slug) }}"
                                                class="related-article-image">
                                                <img src="{{ asset($relatedBlog->featured_image) }}"
                                                    alt="{{ $relatedBlog->title }}" loading="lazy">
                                            </a>
                                        @endif
                                        <div class="related-article-content">
                                            <span
                                                class="related-article-date">{{ $relatedBlog->published_at ? $relatedBlog->published_at->format('M d, Y') : $relatedBlog->created_at->format('M d, Y') }}</span>
                                            <h4 class="related-article-title">
                                                <a
                                                    href="{{ route('blog.detail', $relatedBlog->slug) }}">{{ Str::limit($relatedBlog->title, 65) }}</a>
                                            </h4>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="col-lg-4 col-md-12">
                    <div class="blog-detail-sidebar">
                        @if ($latestBlogs && $latestBlogs->count() > 0)
                            <div class="sidebar-widget-detail">
                                <h4 class="sidebar-title-detail">Recent Articles</h4>
                                <ul class="sidebar-list-detail">
                                    @foreach ($latestBlogs as $latestBlog)
                                        <li class="sidebar-item-detail">
                                            <a href="{{ route('blog.detail', $latestBlog->slug) }}"
                                                class="sidebar-link-detail">
                                                <div class="sidebar-item-content">
                                                    <span
                                                        class="sidebar-item-date">{{ $latestBlog->published_at ? $latestBlog->published_at->format('M d') : $latestBlog->created_at->format('M d') }}</span>
                                                    <h5 class="sidebar-item-title">{{ Str::limit($latestBlog->title, 60) }}
                                                    </h5>
                                                </div>
                                                <span class="sidebar-arrow">→</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="sidebar-divider-detail"></div>

                        <div class="back-to-blogs-btn-wrapper">
                            <a href="{{ route('blogs') }}" class="back-to-blogs-btn">
                                <span class="back-arrow">←</span>
                                <span>All Articles</span>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @push('scripts')
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/blogs.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/blog-detail.css') }}">
    @endpush
@endsection

@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('blogs') }}">
@endpush

@section('content')

    <div class="bg-white">
        <div class="container headerTop p-5">

        </div>
    </div>
    <!-- Blog Hero Section -->
    <section class="blog-hero-wrapper" style="background: #000; padding: 80px 0 60px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="blog-main-title"
                        style="color: #fff; font-size: 56px; font-weight: 200; letter-spacing: 6px; text-transform: uppercase; margin-bottom: 20px; font-family: 'Playfair Display', serif;">
                        Fashion Journal
                    </h1>
                    <div class="blog-hero-divider" style="width: 80px; height: 2px; background: #fff; margin: 25px auto;">
                    </div>
                    <p class="blog-hero-subtitle"
                        style="color: #ccc; font-size: 16px; font-weight: 300; letter-spacing: 3px; text-transform: uppercase; margin-top: 20px;">
                        Stories · Style · Inspiration
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Listing Section -->
    <section class="blog-listing-section" style="background: #fff; padding: 80px 0;">
        <div class="container">
            <div class="row">
                <!-- Main Blog Content -->
                <div class="col-lg-9 col-md-12">
                    @if ($blogs->count() > 0)
                        <div class="blog-grid">
                            @foreach ($blogs as $blog)
                                <article class="blog-card-elegant">
                                    <a href="{{ route('blog.detail', $blog->slug) }}" class="blog-image-link">
                                        @if ($blog->featured_image)
                                            <div class="blog-image-container">
                                                <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}"
                                                    class="blog-featured-img" loading="lazy">
                                                <div class="blog-image-overlay"></div>
                                            </div>
                                        @else
                                            <div class="blog-placeholder"
                                                style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; height: 320px;">
                                                <span style="color: #999; font-size: 14px; letter-spacing: 2px;">NO
                                                    IMAGE</span>
                                            </div>
                                        @endif
                                    </a>

                                    <div class="blog-card-content">
                                        <div class="blog-meta-elegant">
                                            <span
                                                class="blog-date">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
                                            <span class="blog-separator">—</span>
                                            <span class="blog-author">{{ $blog->author }}</span>
                                        </div>

                                        <h2 class="blog-title-elegant">
                                            <a href="{{ route('blog.detail', $blog->slug) }}" class="blog-title-link">
                                                {{ $blog->title }}
                                            </a>
                                        </h2>

                                        <p class="blog-excerpt-elegant">
                                            {{ Str::limit(strip_tags($blog->excerpt), 150) }}
                                        </p>

                                        <a href="{{ route('blog.detail', $blog->slug) }}" class="blog-read-link">
                                            Read Article
                                            <span class="arrow-icon">→</span>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($blogs->hasPages())
                            <div class="blog-pagination-wrapper">
                                {{ $blogs->links() }}
                            </div>
                        @endif
                    @else
                        <div class="blog-empty-state">
                            <div class="empty-state-icon" style="font-size: 72px; color: #e0e0e0; margin-bottom: 30px;">📝
                            </div>
                            <h3 class="empty-state-title">No Articles Yet</h3>
                            <p class="empty-state-text">Stay tuned for fashion insights, style tips, and inspiration.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="col-lg-3 col-md-12">
                    <div class="blog-sidebar-elegant">
                        @if ($latestBlogs && $latestBlogs->count() > 0)
                            <div class="sidebar-widget-elegant">
                                <h3 class="sidebar-widget-title">Latest Posts</h3>
                                <ul class="sidebar-blog-list-elegant">
                                    @foreach ($latestBlogs as $latestBlog)
                                        <li class="sidebar-blog-item">
                                            <a href="{{ route('blog.detail', $latestBlog->slug) }}"
                                                class="sidebar-blog-link">
                                                <span
                                                    class="sidebar-blog-date">{{ $latestBlog->published_at ? $latestBlog->published_at->format('M d') : $latestBlog->created_at->format('M d') }}</span>
                                                <span
                                                    class="sidebar-blog-title">{{ Str::limit($latestBlog->title, 55) }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="sidebar-divider"></div>

                        <div class="sidebar-cta">
                            <h4 class="sidebar-cta-title">Stay Updated</h4>
                            <p class="sidebar-cta-text">Follow us for the latest in fashion and style inspiration.</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @push('scripts')
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/blogs.css') }}">
    @endpush
@endsection

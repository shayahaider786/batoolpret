<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap
     */
    public function index()
    {
        // Get all active products with slug and updated_at
        $products = Product::select('slug', 'updated_at')
            ->where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get all active categories
        $categories = Category::select('slug', 'updated_at')
            ->where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get all published blogs
        $blogs = Blog::select('slug', 'updated_at')
            ->where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Static pages
        $staticPages = [
            [
                'url' => route('index'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'url' => route('shop'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => route('about'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'url' => route('contact'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'url' => route('blogs'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
        ];

        // Return XML response
        return response()
            ->view('sitemap', [
                'products' => $products,
                'categories' => $categories,
                'blogs' => $blogs,
                'staticPages' => $staticPages,
            ])
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate Meta (Facebook) Product Feed XML
     */
    public function metaProductFeed()
    {
        // Get all active products with required fields
        $products = Product::select(
            'id',
            'name',
            'slug',
            'short_description',
            'long_description',
            'price',
            'discount_price',
            'image',
            'stock'
        )
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();

        // Return RSS 2.0 XML response for Meta
        return response()
            ->view('meta-product-feed', [
                'products' => $products,
            ])
            ->header('Content-Type', 'application/xml');
    }
}


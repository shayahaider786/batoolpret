<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class frontendController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        $isAuthenticated = Auth::check();

        // For authenticated users, always fetch fresh data
        // For guests, use full-page caching (5 minutes)
        $cacheKey = 'frontend.home.guest';
        $cacheTTL = 300; // 5 minutes

        if ($isAuthenticated) {
            // Bypass cache for authenticated users
            $pageHTML = $this->getHomePageData();

            return response($pageHTML)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } else {
            // Use full-page caching for guest users
            return Cache::remember($cacheKey, $cacheTTL, function () {
                return $this->getHomePageData();
            });
        }
    }

    /**
     * Get home page data with all required products and categories
     * Returns the rendered HTML view
     */
    private function getHomePageData()
    {
        // Cache sliders for 1 hour (they change infrequently)
        $sliders = Cache::remember('sliders.latest', 3600, function () {
            return Slider::latest()->limit(5)->get();
        });

        // Cache categories for 1 hour - only select needed fields
        $categories = Cache::remember('categories.active.with_images', 3600, function () {
            return Category::select('id', 'name', 'slug', 'description', 'image', 'banner_image')
                ->active()
                ->where(function ($query) {
                    $query->whereNotNull('banner_image')
                        ->orWhereNotNull('image');
                })
                ->latest()
                ->limit(8)
                ->get();
        });

        // Cache new arrival products for 30 minutes - with categories and colors
        $newArrivalProducts = Cache::remember('products.new_arrival.full', 1800, function () {
            return Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    },
                    'images' => function ($query) {
                        $query->select('id', 'product_id', 'image')->limit(1);
                    },
                ])
                ->where('status', 'active')
                ->where('tag', 'new_arrival')
                ->latest()
                ->limit(4)
                ->get();
        });

        // Cache new arrival total count
        $newArrivalTotal = Cache::remember('products.new_arrival.count', 1800, function () {
            return Product::where('status', 'active')->where('tag', 'new_arrival')->count();
        });

        // Cache trending products for 30 minutes - with categories and colors
        $trendingProducts = Cache::remember('products.trending.full', 1800, function () {
            return Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    },
                    'images' => function ($query) {
                        $query->select('id', 'product_id', 'image')->limit(1);
                    },
                ])
                ->where('status', 'active')
                ->where('tag', 'trending')
                ->latest()
                ->limit(4)
                ->get();
        });

        // Cache trending total count
        $trendingTotal = Cache::remember('products.trending.count', 1800, function () {
            return Product::where('status', 'active')->where('tag', 'trending')->count();
        });

        // Cache best selling products for 30 minutes - with categories and colors
        $bestSellingProducts = Cache::remember('products.best_selling.full', 1800, function () {
            return Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    },
                    'images' => function ($query) {
                        $query->select('id', 'product_id', 'image')->limit(1);
                    },
                ])
                ->where('status', 'active')
                ->where('tag', 'best_selling')
                ->latest()
                ->limit(4)
                ->get();
        });

        // Cache best selling total count
        $bestSellingTotal = Cache::remember('products.best_selling.count', 1800, function () {
            return Product::where('status', 'active')->where('tag', 'best_selling')->count();
        });

        // Cache latest products for 30 minutes - with categories and colors
        $products = Cache::remember('products.latest.full', 1800, function () {
            return Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id')
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    },
                    'images' => function ($query) {
                        $query->select('id', 'product_id', 'image')->limit(1);
                    },
                ])
                ->where('status', 'active')
                ->latest()
                ->limit(12)
                ->get();
        });

        // SUMMER COLLECTION products (replaces Eid Collection)
        $summerCollectionProducts = Cache::remember('products.summer_collection.full', 1800, function () {
            // Find Summer category (you can modify this logic based on your needs)
            $summerCategory = Category::where(function ($q) {
                $q->where('name', 'LIKE', '%summer%')
                    ->orWhere('slug', 'LIKE', '%summer%')
                    ->orWhere('name', 'LIKE', '%seasonal%');
            })->active()->first();

            if ($summerCategory) {
                // Get category IDs (parent + children)
                $categoryIds = [$summerCategory->id];
                $childCategoryIds = Category::where('parent_id', $summerCategory->id)->pluck('id')->toArray();
                $categoryIds = array_merge($categoryIds, $childCategoryIds);

                return Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                    ->with([
                        'category' => function ($query) {
                            $query->select('id', 'name', 'slug');
                        },
                        'images' => function ($query) {
                            $query->select('id', 'product_id', 'image')->limit(1);
                        },
                    ])
                    ->where('status', 'active')
                    ->whereIn('category_id', $categoryIds)
                    ->latest()
                    ->limit(8)
                    ->get();
            }

            return collect(); // Return empty collection if no Summer category
        });

        // Cache summer collection total count
        $summerCollectionTotal = Cache::remember('products.summer_collection.count', 1800, function () {
            $summerCategory = Category::where(function ($q) {
                $q->where('name', 'LIKE', '%summer%')
                    ->orWhere('slug', 'LIKE', '%summer%')
                    ->orWhere('name', 'LIKE', '%seasonal%');
            })->active()->first();

            if ($summerCategory) {
                $categoryIds = [$summerCategory->id];
                $childCategoryIds = Category::where('parent_id', $summerCategory->id)->pluck('id')->toArray();
                $categoryIds = array_merge($categoryIds, $childCategoryIds);

                return Product::where('status', 'active')->whereIn('category_id', $categoryIds)->count();
            }

            return 0;
        });

        // Store Summer category ID for the view more button link
        $summerCategoryId = null;
        $summerCategory = Category::where(function ($q) {
            $q->where('name', 'LIKE', '%summer%')
                ->orWhere('slug', 'LIKE', '%summer%')
                ->orWhere('name', 'LIKE', '%seasonal%');
        })->active()->first();

        if ($summerCategory) {
            $summerCategoryId = $summerCategory->id;
        }

        // Cache testimonials for 1 hour
        $testimonials = Cache::remember('testimonials.active', 3600, function () {
            return Testimonial::active()->ordered()->get();
        });

        // Render view and return HTML string
        return view('frontend.index', compact(
            'products',
            'sliders',
            'categories',
            'trendingProducts',
            'newArrivalProducts',
            'testimonials',
            'bestSellingProducts',
            'summerCollectionProducts',      // Updated variable name
            'newArrivalTotal',
            'trendingTotal',
            'bestSellingTotal',
            'summerCollectionTotal',          // Updated variable name
            'summerCategoryId'                // Updated variable name
        ))->render();
    }

    public function about()
    {
        return view('frontend.aboutus');
    }

    public function Shop(Request $request)
    {
        // Lightweight query - only category filtering
        $query = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'status', 'tag')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'name', 'slug');
                },
                'images' => function ($query) {
                    $query->select('id', 'product_id', 'image')->limit(1);
                },
            ])
            ->where('status', 'active');

        // Get Bags category to exclude from various views
        $bagsCategory = Category::where('name', 'Bags')->active()->first();
        $bagsCategoryIds = [];
        if ($bagsCategory) {
            $bagsCategoryIds[] = $bagsCategory->id;
            // Also get all children of Bags category
            $bagsChildren = Category::where('parent_id', $bagsCategory->id)->pluck('id')->toArray();
            $bagsCategoryIds = array_merge($bagsCategoryIds, $bagsChildren);
        }

        // Filter by tag (trending, new_arrival, best_selling)
        if ($request->filled('tag')) {
            $tag = $request->input('tag');
            // Validate tag to prevent SQL injection
            if (in_array($tag, ['trending', 'new_arrival', 'best_selling'])) {
                $query->where('tag', $tag);
                // Exclude Bags from tag filters
                if (! empty($bagsCategoryIds)) {
                    $query->whereNotIn('category_id', $bagsCategoryIds);
                }
            }
        }

        // Filter by sale (products with discount_price)
        if ($request->filled('sale') && $request->input('sale') == 'true') {
            $query->whereNotNull('discount_price')
                ->where('discount_price', '>', 0);
            // Exclude Bags from sale section
            if (! empty($bagsCategoryIds)) {
                $query->whereNotIn('category_id', $bagsCategoryIds);
            }
        }

        // Filter by category only
        if ($request->filled('categories')) {
            $categories = is_array($request->input('categories'))
                ? $request->input('categories')
                : [$request->input('categories')];

            // Get all child category IDs for selected parent categories
            $allCategoryIds = collect($categories);
            foreach ($categories as $categoryId) {
                $childCategories = Category::where('parent_id', $categoryId)->pluck('id');
                $allCategoryIds = $allCategoryIds->merge($childCategories);
            }

            // Cross-category logic: FORMAL and ZAYLISH SIGNATURE show each other's products
            $formalCategory = Category::where('name', 'FORMAL')->first();
            $zaylishSignatureCategory = Category::where('name', 'ZAYLISH SIGNATURE')->first();

            if ($formalCategory && $zaylishSignatureCategory) {
                // If FORMAL is selected, also include ZAYLISH SIGNATURE products
                if ($allCategoryIds->contains($formalCategory->id)) {
                    $allCategoryIds->push($zaylishSignatureCategory->id);
                    // Also include children of ZAYLISH SIGNATURE
                    $zaylishChildren = Category::where('parent_id', $zaylishSignatureCategory->id)->pluck('id');
                    $allCategoryIds = $allCategoryIds->merge($zaylishChildren);
                }

                // If ZAYLISH SIGNATURE is selected, also include FORMAL products
                if ($allCategoryIds->contains($zaylishSignatureCategory->id)) {
                    $allCategoryIds->push($formalCategory->id);
                    // Also include children of FORMAL
                    $formalChildren = Category::where('parent_id', $formalCategory->id)->pluck('id');
                    $allCategoryIds = $allCategoryIds->merge($formalChildren);
                }
            }

            $query->whereIn('category_id', $allCategoryIds->unique()->toArray());
        } else {
            // When no category, tag, or sale filter is selected (All Products view), exclude Bags products
            if (! $request->filled('tag') && ! $request->filled('sale') && ! empty($bagsCategoryIds)) {
                $query->whereNotIn('category_id', $bagsCategoryIds);
            }
        }

        // Default sorting: newest first
        $query->latest();

        // Paginate with 12 products per page for traditional pagination
        $products = $query->paginate(12);

        // Cache parent categories for 1 hour
        $parentCategories = Cache::remember('categories.parents.active', 3600, function () {
            return Category::parents()->active()->orderBy('name')->get();
        });

        // For tag page view, use the same logic but pass a flag
        $isTagPage = $request->filled('tag');

        return view('frontend.shop', compact('products', 'parentCategories', 'isTagPage'));
    }

    public function casual()
    {
        $category = Category::where(function ($q) {
            $q->where('name', 'LIKE', '%casual%')->orWhere('slug', 'LIKE', '%casual%');
        })->active()->first();

        if ($category) {
            return redirect()->route('shop', ['categories' => [$category->id]]);
        }

        return redirect()->route('shop');
    }

    public function formal()
    {
        $category = Category::where(function ($q) {
            $q->where('name', 'LIKE', '%formal%')->orWhere('slug', 'LIKE', '%formal%');
        })->active()->first();

        if ($category) {
            return redirect()->route('shop', ['categories' => [$category->id]]);
        }

        return redirect()->route('shop');
    }

    public function productDetail($slug)
    {
        // Optimize query with select to reduce data transfer
        $product = Product::select(
            'id',
            'name',
            'slug',
            'price',
            'discount_price',
            'image',
            'category_id',
            'short_description',
            'long_description',
            'fabric',
            'color',
            'size',
            'outfit_type',
            'design_details',
            'includes',
            'care_instructions',
            'disclaimer',
            'sku',
            'stock',
            'youtube_link',
            'size_guide_image',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_tags',
            'status'
        )
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'name', 'slug');
                },
                'images' => function ($query) {
                    $query->select('id', 'product_id', 'image');
                },
                'approvedReviews.user' => function ($query) {
                    $query->select('id', 'name');
                },
            ])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get related products from same category
        // Cross-category logic: FORMAL and ZAYLISH SIGNATURE show each other's products
        $categoryIds = [$product->category_id];

        $formalCategory = Category::where('name', 'FORMAL')->first();
        $zaylishSignatureCategory = Category::where('name', 'ZAYLISH SIGNATURE')->first();

        if ($formalCategory && $zaylishSignatureCategory) {
            // If product is in FORMAL, also include ZAYLISH SIGNATURE products
            if ($product->category_id == $formalCategory->id) {
                $categoryIds[] = $zaylishSignatureCategory->id;
                // Also include children of ZAYLISH SIGNATURE
                $zaylishChildren = Category::where('parent_id', $zaylishSignatureCategory->id)->pluck('id')->toArray();
                $categoryIds = array_merge($categoryIds, $zaylishChildren);
            }

            // If product is in ZAYLISH SIGNATURE, also include FORMAL products
            if ($product->category_id == $zaylishSignatureCategory->id) {
                $categoryIds[] = $formalCategory->id;
                // Also include children of FORMAL
                $formalChildren = Category::where('parent_id', $formalCategory->id)->pluck('id')->toArray();
                $categoryIds = array_merge($categoryIds, $formalChildren);
            }
        }

        // Optimize related products query
        $relatedProducts = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id')
            ->with(['images' => function ($query) {
                $query->select('id', 'product_id', 'image')->limit(1);
            }])
            ->whereIn('category_id', array_unique($categoryIds))
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return view('frontend.productDetail', compact('product', 'relatedProducts'));
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function checkout(Request $request)
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product.category', 'product.images')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::with('product.category', 'product.images')
                ->where('session_id', $sessionId)
                ->get();
        }

        // Redirect to cart if empty
        if ($cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items to your cart before checkout.');
        }

        // Check if any product has discount_price
        $hasDiscountedProducts = $cartItems->contains(function ($item) {
            return $item->product && $item->product->discount_price;
        });

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $coupon = null;
        $discountAmount = 0;
        $total = $subtotal;

        // Handle coupon removal
        if ($request->filled('remove_coupon')) {
            session()->forget('applied_coupon_code');
        }

        // Check for coupon from request or session
        $couponCode = null;
        if ($request->filled('coupon_code')) {
            $couponCode = strtoupper(trim($request->input('coupon_code')));
        } elseif (session('applied_coupon_code')) {
            $couponCode = session('applied_coupon_code');
        }

        // Validate coupon if provided and no discounted products
        if ($couponCode && ! $hasDiscountedProducts) {
            $coupon = Coupon::where('code', $couponCode)->first();

            if ($coupon && $coupon->isValid()) {
                $discountAmount = ($subtotal * $coupon->discount_percent) / 100;
                $total = $subtotal - $discountAmount;
            } else {
                // Remove invalid coupon from session
                session()->forget('applied_coupon_code');
                $coupon = null;
            }
        }

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'total', 'coupon', 'discountAmount', 'hasDiscountedProducts'));
    }

    public function applyCoupon(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'coupon_code' => 'required|string|max:255',
        ]);

        $couponCode = strtoupper(trim($validated['coupon_code']));
        $coupon = Coupon::where('code', $couponCode)->first();

        if (! $coupon) {
            return redirect()->route('checkout')
                ->with('coupon_error', 'Invalid coupon code.');
        }

        if (! $coupon->isValid()) {
            return redirect()->route('checkout')
                ->with('coupon_error', 'This coupon is not valid or has expired.');
        }

        // Check if cart has discounted products
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::with('product')
                ->where('session_id', $sessionId)
                ->get();
        }

        // Check if cart is empty
        if ($cartItems->count() == 0) {
            return redirect()->route('checkout')
                ->with('coupon_error', 'Your cart is empty.');
        }

        $hasDiscountedProducts = $cartItems->contains(function ($item) {
            return $item->product && $item->product->discount_price;
        });

        if ($hasDiscountedProducts) {
            return redirect()->route('checkout')
                ->with('coupon_error', 'Coupon cannot be applied to orders with discounted products.');
        }

        // Store coupon in session so it persists
        session(['applied_coupon_code' => $coupon->code]);

        return redirect()->route('checkout')
            ->with('coupon_success', 'Coupon "'.$coupon->code.'" applied successfully! ('.$coupon->discount_percent.'% off)');
    }

    public function contact()
    {
        return view('frontend.contactus');
    }

    public function thankyou(Request $request)
    {
        // Get order number from URL parameter or session
        $orderNumber = $request->get('order') ?? session('order_number');

        return view('frontend.thankyou', [
            'order_number' => $orderNumber,
        ]);
    }

    public function termsAndConditions()
    {
        return view('frontend.terms');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy');
    }

    /**
     * Display all published blogs
     */
    public function blogs(Request $request)
    {
        $query = Blog::published()->latest('published_at');

        // Optional: Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('excerpt', 'LIKE', '%'.$search.'%')
                    ->orWhere('content', 'LIKE', '%'.$search.'%');
            });
        }

        $blogs = $query->paginate(9)->withQueryString();

        // Get latest blogs for sidebar
        $latestBlogs = Blog::published()->latest('published_at')->limit(5)->get();

        return view('frontend.blogs', compact('blogs', 'latestBlogs'));
    }

    /**
     * Display single blog detail
     */
    public function blogDetail($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();

        // Increment views
        $blog->incrementViews();

        // Get related blogs (same author or latest)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get latest blogs for sidebar
        $latestBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('frontend.blog-detail', compact('blog', 'relatedBlogs', 'latestBlogs'));
    }

    /**
     * Search products via AJAX
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $searchTerm = $request->input('q', '');

        if (strlen($searchTerm) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter at least 2 characters',
                'products' => [],
            ]);
        }

        $products = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', $searchTerm.'%')
                    ->orWhere('short_description', 'LIKE', $searchTerm.'%')
                    ->orWhere('long_description', 'LIKE', $searchTerm.'%');
            })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                $primaryImage = $product->image
                    ? asset($product->image)
                    : asset('frontend/images/product-1.png');

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'discount_price' => $product->discount_price,
                    'image' => $primaryImage,
                    'url' => route('productDetail', $product->slug),
                ];
            });

        return response()->json([
            'success' => true,
            'products' => $products,
            'count' => $products->count(),
        ]);
    }

    /**
     * Load more products for home page sections via AJAX
     */
    public function loadMoreProducts(Request $request)
    {
        try {
            $section = $request->input('section');
            $offset = $request->input('offset', 0);
            $limit = 4;

            $products = collect();

            switch ($section) {
                case 'new_arrival':
                    $products = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                        ->with([
                            'category' => function ($query) {
                                $query->select('id', 'name', 'slug');
                            },
                            'images' => function ($query) {
                                $query->select('id', 'product_id', 'image')->limit(1);
                            },
                        ])
                        ->where('status', 'active')
                        ->where('tag', 'new_arrival')
                        ->latest()
                        ->skip($offset)
                        ->take($limit)
                        ->get();
                    break;

                case 'trending':
                    $products = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                        ->with([
                            'category' => function ($query) {
                                $query->select('id', 'name', 'slug');
                            },
                            'images' => function ($query) {
                                $query->select('id', 'product_id', 'image')->limit(1);
                            },
                        ])
                        ->where('status', 'active')
                        ->where('tag', 'trending')
                        ->latest()
                        ->skip($offset)
                        ->take($limit)
                        ->get();
                    break;

                case 'best_selling':
                    $products = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                        ->with([
                            'category' => function ($query) {
                                $query->select('id', 'name', 'slug');
                            },
                            'images' => function ($query) {
                                $query->select('id', 'product_id', 'image')->limit(1);
                            },
                        ])
                        ->where('status', 'active')
                        ->where('tag', 'best_selling')
                        ->latest()
                        ->skip($offset)
                        ->take($limit)
                        ->get();
                    break;

                case 'eid_collection':
                    // Find EID category
                    $eidCategory = Category::where(function ($q) {
                        $q->where('name', 'LIKE', '%eid%')->orWhere('slug', 'LIKE', '%eid%');
                    })->active()->first();

                    if ($eidCategory) {
                        // Get category IDs (parent + children)
                        $categoryIds = [$eidCategory->id];
                        $childCategoryIds = Category::where('parent_id', $eidCategory->id)->pluck('id')->toArray();
                        $categoryIds = array_merge($categoryIds, $childCategoryIds);

                        $products = Product::select('id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id', 'tag')
                            ->with([
                                'category' => function ($query) {
                                    $query->select('id', 'name', 'slug');
                                },
                                'images' => function ($query) {
                                    $query->select('id', 'product_id', 'image')->limit(1);
                                },
                            ])
                            ->where('status', 'active')
                            ->whereIn('category_id', $categoryIds)
                            ->latest()
                            ->skip($offset)
                            ->take($limit)
                            ->get();
                    }
                    break;
            }

            $renderedProducts = $products->map(function ($product) {
                return view('frontend.partials.product-card', [
                    'product' => $product,
                    'isFirst' => false,
                    'columnClasses' => 'col-6 col-lg-3',
                ])->render();
            });

            return response()->json([
                'products' => $renderedProducts,
                'hasMore' => $products->count() == $limit,
            ]);
        } catch (\Exception $e) {
            \Log::error('Load More Products Error: '.$e->getMessage(), [
                'section' => $request->input('section'),
                'offset' => $request->input('offset'),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Error loading more products. Please try again.',
            ], 500);
        }
    }
}

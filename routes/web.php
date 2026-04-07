<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\frontendController as FrontendController;
use App\Http\Controllers\backendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\CouponController as BackendCouponController;
use App\Http\Controllers\Backend\ReviewController as BackendReviewController;
use App\Http\Controllers\Backend\ContactController as BackendContactController;
use App\Http\Controllers\Backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ReadyToWearController;
use App\Http\Controllers\BestSellerVideoController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SitemapController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Language switching route
Route::get('/lang/change', [LanguageController::class, 'change'])->name('changeLang');

// Public order lookup
Route::get('/order/lookup', [OrderController::class, 'showLookupForm'])->name('order.lookup');
Route::post('/order/lookup', [OrderController::class, 'lookup'])->name('order.lookup.submit');


 // Announcement page (temporarily replacing homepage)
//  Route::get('/', function () {
//      return view('frontend.announcement');
//  })->name('index');

 // Original homepage (commented out temporarily)
 Route::get('/', [FrontendController::class, 'index'])->name('index');
 Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
 Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
 // Quick links for category shortcuts
 Route::get('/shop/casual', [FrontendController::class, 'casual'])->name('shop.casual');
 Route::get('/shop/formal', [FrontendController::class, 'formal'])->name('shop.formal');
 Route::get('/product/{slug}', [FrontendController::class, 'productDetail'])->name('productDetail');
 Route::get('/search/products', [FrontendController::class, 'searchProducts'])->name('search.products');
 Route::get('/load-more-products', [FrontendController::class, 'loadMoreProducts'])->name('loadMoreProducts');
 Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
 Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
 Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndConditions'])->name('terms');
 Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy');
 Route::get('/blog-posts', [\App\Http\Controllers\frontendController::class, 'blogs'])->name('blogs');
 Route::get('/blog-post/{slug}', [\App\Http\Controllers\frontendController::class, 'blogDetail'])->name('blog.detail');

// Sitemap Route
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Meta (Facebook) Product Feed Route
Route::get('/product-feed.xml', [SitemapController::class, 'metaProductFeed'])->name('meta.product.feed');

// Cart Routes (no auth required for add to cart)
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/preview', [CartController::class, 'getCartPreview'])->name('cart.preview');
Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/{id}/remove', [CartController::class, 'destroy'])->name('cart.remove');

// Wishlist Routes (no auth required)
Route::post('/wishlist/add', [\App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::get('/wishlist/check/{productId}', [\App\Http\Controllers\WishlistController::class, 'check'])->name('wishlist.check');
Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
Route::delete('/wishlist/product/{productId}', [\App\Http\Controllers\WishlistController::class, 'removeByProduct'])->name('wishlist.removeByProduct');

 Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
 Route::post('/checkout/apply-coupon', [FrontendController::class, 'applyCoupon'])->name('checkout.applyCoupon');
 Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
 Route::get('/thankyou', [FrontendController::class, 'thankyou'])->name('thankyou');

 // Review Routes
 Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

 // Notification Routes (FCM)
 Route::post('/notifications/token', [\App\Http\Controllers\NotificationController::class, 'storeToken'])->name('notifications.storeToken');
 Route::delete('/notifications/token', [\App\Http\Controllers\NotificationController::class, 'removeToken'])->name('notifications.removeToken');




/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/dashboard', [backendController::class, 'index'])->name('admin.dashboard');

    // Category Routes
    Route::resource('admin/categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Slider Routes
    Route::resource('admin/sliders', SliderController::class)->names([
        'index' => 'admin.sliders.index',
        'create' => 'admin.sliders.create',
        'store' => 'admin.sliders.store',
        'show' => 'admin.sliders.show',
        'edit' => 'admin.sliders.edit',
        'update' => 'admin.sliders.update',
        'destroy' => 'admin.sliders.destroy',
    ]);

    // Ready To Wear Routes
    Route::resource('admin/ready-to-wears', ReadyToWearController::class)->names([
        'index' => 'admin.ready-to-wears.index',
        'create' => 'admin.ready-to-wears.create',
        'store' => 'admin.ready-to-wears.store',
        'show' => 'admin.ready-to-wears.show',
        'edit' => 'admin.ready-to-wears.edit',
        'update' => 'admin.ready-to-wears.update',
        'destroy' => 'admin.ready-to-wears.destroy',
    ]);

    // Best Seller Video Routes
    Route::resource('admin/best-seller-videos', BestSellerVideoController::class)->names([
        'index' => 'admin.best-seller-videos.index',
        'create' => 'admin.best-seller-videos.create',
        'store' => 'admin.best-seller-videos.store',
        'show' => 'admin.best-seller-videos.show',
        'edit' => 'admin.best-seller-videos.edit',
        'update' => 'admin.best-seller-videos.update',
        'destroy' => 'admin.best-seller-videos.destroy',
    ]);

    // Testimonial Routes
    Route::resource('admin/testimonials', TestimonialController::class)->names([
        'index' => 'admin.testimonials.index',
        'create' => 'admin.testimonials.create',
        'store' => 'admin.testimonials.store',
        'show' => 'admin.testimonials.show',
        'edit' => 'admin.testimonials.edit',
        'update' => 'admin.testimonials.update',
        'destroy' => 'admin.testimonials.destroy',
    ]);

    // Blog Routes
    Route::resource('admin/blogs', BackendBlogController::class)->names([
        'index' => 'admin.blogs.index',
        'create' => 'admin.blogs.create',
        'store' => 'admin.blogs.store',
        'show' => 'admin.blogs.show',
        'edit' => 'admin.blogs.edit',
        'update' => 'admin.blogs.update',
        'destroy' => 'admin.blogs.destroy',
    ]);


    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);

    Route::delete('admin/products/images/{id}', [ProductController::class, 'deleteImage'])->name('admin.products.images.delete');

    // Order Routes
    Route::get('admin/orders', [BackendOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin/orders/{id}', [BackendOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('admin/orders/{id}/print', [BackendOrderController::class, 'print'])->name('admin.orders.print');
    Route::get('admin/orders/{id}/edit', [BackendOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('admin/orders/{id}', [BackendOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('admin/orders/{id}', [BackendOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Coupon Routes
    Route::get('admin/coupons', [BackendCouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('admin/coupons/create', [BackendCouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('admin/coupons', [BackendCouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('admin/coupons/{id}/edit', [BackendCouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('admin/coupons/{id}', [BackendCouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('admin/coupons/{id}', [BackendCouponController::class, 'destroy'])->name('admin.coupons.destroy');

    // Review Routes
    Route::get('admin/reviews', [BackendReviewController::class, 'index'])->name('admin.reviews.index');
    Route::post('admin/reviews/{id}/approve', [BackendReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('admin/reviews/{id}/reject', [BackendReviewController::class, 'reject'])->name('admin.reviews.reject');
    Route::delete('admin/reviews/{id}', [BackendReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Contact Routes
    Route::get('admin/contacts', [BackendContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('admin/contacts/{id}', [BackendContactController::class, 'show'])->name('admin.contacts.show');
    Route::put('admin/contacts/{id}/status', [BackendContactController::class, 'updateStatus'])->name('admin.contacts.updateStatus');
    Route::delete('admin/contacts/{id}', [BackendContactController::class, 'destroy'])->name('admin.contacts.destroy');

    // Customer Routes
    Route::get('admin/customers', [BackendCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('admin/customers/{id}', [BackendCustomerController::class, 'show'])->name('admin.customers.show');

    // Payment Routes
    Route::get('admin/payments', [BackendPaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('admin/payments/{id}', [BackendPaymentController::class, 'show'])->name('admin.payments.show');
});


Route::fallback(function () {
    return redirect('/');
});

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrapFive();

        // Share cart count, wishlist count, and category IDs with all views
        View::composer('*', function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;

            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            } else {
                $sessionId = Session::getId();
                $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');
                $wishlistCount = Wishlist::where('session_id', $sessionId)->count();
            }

            // Cache category IDs for mobile navigation for 1 hour
            $categoryIds = Cache::remember('category.ids.mobile_nav', 3600, function () {
                $eidCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%eid%')->orWhere('slug', 'LIKE', '%eid%');
                })->active()->first();

                $bagsCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%bags%')->orWhere('slug', 'LIKE', '%bags%');
                })->active()->first();

                $casualCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%casual%')->orWhere('slug', 'LIKE', '%casual%');
                })->active()->first();

                $formalCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%formal%')->orWhere('slug', 'LIKE', '%formal%');
                })->active()->first();

                return [
                    'eidCategoryId' => $eidCategory?->id ?? null,
                    'bagsCategoryId' => $bagsCategory?->id ?? null,
                    'casualCategoryId' => $casualCategory?->id ?? null,
                    'formalCategoryId' => $formalCategory?->id ?? null,
                ];
            });

            $view->with('cartCount', $cartCount);
            $view->with('wishlistCount', $wishlistCount);
            $view->with('eidCategoryId', $categoryIds['eidCategoryId']);
            $view->with('bagsCategoryId', $categoryIds['bagsCategoryId']);
            $view->with('casualCategoryId', $categoryIds['casualCategoryId']);
            $view->with('formalCategoryId', $categoryIds['formalCategoryId']);
        });
    }
}


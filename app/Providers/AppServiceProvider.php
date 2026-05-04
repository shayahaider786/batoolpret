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

            // Cache category IDs for navigation for 1 hour
            $categoryIds = Cache::remember('category.ids.navigation', 3600, function () {
                // EID Collection category
                $eidCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%eid%')
                        ->orWhere('slug', 'eid-collection')
                        ->orWhere('slug', 'LIKE', '%eid%');
                })->active()->first();

                // SUMMER Collection category
                $summerCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%summer%')
                        ->orWhere('slug', 'LIKE', '%summer%')
                        ->orWhere('name', 'LIKE', '%seasonal%');
                })->active()->first();

                // Bags category
                $bagsCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%bags%')->orWhere('slug', 'LIKE', '%bags%');
                })->active()->first();

                // Casual category
                $casualCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%casual%')->orWhere('slug', 'LIKE', '%casual%');
                })->active()->first();

                // Formal category
                $formalCategory = Category::where(function ($q) {
                    $q->where('name', 'LIKE', '%formal%')->orWhere('slug', 'LIKE', '%formal%');
                })->active()->first();

                return [
                    'eidCategoryId' => $eidCategory?->id ?? null,
                    'summerCategoryId' => $summerCategory?->id ?? null,
                    'bagsCategoryId' => $bagsCategory?->id ?? null,
                    'casualCategoryId' => $casualCategory?->id ?? null,
                    'formalCategoryId' => $formalCategory?->id ?? null,
                ];
            });

            $view->with('cartCount', $cartCount);
            $view->with('wishlistCount', $wishlistCount);
            $view->with('eidCategoryId', $categoryIds['eidCategoryId']);
            $view->with('summerCategoryId', $categoryIds['summerCategoryId']);
            $view->with('bagsCategoryId', $categoryIds['bagsCategoryId']);
            $view->with('casualCategoryId', $categoryIds['casualCategoryId']);
            $view->with('formalCategoryId', $categoryIds['formalCategoryId']);
        });
    }
}

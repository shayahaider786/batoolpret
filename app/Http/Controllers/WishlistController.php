<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    /**
     * Add a product to the wishlist.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active
        if ($product->status !== 'active') {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is not available.'
                ], 400);
            }
            return redirect()->back()->with('error', 'This product is not available.');
        }

        // Check if user is authenticated or use session
        if (Auth::check()) {
            // Check if product already in wishlist
            $existingWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingWishlist) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product is already in your wishlist.'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Product is already in your wishlist.');
            }

            // Create new wishlist item
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ]);
        } else {
            // Guest user - use session
            $sessionId = Session::getId();
            
            // Check if product already in wishlist
            $existingWishlist = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingWishlist) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product is already in your wishlist.'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Product is already in your wishlist.');
            }

            // Create new wishlist item
            Wishlist::create([
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
            ]);
        }

        // Return JSON for AJAX requests, otherwise redirect
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully.',
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist successfully.');
    }

    /**
     * Remove a product from the wishlist.
     */
    public function remove(Request $request, $id)
    {
        if (Auth::check()) {
            $wishlistItem = Wishlist::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } else {
            $sessionId = Session::getId();
            $wishlistItem = Wishlist::where('id', $id)
                ->where('session_id', $sessionId)
                ->firstOrFail();
        }

        $wishlistItem->delete();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully.',
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }

        return redirect()->route('wishlist')
            ->with('success', 'Product removed from wishlist.');
    }

    /**
     * Remove product from wishlist by product ID.
     */
    public function removeByProduct(Request $request, $productId)
    {
        if (Auth::check()) {
            $wishlistItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
        } else {
            $sessionId = Session::getId();
            $wishlistItem = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();
        }

        if ($wishlistItem) {
            $wishlistItem->delete();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist successfully.',
                    'wishlist_count' => $this->getWishlistCount()
                ]);
            }

            return redirect()->back()->with('success', 'Product removed from wishlist.');
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist.'
            ], 404);
        }

        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }

    /**
     * Get wishlist items for the user (authenticated or guest).
     */
    public function index()
    {
        if (Auth::check()) {
            $wishlistItems = Wishlist::with('product.category', 'product.images')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $sessionId = Session::getId();
            $wishlistItems = Wishlist::with('product.category', 'product.images')
                ->where('session_id', $sessionId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    /**
     * Get wishlist count for the user (authenticated or guest).
     */
    public function getWishlistCount()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        } else {
            $sessionId = Session::getId();
            return Wishlist::where('session_id', $sessionId)->count();
        }
    }

    /**
     * Check if product is in wishlist.
     */
    public function check(Request $request, $productId)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } else {
            $sessionId = Session::getId();
            $exists = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->exists();
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $exists
        ]);
    }
}

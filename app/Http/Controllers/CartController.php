<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:50',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active and in stock
        if ($product->status !== 'active') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is not available.'
                ], 400);
            }
            return redirect()->back()->with('error', 'This product is not available.');
        }

        if ($product->stock < $request->quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->stock . ' items available.'
                ], 400);
            }
            return redirect()->back()->with('error', 'Insufficient stock. Only ' . $product->stock . ' items available.');
        }

        // Get the price (use discount price if available, otherwise regular price)
        $price = $product->discount_price ?? $product->price;

        // Get selected size (default to first available size if not provided)
        $selectedSize = $request->input('size');
        if (!$selectedSize && $product->size && is_array($product->size) && count($product->size) > 0) {
            $selectedSize = $product->size[0];
        }

        // Check if user is authenticated or use session
        if (Auth::check()) {
            // Authenticated user - use database
            // Check for existing cart item with same product AND size
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->where('size', $selectedSize)
                ->first();

            if ($cartItem) {
                // Update quantity if item already exists
                $newQuantity = $cartItem->quantity + $request->quantity;
                
                // Check stock again
                if ($product->stock < $newQuantity) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Insufficient stock. You already have ' . $cartItem->quantity . ' in your cart. Only ' . $product->stock . ' items available.'
                        ], 400);
                    }
                    return redirect()->back()->with('error', 'Insufficient stock. You already have ' . $cartItem->quantity . ' in your cart. Only ' . $product->stock . ' items available.');
                }

                $cartItem->quantity = $newQuantity;
                $cartItem->price = $price; // Update price in case it changed
                $cartItem->save();
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'size' => $selectedSize,
                    'price' => $price,
                ]);
            }
        } else {
            // Guest user - use session
            $sessionId = Session::getId();
            // Check for existing cart item with same product AND size
            $cartItem = Cart::where('session_id', $sessionId)
                ->where('product_id', $request->product_id)
                ->where('size', $selectedSize)
                ->first();

            if ($cartItem) {
                // Update quantity if item already exists
                $newQuantity = $cartItem->quantity + $request->quantity;
                
                // Check stock again
                if ($product->stock < $newQuantity) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Insufficient stock. You already have ' . $cartItem->quantity . ' in your cart. Only ' . $product->stock . ' items available.'
                        ], 400);
                    }
                    return redirect()->back()->with('error', 'Insufficient stock. You already have ' . $cartItem->quantity . ' in your cart. Only ' . $product->stock . ' items available.');
                }

                $cartItem->quantity = $newQuantity;
                $cartItem->price = $price; // Update price in case it changed
                $cartItem->save();
            } else {
                // Create new cart item
                Cart::create([
                    'session_id' => $sessionId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'size' => $selectedSize,
                    'price' => $price,
                ]);
            }
        }

        // Remove from wishlist if requested (when adding from wishlist page)
        if ($request->has('remove_from_wishlist') && $request->remove_from_wishlist == '1') {
            if ($request->has('wishlist_item_id')) {
                // Remove by wishlist item ID
                $wishlistItem = Wishlist::find($request->wishlist_item_id);
                if ($wishlistItem) {
                    // Verify ownership
                    if (Auth::check()) {
                        if ($wishlistItem->user_id == Auth::id()) {
                            $wishlistItem->delete();
                        }
                    } else {
                        $sessionId = Session::getId();
                        if ($wishlistItem->session_id == $sessionId) {
                            $wishlistItem->delete();
                        }
                    }
                }
            } else {
                // Remove by product ID (fallback)
                if (Auth::check()) {
                    Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->delete();
                } else {
                    $sessionId = Session::getId();
                    Wishlist::where('session_id', $sessionId)
                        ->where('product_id', $request->product_id)
                        ->delete();
                }
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart_count' => $this->getCartCount()
            ]);
        }

        // Determine redirect and message
        if ($request->has('remove_from_wishlist') && $request->remove_from_wishlist == '1') {
            // If adding from wishlist, redirect back to wishlist page
            return redirect()->route('wishlist')->with('success', 'Product added to cart and removed from wishlist successfully.');
        }

        return redirect()->route('cart')->with('success', 'Product added to cart successfully.');
    }

    /**
     * Get cart items for the user (authenticated or guest).
     */
    public function index()
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

        return view('frontend.cart', compact('cartItems'));
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            $cartItem = Cart::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } else {
            $sessionId = Session::getId();
            $cartItem = Cart::where('id', $id)
                ->where('session_id', $sessionId)
                ->firstOrFail();
        }

        $product = $cartItem->product;

        // Check stock
        if ($product->stock < $request->quantity) {
            return redirect()->route('cart')
                ->with('error', 'Insufficient stock. Only ' . $product->stock . ' items available.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart')
            ->with('success', 'Cart updated successfully.');
    }

    /**
     * Update all cart items quantities.
     */
    public function updateAll(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)->get();
        }

        foreach ($request->quantities as $cartId => $quantity) {
            $cartItem = $cartItems->find($cartId);
            if ($cartItem) {
                $product = $cartItem->product;
                
                // Check stock
                if ($product && $product->stock < $quantity) {
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Insufficient stock for ' . $product->name . '. Only ' . $product->stock . ' items available.'
                        ], 400);
                    }
                    return redirect()->route('cart')
                        ->with('error', 'Insufficient stock for ' . $product->name . '. Only ' . $product->stock . ' items available.');
                }

                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.'
            ]);
        }

        return redirect()->route('cart')
            ->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $cartItem = Cart::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } else {
            $sessionId = Session::getId();
            $cartItem = Cart::where('id', $id)
                ->where('session_id', $sessionId)
                ->firstOrFail();
        }

        $cartItem->delete();

        return redirect()->route('cart')
            ->with('success', 'Item removed from cart.');
    }

    /**
     * Get cart count for the user (authenticated or guest).
     */
    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $sessionId = Session::getId();
            return Cart::where('session_id', $sessionId)->sum('quantity');
        }
    }

    /**
     * Get cart total for the user (authenticated or guest).
     */
    private function getCartTotal()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)->get();
        }
        
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get cart items for preview (AJAX).
     */
    public function getCartPreview(Request $request)
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::with('product.images')
                ->where('session_id', $sessionId)
                ->get();
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product ? $item->product->name : 'Product Not Available',
                    'product_image' => $item->product && $item->product->image 
                        ? asset($item->product->image) 
                        : asset('frontend/images/item-cart-04.jpg'),
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'size' => $item->size,
                    'total' => $item->price * $item->quantity,
                    'product_slug' => $item->product ? $item->product->slug : '#'
                ];
            }),
            'total' => $total,
            'count' => $cartCount
        ]);
    }
}

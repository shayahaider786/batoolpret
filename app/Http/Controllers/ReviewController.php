<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'nullable|email|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if product is active
        if ($product->status !== 'active') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cannot review this product.');
        }

        // If user is logged in, use their info
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
            $validated['name'] = Auth::user()->name;
            $validated['email'] = Auth::user()->email;
        }

        $validated['status'] = 'pending'; // All reviews start as pending

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = uniqid('review_') . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('review'), $filename);
                $imagePaths[] = 'review/' . $filename;
            }
        }
        $validated['images'] = $imagePaths;

        Review::create($validated);

        return redirect()->back()
            ->with('success', 'Thank you for your review! It will be published after admin approval.');
    }
}

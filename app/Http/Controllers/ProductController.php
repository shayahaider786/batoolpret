<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Generate a unique SKU for the product.
     */
    private function generateSKU($name = null)
    {
        $prefix = 'FURN';
        $counter = 1;

        // Try to create SKU from product name if provided
        if ($name) {
            $namePart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3));
            if (strlen($namePart) >= 2) {
                $prefix = $namePart;
            }
        }

        // Generate SKU with format: PREFIX-XXXX
        do {
            $sku = $prefix . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);
            $exists = Product::where('sku', $sku)->exists();
            $counter++;
        } while ($exists && $counter < 9999);

        return $sku;
    }

    /**
     * Convert image to WebP format using GD library.
     */
    private function convertToWebP($imageFile, $destinationPath, $fileName)
    {
        try {
            // Check if GD extension is available and supports WebP
            if (!extension_loaded('gd') || !function_exists('imagewebp')) {
                throw new \Exception('GD extension with WebP support is not available');
            }

            $sourcePath = $imageFile->getRealPath();
            $mimeType = $imageFile->getMimeType();
            $webpPath = $destinationPath . '/' . $fileName;

            // Create image resource based on MIME type
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($sourcePath);
                    // Preserve transparency for PNG
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($sourcePath);
                    break;
                case 'image/webp':
                    // Already WebP, just copy it
                    copy($sourcePath, $webpPath);
                    return $fileName;
                default:
                    throw new \Exception('Unsupported image format: ' . $mimeType);
            }

            if (!$image) {
                throw new \Exception('Failed to create image resource');
            }

            // Convert and save as WebP with quality 90
            $success = imagewebp($image, $webpPath, 90);
            imagedestroy($image);

            if (!$success) {
                throw new \Exception('Failed to save WebP image');
            }

            return $fileName;
        } catch (\Exception $e) {
            // Fallback: if WebP conversion fails, use original extension
            \Log::warning('WebP conversion failed: ' . $e->getMessage());
            $extension = $imageFile->guessExtension() ?: $imageFile->getClientOriginalExtension();
            $fallbackName = str_replace('.webp', '.' . $extension, $fileName);
            $imageFile->move($destinationPath, $fallbackName);
            return $fallbackName;
        }
    }

    /**
     * Generate a unique slug for the product.
     */
    private function generateSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Ensure slug is unique
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'images');

        // Search by product name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('backend.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'tag' => 'nullable|in:new_arrival,best_selling,trending',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'size_guide_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'size' => 'nullable|array',
            'size.*' => 'nullable|in:xs,S,M,L,XL,XXL',
            'outfit_type' => 'nullable|string|max:255',
            'fabric' => 'nullable|string',
            'includes' => 'nullable|string',
            'design_details' => 'nullable|string',
            'color' => 'nullable|string|max:255',
            'disclaimer' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_tags' => 'nullable|string|max:500',
        ]);

        // Calculate discount percent
        if ($validated['discount_price'] && $validated['price'] > 0) {
            $validated['discount_percent'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100, 2);
        }

        // Auto-generate SKU if not provided
        if (empty($validated['sku'])) {
            $validated['sku'] = $this->generateSKU($validated['name']);
        }

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateSlug($validated['name']);
        }

        // Handle size array - convert empty array to null
        if (isset($validated['size']) && is_array($validated['size'])) {
            $validated['size'] = array_filter($validated['size']); // Remove empty values
            if (empty($validated['size'])) {
                $validated['size'] = null;
            }
        }

        // Handle main image upload - convert to WebP and store in public/products folder
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.webp';

            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $savedFileName = $this->convertToWebP($image, $destinationPath, $imageName);
            $validated['image'] = 'products/' . $savedFileName;
        }

        // Handle size guide image upload - convert to WebP and store in public/products folder
        if ($request->hasFile('size_guide_image')) {
            $sizeGuideImage = $request->file('size_guide_image');
            $imageName = time() . '_sizeguide_' . Str::random(10) . '.webp';

            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $savedFileName = $this->convertToWebP($sizeGuideImage, $destinationPath, $imageName);
            $validated['size_guide_image'] = 'products/' . $savedFileName;
        }

        $product = Product::create($validated);

        // Clear cache for homepage products
        Cache::forget('products.new_arrival');
        Cache::forget('products.trending');
        Cache::forget('products.latest');

        // Handle multiple images upload - convert to WebP
        if ($request->hasFile('images')) {
            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $index => $file) {
                $imageName = time() . '_' . Str::random(10) . '_' . $index . '.webp';
                $savedFileName = $this->convertToWebP($file, $destinationPath, $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $savedFileName,
                    'sort_order' => $index,
                ]);
            }
        }

        // Send push notification to all users when new product is added
        try {
            $notificationService = new FirebaseNotificationService();
            $productUrl = route('productDetail', $product->slug);

            Log::info('Attempting to send push notification for new product', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_url' => $productUrl,
            ]);

            $result = $notificationService->sendToAll(
                'Zaylish has new product added',
                'Go and check the product',
                [
                    'url' => $productUrl,
                    'product_id' => $product->id,
                    'product_slug' => $product->slug,
                    'product_name' => $product->name,
                    'type' => 'new_product',
                ]
            );

            Log::info('Push notification send result', [
                'product_id' => $product->id,
                'success' => $result['success'] ?? 0,
                'failure' => $result['failure'] ?? 0,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send push notification for new product', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::with('category', 'images')->findOrFail($id);
        $categories = Category::active()->orderBy('name')->get();

        return view('backend.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'tag' => 'nullable|in:new_arrival,best_selling,trending',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'size_guide_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $id,
            'size' => 'nullable|array',
            'size.*' => 'nullable|in:xs,S,M,L,XL,XXL',
            'outfit_type' => 'nullable|string|max:255',
            'fabric' => 'nullable|string',
            'includes' => 'nullable|string',
            'design_details' => 'nullable|string',
            'color' => 'nullable|string|max:255',
            'disclaimer' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_tags' => 'nullable|string|max:500',
        ]);

        // Calculate discount percent
        if ($validated['discount_price'] && $validated['price'] > 0) {
            $validated['discount_percent'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100, 2);
        } else {
            $validated['discount_percent'] = null;
        }

        // Auto-generate SKU if not provided and product doesn't have one
        if (empty($validated['sku'])) {
            if (empty($product->sku)) {
                $validated['sku'] = $this->generateSKU($validated['name']);
            } else {
                // Keep existing SKU if not provided in update
                unset($validated['sku']);
            }
        }

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            // Generate slug from name if name changed, otherwise keep existing
            if ($validated['name'] !== $product->name) {
                $validated['slug'] = $this->generateSlug($validated['name']);
            } else {
                // Keep existing slug if name hasn't changed
                unset($validated['slug']);
            }
        }

        // Handle size array - convert empty array to null
        if (isset($validated['size']) && is_array($validated['size'])) {
            $validated['size'] = array_filter($validated['size']); // Remove empty values
            if (empty($validated['size'])) {
                $validated['size'] = null;
            }
        }

        // Handle main image upload - convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = public_path($product->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.webp';

            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $savedFileName = $this->convertToWebP($image, $destinationPath, $imageName);
            $validated['image'] = 'products/' . $savedFileName;
        }

        // Handle size guide image upload - convert to WebP
        if ($request->hasFile('size_guide_image')) {
            // Delete old size guide image if exists
            if ($product->size_guide_image) {
                $oldSizeGuideImagePath = public_path($product->size_guide_image);
                if (File::exists($oldSizeGuideImagePath)) {
                    File::delete($oldSizeGuideImagePath);
                }
            }

            $sizeGuideImage = $request->file('size_guide_image');
            $imageName = time() . '_sizeguide_' . Str::random(10) . '.webp';

            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $savedFileName = $this->convertToWebP($sizeGuideImage, $destinationPath, $imageName);
            $validated['size_guide_image'] = 'products/' . $savedFileName;
        }

        $product->update($validated);

        // Clear cache for homepage products
        Cache::forget('products.new_arrival');
        Cache::forget('products.trending');
        Cache::forget('products.latest');

        // Handle multiple images upload - convert to WebP
        if ($request->hasFile('images')) {
            $destinationPath = public_path('products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $maxSortOrder = $product->images()->max('sort_order') ?? -1;

            foreach ($request->file('images') as $index => $file) {
                $imageName = time() . '_' . Str::random(10) . '_' . $index . '.webp';
                $savedFileName = $this->convertToWebP($file, $destinationPath, $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $savedFileName,
                    'sort_order' => $maxSortOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete main image if exists
        if ($product->image) {
            $imagePath = public_path($product->image);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete product main image: ' . $imagePath . ' - ' . $e->getMessage());
                }
            }
        }

        // Delete all product images from database and filesystem
        foreach ($product->images as $productImage) {
            // Delete image file from public folder
            if ($productImage->image) {
                $imagePath = public_path($productImage->image);
                if (File::exists($imagePath)) {
                    try {
                        File::delete($imagePath);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete product image: ' . $imagePath . ' - ' . $e->getMessage());
                    }
                }
            }
            // Delete the ProductImage record from database
            $productImage->delete();
        }

        // Delete the product record (this will cascade delete related records if configured)
        $product->delete();

        // Clear cache for homepage products
        Cache::forget('products.new_arrival');
        Cache::forget('products.trending');
        Cache::forget('products.latest');

        return redirect()->route('admin.products.index')
            ->with('success', 'Product and all associated images deleted successfully.');
    }

    /**
     * Delete a product image.
     */
    public function deleteImage($id)
    {
        // Ensure user is authenticated and is admin (additional check beyond middleware)
        if (!auth()->check() || auth()->user()->type !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $productImage = ProductImage::findOrFail($id);

        // Security: Validate that the image path is within allowed directory
        $imagePath = public_path($productImage->image);
        $realPath = realpath($imagePath);
        $publicPath = realpath(public_path());

        // Prevent path traversal attacks
        if (!$realPath || strpos($realPath, $publicPath) !== 0) {
            \Log::warning('Potential path traversal attempt in deleteImage: ' . $productImage->image);
            return response()->json(['success' => false, 'message' => 'Invalid image path.'], 400);
        }

        // Delete image file
        if (File::exists($imagePath)) {
            try {
                File::delete($imagePath);
            } catch (\Exception $e) {
                \Log::error('Failed to delete product image: ' . $imagePath . ' - ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to delete image file.'], 500);
            }
        }

        $productImage->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }
}

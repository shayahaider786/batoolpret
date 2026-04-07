<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent', 'children')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(15);
        
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::parents()->active()->orderBy('name')->get();
        return view('backend.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload - convert to WebP and store in public/categories folder
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.webp';
            
            // Create categories directory if it doesn't exist
            $destinationPath = public_path('categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $savedFileName = $this->convertToWebP($image, $destinationPath, $imageName);
            $validated['image'] = 'categories/' . $savedFileName;
        }

        // Handle banner image upload - convert to WebP and store in public/categories folder
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . '_' . Str::random(10) . '_banner.webp';
            
            // Create categories directory if it doesn't exist
            $destinationPath = public_path('categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $savedFileName = $this->convertToWebP($bannerImage, $destinationPath, $bannerImageName);
            $validated['banner_image'] = 'categories/' . $savedFileName;
        }

        Category::create($validated);

        // Clear cache for categories
        Cache::forget('categories.active.with_images');
        Cache::forget('categories.active.all');
        Cache::forget('categories.parents.active');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('parent', 'children')->findOrFail($id);
        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::with('parent')->findOrFail($id);
        $parentCategories = Category::parents()
            ->where('id', '!=', $id)
            ->active()
            ->orderBy('name')
            ->get();
        
        return view('backend.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Prevent category from being its own parent
        if ($validated['parent_id'] == $id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'A category cannot be its own parent.'])
                ->withInput();
        }

        // Prevent circular references (category cannot be parent of its own parent)
        if ($validated['parent_id']) {
            $parent = Category::find($validated['parent_id']);
            if ($parent && $parent->parent_id == $id) {
                return redirect()->back()
                    ->withErrors(['parent_id' => 'Cannot set parent: this would create a circular reference.'])
                    ->withInput();
            }
        }

        // Generate slug from name if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload - convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $oldImagePath = public_path($category->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.webp';
            
            // Create categories directory if it doesn't exist
            $destinationPath = public_path('categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $savedFileName = $this->convertToWebP($image, $destinationPath, $imageName);
            $validated['image'] = 'categories/' . $savedFileName;
        }

        // Handle banner image upload - convert to WebP
        if ($request->hasFile('banner_image')) {
            // Delete old banner image if exists
            if ($category->banner_image) {
                $oldBannerImagePath = public_path($category->banner_image);
                if (File::exists($oldBannerImagePath)) {
                    File::delete($oldBannerImagePath);
                }
            }
            
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . '_' . Str::random(10) . '_banner.webp';
            
            // Create categories directory if it doesn't exist
            $destinationPath = public_path('categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $savedFileName = $this->convertToWebP($bannerImage, $destinationPath, $bannerImageName);
            $validated['banner_image'] = 'categories/' . $savedFileName;
        }

        $category->update($validated);

        // Clear cache for categories
        Cache::forget('categories.active.with_images');
        Cache::forget('categories.active.all');
        Cache::forget('categories.parents.active');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category. It has subcategories. Please delete or reassign subcategories first.');
        }

        // Delete image from public folder if exists
        if ($category->image) {
            $imagePath = public_path($category->image);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete category image: ' . $imagePath . ' - ' . $e->getMessage());
                }
            }
        }

        // Delete banner image from public folder if exists
        if ($category->banner_image) {
            $bannerImagePath = public_path($category->banner_image);
            if (File::exists($bannerImagePath)) {
                try {
                    File::delete($bannerImagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete category banner image: ' . $bannerImagePath . ' - ' . $e->getMessage());
                }
            }
        }

        $category->delete();

        // Clear cache for categories
        Cache::forget('categories.active.with_images');
        Cache::forget('categories.active.all');
        Cache::forget('categories.parents.active');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category and associated image deleted successfully.');
    }
}

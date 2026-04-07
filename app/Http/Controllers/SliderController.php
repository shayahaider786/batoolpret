<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(15);
        return view('backend.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_slider_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'mobile_slider_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
        ]);

        // Handle website slider image upload
        if ($request->hasFile('website_slider_image')) {
            $image = $request->file('website_slider_image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '_web.' . $extension;
            
            $destinationPath = public_path('sliders');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['website_slider_image'] = 'sliders/' . $imageName;
        }

        // Handle mobile slider image upload
        if ($request->hasFile('mobile_slider_image')) {
            $image = $request->file('mobile_slider_image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '_mobile.' . $extension;
            
            $destinationPath = public_path('sliders');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['mobile_slider_image'] = 'sliders/' . $imageName;
        }

        Slider::create($validated);

        // Clear cache so new slider appears immediately
        \Illuminate\Support\Facades\Cache::forget('sliders.latest');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $validated = $request->validate([
            'website_slider_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'mobile_slider_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
        ]);

        // Handle website slider image upload
        if ($request->hasFile('website_slider_image')) {
            // Delete old image if exists
            if ($slider->website_slider_image) {
                $oldImagePath = public_path($slider->website_slider_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $image = $request->file('website_slider_image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '_web.' . $extension;
            
            $destinationPath = public_path('sliders');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['website_slider_image'] = 'sliders/' . $imageName;
        }

        // Handle mobile slider image upload
        if ($request->hasFile('mobile_slider_image')) {
            // Delete old image if exists
            if ($slider->mobile_slider_image) {
                $oldImagePath = public_path($slider->mobile_slider_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $image = $request->file('mobile_slider_image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '_mobile.' . $extension;
            
            $destinationPath = public_path('sliders');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['mobile_slider_image'] = 'sliders/' . $imageName;
        }

        $slider->update($validated);

        // Clear cache so updated slider appears immediately
        \Illuminate\Support\Facades\Cache::forget('sliders.latest');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        // Delete website slider image if exists
        if ($slider->website_slider_image) {
            $imagePath = public_path($slider->website_slider_image);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete website slider image: ' . $imagePath . ' - ' . $e->getMessage());
                }
            }
        }

        // Delete mobile slider image if exists
        if ($slider->mobile_slider_image) {
            $imagePath = public_path($slider->mobile_slider_image);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete mobile slider image: ' . $imagePath . ' - ' . $e->getMessage());
                }
            }
        }

        $slider->delete();

        // Clear cache so deleted slider is removed immediately
        \Illuminate\Support\Facades\Cache::forget('sliders.latest');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully.');
    }
}

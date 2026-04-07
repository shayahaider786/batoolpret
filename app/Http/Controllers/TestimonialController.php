<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::ordered()->paginate(15);
        return view('backend.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:51200', // Max 50MB
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'order' => $validated['order'] ?? 0,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/testimonials'), $imageName);
            $data['image'] = 'frontend/images/testimonials/' . $imageName;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('frontend/videos/testimonials'), $videoName);
            $data['video'] = 'frontend/videos/testimonials/' . $videoName;
        }

        Testimonial::create($data);

        // Clear cache for testimonials
        Cache::forget('testimonials.active');

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:51200', // Max 50MB
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'order' => $validated['order'] ?? $testimonial->order,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/testimonials'), $imageName);
            $data['image'] = 'frontend/images/testimonials/' . $imageName;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($testimonial->video && file_exists(public_path($testimonial->video))) {
                unlink(public_path($testimonial->video));
            }

            $video = $request->file('video');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('frontend/videos/testimonials'), $videoName);
            $data['video'] = 'frontend/videos/testimonials/' . $videoName;
        }

        $testimonial->update($data);

        // Clear cache for testimonials
        Cache::forget('testimonials.active');

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete image if exists
        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }

        // Delete video if exists
        if ($testimonial->video && file_exists(public_path($testimonial->video))) {
            unlink(public_path($testimonial->video));
        }

        $testimonial->delete();

        // Clear cache for testimonials
        Cache::forget('testimonials.active');

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}

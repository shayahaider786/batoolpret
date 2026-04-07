<?php

namespace App\Http\Controllers;

use App\Models\BestSellerVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BestSellerVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bestSellerVideos = BestSellerVideo::latest()->paginate(15);
        return view('backend.best-seller-videos.index', compact('bestSellerVideos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.best-seller-videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'video' => 'required|mimes:mp4,avi,mov,wmv,flv,webm|max:51200', // Max 50MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
        ]);

        // Handle video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $extension = $video->getClientOriginalExtension();
            $videoName = time() . '_' . Str::random(10) . '.' . $extension;
            
            $destinationPath = public_path('best-seller-videos');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $video->move($destinationPath, $videoName);
            $validated['video'] = 'best-seller-videos/' . $videoName;
        }

        BestSellerVideo::create($validated);

        return redirect()->route('admin.best-seller-videos.index')
            ->with('success', 'Best Seller Video created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bestSellerVideo = BestSellerVideo::findOrFail($id);
        return view('backend.best-seller-videos.show', compact('bestSellerVideo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bestSellerVideo = BestSellerVideo::findOrFail($id);
        return view('backend.best-seller-videos.edit', compact('bestSellerVideo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bestSellerVideo = BestSellerVideo::findOrFail($id);

        $validated = $request->validate([
            'video' => 'nullable|mimes:mp4,avi,mov,wmv,flv,webm|max:51200', // Max 50MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
        ]);

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($bestSellerVideo->video) {
                $oldVideoPath = public_path($bestSellerVideo->video);
                if (File::exists($oldVideoPath)) {
                    File::delete($oldVideoPath);
                }
            }
            
            $video = $request->file('video');
            $extension = $video->getClientOriginalExtension();
            $videoName = time() . '_' . Str::random(10) . '.' . $extension;
            
            $destinationPath = public_path('best-seller-videos');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $video->move($destinationPath, $videoName);
            $validated['video'] = 'best-seller-videos/' . $videoName;
        } else {
            // Keep existing video if not uploading new one
            unset($validated['video']);
        }

        $bestSellerVideo->update($validated);

        return redirect()->route('admin.best-seller-videos.index')
            ->with('success', 'Best Seller Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bestSellerVideo = BestSellerVideo::findOrFail($id);

        // Delete video if exists
        if ($bestSellerVideo->video) {
            $videoPath = public_path($bestSellerVideo->video);
            if (File::exists($videoPath)) {
                try {
                    File::delete($videoPath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete best seller video: ' . $videoPath . ' - ' . $e->getMessage());
                }
            }
        }

        $bestSellerVideo->delete();

        return redirect()->route('admin.best-seller-videos.index')
            ->with('success', 'Best Seller Video deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ReadyToWear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ReadyToWearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readyToWears = ReadyToWear::latest()->paginate(15);
        return view('backend.ready-to-wears.index', compact('readyToWears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.ready-to-wears.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '.' . $extension;
            
            $destinationPath = public_path('ready-to-wears');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'ready-to-wears/' . $imageName;
        }

        ReadyToWear::create($validated);

        return redirect()->route('admin.ready-to-wears.index')
            ->with('success', 'Ready To Wear created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $readyToWear = ReadyToWear::findOrFail($id);
        return view('backend.ready-to-wears.show', compact('readyToWear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $readyToWear = ReadyToWear::findOrFail($id);
        return view('backend.ready-to-wears.edit', compact('readyToWear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $readyToWear = ReadyToWear::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($readyToWear->image) {
                $oldImagePath = public_path($readyToWear->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $extension = $image->guessExtension() ?: $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(10) . '.' . $extension;
            
            $destinationPath = public_path('ready-to-wears');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'ready-to-wears/' . $imageName;
        }

        $readyToWear->update($validated);

        return redirect()->route('admin.ready-to-wears.index')
            ->with('success', 'Ready To Wear updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $readyToWear = ReadyToWear::findOrFail($id);

        // Delete image if exists
        if ($readyToWear->image) {
            $imagePath = public_path($readyToWear->image);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete ready to wear image: ' . $imagePath . ' - ' . $e->getMessage());
                }
            }
        }

        $readyToWear->delete();

        return redirect()->route('admin.ready-to-wears.index')
            ->with('success', 'Ready To Wear deleted successfully.');
    }
}

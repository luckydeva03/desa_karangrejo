<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = \App\Models\Gallery::orderByDesc('created_at')->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:foto,video',
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'description' => 'nullable|string',
        ]);

        try {
            $gallery = new \App\Models\Gallery();
            $gallery->title = $request->title;
            $gallery->category = $request->category;
            $gallery->description = $request->description;
            
            // Set type based on category
            $gallery->type = $request->category === 'foto' ? 'photo' : 'video';
            
            // Set default status
            $gallery->status = 'active';

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.str_replace(' ', '_', $originalName).'.'.$extension;
                $path = $file->storeAs('galleries', $filename, 'public');
                $gallery->images = [$path]; // Let model cast handle the array conversion
            } else {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file' => 'File harus diupload.']);
            }

            $gallery->save();

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Galeri berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan galeri: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:foto,video',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $gallery->title = $request->title;
            $gallery->category = $request->category;
            $gallery->description = $request->description;
            $gallery->status = $request->status;
            
            // Set type based on category
            $gallery->type = $request->category === 'foto' ? 'photo' : 'video';

            // Handle file upload if new file is provided
            if ($request->hasFile('file')) {
                // Delete old files if they exist
                if (!empty($gallery->images) && is_array($gallery->images)) {
                    foreach ($gallery->images as $oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
                
                $file = $request->file('file');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.str_replace(' ', '_', $originalName).'.'.$extension;
                $path = $file->storeAs('galleries', $filename, 'public');
                $gallery->images = [$path];
            }

            $gallery->save();

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Galeri berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui galeri: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $gallery = \App\Models\Gallery::findOrFail($id);
            
            // Delete associated files
            if (!empty($gallery->images) && is_array($gallery->images)) {
                foreach ($gallery->images as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
            
            $gallery->delete();
            
            return redirect()->route('admin.galleries.index')
                ->with('success', 'Galeri berhasil dihapus.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.galleries.index')
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus galeri: ' . $e->getMessage()]);
        }
    }
}

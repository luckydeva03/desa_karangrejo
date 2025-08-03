<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::active();

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $galleries = $query->latest()->paginate(12);
        
        // Get available categories
        $categories = Gallery::active()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        // Get photo and video counts
        $photoCount = Gallery::active()->byType('photo')->count();
        $videoCount = Gallery::active()->byType('video')->count();

        return view('frontend.galleries.index', compact(
            'galleries', 
            'categories', 
            'photoCount', 
            'videoCount'
        ));
    }

    public function show(Gallery $gallery)
    {
        // Check if gallery is active
        if ($gallery->status !== 'active') {
            abort(404, 'Galeri tidak ditemukan atau tidak aktif.');
        }

        // Get related galleries from same category
        $relatedGalleries = Gallery::active()
            ->where('category', $gallery->category)
            ->where('id', '!=', $gallery->id)
            ->latest()
            ->limit(6)
            ->get();

        return view('frontend.galleries.show', compact('gallery', 'relatedGalleries'));
    }

    public function photos()
    {
        $galleries = Gallery::active()
            ->byType('photo')
            ->latest()
            ->paginate(12);

        $categories = Gallery::active()
            ->byType('photo')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        return view('frontend.galleries.photos', compact('galleries', 'categories'));
    }

    public function videos()
    {
        $galleries = Gallery::active()
            ->byType('video')
            ->latest()
            ->paginate(12);

        $categories = Gallery::active()
            ->byType('video')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        return view('frontend.galleries.videos', compact('galleries', 'categories'));
    }

    public function category($category)
    {
        $galleries = Gallery::active()
            ->where('category', $category)
            ->latest()
            ->paginate(12);

        $allCategories = Gallery::active()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        return view('frontend.galleries.category', compact('galleries', 'category', 'allCategories'));
    }
}
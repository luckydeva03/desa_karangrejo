<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()
            ->with(['category', 'user'])
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhere('excerpt', 'like', '%' . $searchTerm . '%');
            });
        }

        $posts = $query->paginate(12);
        $categories = Category::active()->withCount('posts')->get();

        // Popular posts for sidebar
        $popularPosts = Post::published()
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.posts.index', compact('posts', 'categories', 'popularPosts'));
    }

    public function show(Post $post)
    {
        // Check if post is published
        if ($post->status !== 'published') {
            abort(404, 'Post tidak ditemukan atau belum dipublikasi.');
        }

        // Load relationships
        $post->load(['category', 'user']);
        
        // Increment view count
        $post->incrementViews();

        // Get related posts from same category
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(4)
            ->get();

        // Get previous and next post
        $previousPost = Post::published()
            ->where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextPost = Post::published()
            ->where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('frontend.posts.show', compact('post', 'relatedPosts', 'previousPost', 'nextPost'));
    }

    public function category($slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();
        
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['category', 'user'])
            ->latest()
            ->paginate(12);

        $categories = Category::active()->withCount('posts')->get();

        return view('frontend.posts.category', compact('posts', 'category', 'categories'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        $searchTerm = $request->q;
        
        $posts = Post::published()
            ->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('content', 'like', '%' . $searchTerm . '%')
                      ->orWhere('excerpt', 'like', '%' . $searchTerm . '%');
            })
            ->with(['category', 'user'])
            ->latest()
            ->paginate(12);

        $categories = Category::active()->withCount('posts')->get();

        return view('frontend.posts.search', compact('posts', 'searchTerm', 'categories'));
    }
}
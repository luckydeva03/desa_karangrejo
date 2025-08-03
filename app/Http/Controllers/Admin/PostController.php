<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Handle image upload from TinyMCE editor.
     * Returns JSON: { location: "/storage/posts/filename.jpg" }
     */
    public function uploadImageForEditor(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('posts', $filename, 'public');
            $url = asset('storage/posts/' . $filename);
            return response()->json(['location' => $url]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengupload gambar: ' . $e->getMessage()
            ], 500);
        }
    }
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(15);
        $categories = Category::active()->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'required|in:draft,published',
            'excerpt' => 'nullable|string|max:300'
        ], [
            'title.required' => 'Judul post wajib diisi.',
            'content.required' => 'Isi post wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = $this->generateUniqueSlug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Auto set published_at if status is published
        if ($request->status === 'published' && !$request->filled('published_at')) {
            $data['published_at'] = now();
        }

        // Auto generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 160);
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dibuat.');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::active()->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'required|in:draft,published',
            'excerpt' => 'nullable|string|max:300'
        ]);

        $data = $request->all();

        // Update slug if title changed
        if ($post->title !== $request->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, $post->id);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Auto set published_at if status changes to published
        if ($request->status === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        // Auto generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 160);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        try {
            // Delete featured image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $post->delete();

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')
                ->with('error', 'Terjadi kesalahan saat menghapus post.');
        }
    }

    public function toggleStatus(Post $post)
    {
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        
        if ($newStatus === 'published' && !$post->published_at) {
            $post->update([
                'status' => $newStatus,
                'published_at' => now()
            ]);
        } else {
            $post->update(['status' => $newStatus]);
        }

        return response()->json([
            'success' => true,
            'message' => "Status post berhasil diubah menjadi {$newStatus}.",
            'status' => $newStatus
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:posts,id'
        ]);

        try {
            $posts = Post::whereIn('id', $request->ids);
            $count = $posts->count();

            switch ($request->action) {
                case 'delete':
                    // Delete images first
                    foreach ($posts->get() as $post) {
                        if ($post->featured_image) {
                            Storage::disk('public')->delete($post->featured_image);
                        }
                    }
                    $posts->delete();
                    $message = "{$count} post berhasil dihapus.";
                    break;
                case 'publish':
                    $posts->update([
                        'status' => 'published',
                        'published_at' => now()
                    ]);
                    $message = "{$count} post berhasil dipublikasikan.";
                    break;
                case 'draft':
                    $posts->update(['status' => 'draft']);
                    $message = "{$count} post berhasil dijadikan draft.";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan aksi bulk.'
            ], 500);
        }
    }

    private function uploadImage($file): string
    {
        try {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'posts/' . $filename;

            // Simple upload without intervention/image dependency
            $file->storeAs('posts', $filename, 'public');

            return 'posts/' . $filename;

        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }

    private function generateUniqueSlug($title, $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = Post::where('slug', $slug);
        
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Post::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }

    // Optional: Add image optimization with intervention/image if needed
    private function uploadImageWithOptimization($file): string
    {
        // Check if Intervention Image package is installed and available
        if (!class_exists('Intervention\Image\ImageManager')) {
            // Fallback to simple upload
            return $this->uploadImage($file);
        }

        try {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'posts/' . $filename;

            // Use Intervention Image v3 syntax (compatible with Laravel 10+)
            $manager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
            
            $image = $manager->read($file);
            
            // Resize if too large
            if ($image->width() > 1200) {
                $image->scaleDown(width: 1200);
            }

            // Encode with quality optimization
            $encoded = $image->toJpeg(85);
            
            Storage::disk('public')->put($path, $encoded);

            return $path;

        } catch (\Exception $e) {
            // Fallback to simple upload if intervention fails
            return $this->uploadImage($file);
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        $query = Category::withCount('posts');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->orderBy('name')->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus aktif atau tidak aktif.'
        ]);

        try {
            $data = $request->all();
            $data['slug'] = $this->generateUniqueSlug($request->name);

            Category::create($data);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil dibuat.',
                    'redirect' => route('admin.categories.index')
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dibuat.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat membuat kategori.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat kategori.');
        }
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $category->load(['posts' => function($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing or return JSON for AJAX
     */
    public function edit(Category $category)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'status' => $category->status,
                'posts_count' => $category->posts()->count()
            ]);
        }
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id)
            ],
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus aktif atau tidak aktif.'
        ]);

        try {
            $data = $request->all();
            
            // Update slug only if name changed
            if ($category->name !== $request->name) {
                $data['slug'] = $this->generateUniqueSlug($request->name, $category->id);
            }

            $category->update($data);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil diperbarui.',
                    'data' => $category->fresh()
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil diperbarui.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui kategori.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has posts
            $postsCount = $category->posts()->count();
            
            if ($postsCount > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Kategori tidak dapat dihapus karena masih memiliki {$postsCount} berita."
                    ], 422);
                }

                return redirect()->route('admin.categories.index')
                    ->with('error', "Kategori tidak dapat dihapus karena masih memiliki {$postsCount} berita.");
            }

            $categoryName = $category->name;
            $category->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Kategori '{$categoryName}' berhasil dihapus."
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', "Kategori '{$categoryName}' berhasil dihapus.");

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus kategori.'
                ], 500);
            }

            return redirect()->route('admin.categories.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category)
    {
        try {
            $newStatus = $category->status === 'active' ? 'inactive' : 'active';
            $category->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => "Status kategori berhasil diubah menjadi {$newStatus}.",
                'status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status.'
            ], 500);
        }
    }

    /**
     * Get categories for select options (API endpoint)
     */
    public function getForSelect(Request $request)
    {
        $query = Category::active();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('name')
            ->select('id', 'name', 'slug')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Bulk actions for categories
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            $categories = Category::whereIn('id', $request->ids);
            $count = $categories->count();

            switch ($request->action) {
                case 'delete':
                    // Check if any category has posts
                    $categoriesWithPosts = $categories->withCount('posts')
                        ->having('posts_count', '>', 0)
                        ->get();

                    if ($categoriesWithPosts->count() > 0) {
                        $names = $categoriesWithPosts->pluck('name')->join(', ');
                        return response()->json([
                            'success' => false,
                            'message' => "Kategori berikut tidak dapat dihapus karena masih memiliki berita: {$names}"
                        ], 422);
                    }

                    $categories->delete();
                    $message = "{$count} kategori berhasil dihapus.";
                    break;

                case 'activate':
                    $categories->update(['status' => 'active']);
                    $message = "{$count} kategori berhasil diaktifkan.";
                    break;

                case 'deactivate':
                    $categories->update(['status' => 'inactive']);
                    $message = "{$count} kategori berhasil dinonaktifkan.";
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

    /**
     * Generate unique slug for category
     */
    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = Category::where('slug', $slug);
        
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Category::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }

    /**
     * Export categories to CSV
     */
    public function export()
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();

        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, ['ID', 'Nama', 'Slug', 'Deskripsi', 'Status', 'Jumlah Berita', 'Dibuat', 'Diupdate']);
            
            // CSV Data
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->slug,
                    $category->description,
                    $category->status,
                    $category->posts_count,
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
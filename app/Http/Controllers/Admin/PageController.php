<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('user');
        
        // Filter by type if specified
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        $pages = $query->latest()->paginate(15);
        
        // Get counts for each type
        $totalPages = Page::count();
        $historyCount = Page::where('type', 'history')->count();
        $visionMissionCount = Page::where('type', 'vision_mission')->count();
        $organizationCount = Page::where('type', 'organization_structure')->count();
        
        return view('admin.pages.index', compact(
            'pages', 
            'totalPages', 
            'historyCount', 
            'visionMissionCount', 
            'organizationCount'
        ));
    }

    public function create(Request $request)
    {
        $pageTypes = Page::getPageTypes();
        $selectedType = $request->get('type', null);
        return view('admin.pages.create', compact('pageTypes', 'selectedType'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:history,vision_mission,organization_structure',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300'
        ];

        // Add validation rules based on page type
        if ($request->type === 'vision_mission') {
            $rules['vision_text'] = 'required|string';
            $rules['mission_text'] = 'required|string';
            $rules['content'] = 'nullable|string'; // content is optional for vision_mission
            $rules['additional_content'] = 'nullable|string';
        } elseif ($request->type === 'organization_structure') {
            // For organization structure, content and featured_image are not required
            $rules['content'] = 'nullable|string';
            $rules['featured_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';
        } else {
            $rules['content'] = 'required|string';
        }

        $request->validate($rules);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = $this->generateUniqueSlug($request->title);

        // For vision_mission pages, combine additional_content with content if provided
        if ($request->type === 'vision_mission' && $request->additional_content) {
            $data['content'] = $request->additional_content;
        }

        // Handle featured image upload (not for organization_structure)
        if ($request->hasFile('featured_image') && $request->type !== 'organization_structure') {
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dibuat.');
    }

    public function show(Page $page)
    {
        $page->load('user');
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $pageTypes = Page::getPageTypes();
        return view('admin.pages.edit', compact('page', 'pageTypes'));
    }

    public function update(Request $request, Page $page)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:history,vision_mission,organization_structure',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300'
        ];

        // Add validation rules based on page type
        if ($request->type === 'vision_mission') {
            $rules['vision_text'] = 'required|string';
            $rules['mission_text'] = 'required|string';
            $rules['content'] = 'nullable|string'; // content is optional for vision_mission
        } elseif ($request->type === 'organization_structure') {
            // For organization structure, content and featured_image are not required
            $rules['content'] = 'nullable|string';
        } else {
            $rules['content'] = 'required|string';
        }

        $request->validate($rules);

        $data = $request->all();

        // Update slug if title changed
        if ($page->title !== $request->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, $page->id);
        }

        // Handle featured image upload (not for organization_structure)
        if ($request->hasFile('featured_image') && $request->type !== 'organization_structure') {
            // Delete old image if exists
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'));
        } elseif ($request->type === 'organization_structure' && $page->featured_image) {
            // Remove featured image if page type changed to organization_structure
            Storage::disk('public')->delete($page->featured_image);
            $data['featured_image'] = null;
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        try {
            // Delete featured image if exists
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }

            $page->delete();

            return redirect()->route('admin.pages.index')
                ->with('success', 'Halaman berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.pages.index')
                ->with('error', 'Terjadi kesalahan saat menghapus halaman.');
        }
    }

    private function uploadImage($file): string
    {
        try {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pages', $filename, 'public');
            return 'pages/' . $filename;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }

    private function generateUniqueSlug($title, $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = Page::where('slug', $slug);
        
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Page::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}

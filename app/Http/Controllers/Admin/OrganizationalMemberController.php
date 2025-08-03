<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalMember;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrganizationalMemberController extends Controller
{
    public function index(Page $page)
    {
        $members = $page->organizationalMembers()->ordered()->get();
        return view('admin.organizational-members.index', compact('page', 'members'));
    }

    public function create(Page $page)
    {
        return view('admin.organizational-members.create', compact('page'));
    }

    public function store(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $data['page_id'] = $page->id;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Set default sort order if not provided
        if (!$data['sort_order']) {
            $lastMember = $page->organizationalMembers()->orderBy('sort_order', 'desc')->first();
            $data['sort_order'] = $lastMember ? $lastMember->sort_order + 1 : 0;
        }

        OrganizationalMember::create($data);

        return redirect()->route('admin.pages.organizational-members.index', $page)
            ->with('success', 'Anggota organisasi berhasil ditambahkan.');
    }

    public function show(Page $page, OrganizationalMember $organizational_member)
    {
        return view('admin.organizational-members.show', compact('page', 'organizational_member'));
    }

    public function edit(Page $page, OrganizationalMember $organizational_member)
    {
        return view('admin.organizational-members.edit', compact('page', 'organizational_member'));
    }

    public function update(Request $request, Page $page, OrganizationalMember $organizational_member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except(['_token', '_method']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($organizational_member->photo) {
                Storage::disk('public')->delete($organizational_member->photo);
            }
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $organizational_member->update($data);

        return redirect()
            ->route('admin.pages.organizational-members.index', $page)
            ->with('success', 'Anggota organisasi berhasil diperbarui.');
    }

    public function destroy(Page $page, OrganizationalMember $organizational_member)
    {
        try {
            Log::info('Delete attempt started', [
                'page_id' => $page->id,
                'member_id' => $organizational_member->id,
                'member_name' => $organizational_member->name
            ]);

            // Delete photo if exists
            if ($organizational_member->photo) {
                Storage::disk('public')->delete($organizational_member->photo);
                Log::info('Photo deleted', ['photo_path' => $organizational_member->photo]);
            }

            // Delete the member
            $organizational_member->delete();
            
            Log::info('Member deleted successfully', [
                'member_id' => $organizational_member->id,
                'page_id' => $page->id
            ]);

            return redirect()
                ->route('admin.pages.organizational-members.index', $page)
                ->with('success', 'Anggota organisasi berhasil dihapus.');
                
        } catch (\Exception $e) {
            Log::error('Failed to delete member', [
                'error' => $e->getMessage(),
                'page_id' => $page->id,
                'member_id' => $organizational_member->id
            ]);
            
            return redirect()
                ->route('admin.pages.organizational-members.index', $page)
                ->with('error', 'Gagal menghapus anggota organisasi: ' . $e->getMessage());
        }
    }

    private function uploadPhoto($file)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('organizational-members', $fileName, 'public');
        return $path;
    }
}

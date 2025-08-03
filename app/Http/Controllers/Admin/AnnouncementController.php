<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->latest()->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'priority' => 'required|in:low,medium,high,urgent',
            'valid_until' => 'nullable|date|after:today',
            'status' => 'required|in:active,inactive'
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'priority.required' => 'Prioritas wajib dipilih.',
            'valid_until.after' => 'Tanggal berlaku sampai harus setelah hari ini.'
        ]);

        Announcement::create($request->all());

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'priority' => 'required|in:low,medium,high,urgent',
            'valid_until' => 'nullable|date|after:today',
            'status' => 'required|in:active,inactive'
        ]);

        $announcement->update($request->all());

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggleStatus(Announcement $announcement)
    {
        $newStatus = $announcement->status === 'active' ? 'inactive' : 'active';
        $announcement->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => "Status pengumuman berhasil diubah menjadi {$newStatus}.",
            'status' => $newStatus
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:announcements,id'
        ]);

        try {
            $announcements = Announcement::whereIn('id', $request->ids);
            $count = $announcements->count();

            switch ($request->action) {
                case 'delete':
                    $announcements->delete();
                    $message = "{$count} pengumuman berhasil dihapus.";
                    break;
                case 'activate':
                    $announcements->update(['status' => 'active']);
                    $message = "{$count} pengumuman berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    $announcements->update(['status' => 'inactive']);
                    $message = "{$count} pengumuman berhasil dinonaktifkan.";
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
}
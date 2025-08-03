<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        // Mark as read when viewed
        if ($message->status === 'new') {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied',
            'reply' => 'nullable|string|max:2000'
        ]);

        if ($request->status === 'replied' && $request->filled('reply')) {
            $message->markAsReplied($request->reply);
        } else {
            $message->update(['status' => $request->status]);
        }

        return redirect()->route('admin.messages.index')
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil ditandai sebagai dibaca.'
        ]);
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $request->validate([
            'reply' => 'required|string|max:2000'
        ]);

        $message->markAsReplied($request->reply);

        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil disimpan.'
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_read,mark_unread',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:contact_messages,id'
        ]);

        try {
            $messages = ContactMessage::whereIn('id', $request->ids);
            $count = $messages->count();

            switch ($request->action) {
                case 'delete':
                    $messages->delete();
                    $message = "{$count} pesan berhasil dihapus.";
                    break;
                case 'mark_read':
                    $messages->update(['status' => 'read']);
                    $message = "{$count} pesan berhasil ditandai sebagai dibaca.";
                    break;
                case 'mark_unread':
                    $messages->update(['status' => 'new']);
                    $message = "{$count} pesan berhasil ditandai sebagai belum dibaca.";
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
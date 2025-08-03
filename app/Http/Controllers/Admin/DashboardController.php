<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('status', 'new')->count(),
            'total_galleries' => Gallery::count(),
            'total_users' => User::count(),
            'active_announcements' => Announcement::active()->count()
        ];

        $recentPosts = Post::with(['category', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::latest()
            ->limit(5)
            ->get();

        $urgentAnnouncements = Announcement::urgent()
            ->active()
            ->latest()
            ->limit(3)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentMessages', 'urgentAnnouncements'));
    }
}
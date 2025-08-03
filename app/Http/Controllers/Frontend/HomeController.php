<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\VillageData;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest published posts
        $latestPosts = Post::published()
            ->with(['category', 'user'])
            ->latest()
            ->limit(6)
            ->get();

        // Get active announcements
        $announcements = Announcement::active()
            ->latest()
            ->limit(3)
            ->get();

        // Get latest galleries
        $galleries = Gallery::latest()
            ->limit(6)
            ->get();

        // Get village statistics
        $villageStats = VillageData::all();

        return view('frontend.home', [
            'latestPosts' => $latestPosts,
            'announcements' => $announcements,
            'galleries' => $galleries,
            'villageStats' => $villageStats
        ]);
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\VillageData;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        // Check if page is active
        if ($page->status !== 'active') {
            abort(404, 'Halaman tidak ditemukan atau tidak aktif.');
        }

        return view('frontend.pages.show', compact('page'));
    }

    public function profile()
    {
        $demographics = VillageData::byType('demografi')->ordered()->get();
        $geography = VillageData::byType('geografis')->ordered()->get();
        $economy = VillageData::byType('ekonomi')->ordered()->get();
        $education = VillageData::byType('pendidikan')->ordered()->get();
        $health = VillageData::byType('kesehatan')->ordered()->get();

        // Ambil halaman Sejarah dan Visi Misi untuk preview
        $historyPage = \App\Models\Page::active()->byType('history')->first();
        $visionMissionPage = \App\Models\Page::active()->byType('vision_mission')->first();

        return view('frontend.pages.profile', compact(
            'demographics', 
            'geography', 
            'economy', 
            'education', 
            'health',
            'historyPage',
            'visionMissionPage'
        ));
    }

    public function history()
    {
        $page = Page::active()
            ->byType('history')
            ->first();

        if (!$page) {
            abort(404, 'Halaman Sejarah belum tersedia.');
        }

        return view('frontend.pages.show', compact('page'));
    }

    public function visionMission()
    {
        $page = Page::active()
            ->byType('vision_mission')
            ->first();

        if (!$page) {
            abort(404, 'Halaman Visi & Misi belum tersedia.');
        }

        return view('frontend.pages.show', compact('page'));
    }

    public function organizationStructure()
    {
        $page = Page::active()
            ->byType('organization_structure')
            ->with(['organizationalMembers' => function($query) {
                $query->active()->ordered();
            }])
            ->first();

        if (!$page) {
            abort(404, 'Halaman Struktur Organisasi belum tersedia.');
        }

        return view('frontend.pages.show', compact('page'));
    }
}
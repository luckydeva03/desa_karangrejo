<?php

use Illuminate\Support\Facades\Route;
use App\Models\Setting;

Route::get('/fix/settings', function () {
    $footerSettings = [
        [
            'key' => 'footer_copyright',
            'value' => 'Desa Karangrejo. All rights reserved.',
            'type' => 'text',
            'group' => 'footer',
            'label' => 'Copyright Text',
            'description' => 'Teks copyright yang ditampilkan di footer',
            'sort_order' => 1,
        ],
        [
            'key' => 'footer_developer',
            'value' => 'Developed with ❤️ by Tim IT Desa',
            'type' => 'text',
            'group' => 'footer',
            'label' => 'Developer Credit',
            'description' => 'Credit untuk developer',
            'sort_order' => 2,
        ],
    ];

    $created = 0;
    foreach ($footerSettings as $setting) {
        $existing = Setting::where('key', $setting['key'])->first();
        if (!$existing) {
            Setting::create($setting);
            $created++;
        }
    }

    return response()->json([
        'success' => true,
        'message' => "Created {$created} footer settings",
        'footer_count' => Setting::where('group', 'footer')->count()
    ]);
});

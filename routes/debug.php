<?php

use Illuminate\Support\Facades\Route;
use App\Models\Setting;

Route::get('/debug/settings', function () {
    $data = [];
    
    $data['total'] = Setting::count();
    
    $groups = ['general', 'contact', 'social', 'footer', 'contact_office', 'contact_hours', 'contact_emergency', 'contact_map'];
    
    foreach ($groups as $group) {
        $settings = Setting::where('group', $group)->get();
        $data['groups'][$group] = [
            'count' => $settings->count(),
            'items' => $settings->toArray()
        ];
    }
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});

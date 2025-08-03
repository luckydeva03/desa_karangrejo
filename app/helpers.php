<?php

// Helper functions for the application
// Add your custom helper functions here

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

// Load additional helper files
require_once __DIR__ . '/Helpers/IconHelper.php';

if (!function_exists('getSetting')) {
    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSetting($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 60 * 60 * 24, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}

if (!function_exists('getSettingsByGroup')) {
    /**
     * Get all settings by group
     *
     * @param string $group
     * @return array
     */
    function getSettingsByGroup($group)
    {
        return Cache::remember("settings_group_{$group}", 60 * 60 * 24, function () use ($group) {
            try {
                // Check if settings table exists (for testing environment)
                if (!Schema::hasTable('settings')) {
                    return [];
                }
                
                return Setting::where('group', $group)
                    ->orderBy('sort_order')
                    ->get()
                    ->keyBy('key')
                    ->map(function ($item) {
                        return $item->value;
                    })
                    ->toArray();
            } catch (\Exception $e) {
                // Return empty array if any database error occurs
                return [];
            }
        });
    }
}

if (!function_exists('getFooterData')) {
    /**
     * Get footer data for use in templates
     *
     * @return array
     */
    function getFooterData()
    {
        return Cache::remember('footer_data', 60 * 60 * 24, function () {
            $general = getSettingsByGroup('general');
            $contact = getSettingsByGroup('contact');
            $social = getSettingsByGroup('social');
            $footer = getSettingsByGroup('footer');
            
            return array_merge($general, $contact, $social, $footer);
        });
    }
}

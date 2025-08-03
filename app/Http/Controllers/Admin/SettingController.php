<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        // Get all settings grouped
        $generalSettings = Setting::where('group', 'general')->get();
        $contactSettings = Setting::where('group', 'contact')->get();
        $socialSettings = Setting::where('group', 'social')->get();
        $footerSettings = Setting::where('group', 'footer')->get();
        
        // Contact page settings
        $contactOfficeSettings = Setting::where('group', 'contact_office')->get();
        $contactHoursSettings = Setting::where('group', 'contact_hours')->get();
        $contactEmergencySettings = Setting::where('group', 'contact_emergency')->get();
        $contactMapSettings = Setting::where('group', 'contact_map')->get();

        return view('admin.settings.index', compact(
            'generalSettings',
            'contactSettings', 
            'socialSettings',
            'footerSettings',
            'contactOfficeSettings',
            'contactHoursSettings',
            'contactEmergencySettings',
            'contactMapSettings'
        ));
    }

    public function update(Request $request)
    {
        // Log untuk debugging
        Log::info('Settings Update Request', [
            'method' => $request->method(),
            'has_settings' => $request->has('settings'),
            'settings_count' => $request->has('settings') ? count($request->settings) : 0
        ]);

        try {
            // Validate input
            $request->validate([
                'settings' => 'required|array',
                'settings.*' => 'nullable|string|max:2000',
            ]);

            $updated = 0;
            $changed = 0;
            
            // Update each setting - tapi hanya hitung yang benar-benar berubah
            foreach ($request->settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                
                if ($setting) {
                    $newValue = $value ?? '';
                    $oldValue = $setting->value ?? '';
                    
                    // Hanya update jika nilai benar-benar berubah
                    if ($oldValue !== $newValue) {
                        $setting->update(['value' => $newValue]);
                        
                        // Clear specific cache
                        Cache::forget("setting_{$key}");
                        
                        $changed++;
                        Log::info("Changed setting: {$key}", [
                            'old_value' => $oldValue,
                            'new_value' => $newValue
                        ]);
                    }
                    
                    $updated++;
                }
            }

            // Clear group-related cache jika ada perubahan
            if ($changed > 0) {
                Cache::forget('all_settings');
                Cache::forget('footer_data');
                Cache::forget('settings_group_general');
                Cache::forget('settings_group_contact');
                Cache::forget('settings_group_social');
                Cache::forget('settings_group_footer');
                Cache::forget('settings_group_contact_office');
                Cache::forget('settings_group_contact_hours');
                Cache::forget('settings_group_contact_emergency');
                Cache::forget('settings_group_contact_map');
            }

            // Pesan yang lebih informatif
            if ($changed > 0) {
                $message = $changed === 1 
                    ? "Berhasil mengubah 1 pengaturan!" 
                    : "Berhasil mengubah {$changed} pengaturan!";
                    
                return redirect()->route('admin.settings.index')
                    ->with('success', $message);
            } else {
                return redirect()->route('admin.settings.index')
                    ->with('info', 'Tidak ada perubahan yang disimpan.');
            }

        } catch (\Exception $e) {
            Log::error('Settings update error: ' . $e->getMessage());
            
            return redirect()->route('admin.settings.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

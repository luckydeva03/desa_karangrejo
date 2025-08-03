<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class FooterController extends Controller
{
    public static function getFooterData()
    {
        return [
            // Site Info
            'site_name' => Setting::getValue('site_name', 'Desa Karangrejo'),
            'site_description' => Setting::getValue('site_description', 'Website resmi Desa Karangrejo'),
            
            // Contact Info
            'contact_address' => Setting::getValue('contact_address', ''),
            'contact_phone' => Setting::getValue('contact_phone', ''),
            'contact_email' => Setting::getValue('contact_email', ''),
            'contact_hours' => Setting::getValue('contact_hours', ''),
            
            // Social Media
            'social_facebook' => Setting::getValue('social_facebook', ''),
            'social_instagram' => Setting::getValue('social_instagram', ''),
            'social_youtube' => Setting::getValue('social_youtube', ''),
            'social_whatsapp' => Setting::getValue('social_whatsapp', ''),
            
            // Footer
            'footer_copyright' => Setting::getValue('footer_copyright', 'Desa Karangrejo. All rights reserved.'),
            'footer_developer' => Setting::getValue('footer_developer', 'Developed with ❤️ by Tim IT Desa'),
        ];
    }
}

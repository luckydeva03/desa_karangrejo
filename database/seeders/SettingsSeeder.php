<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Desa Karangrejo',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website yang akan ditampilkan',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Website resmi Desa Karangrejo yang menyediakan informasi terkini tentang kegiatan, layanan, dan pembangunan desa.',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat tentang website',
                'sort_order' => 2,
            ],
            
            // Contact Settings
            [
                'key' => 'contact_address',
                'value' => "Jl. Raya Karangrejo No. 123\nKecamatan Sukodadi\nKabupaten Lamongan, Jawa Timur",
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat',
                'description' => 'Alamat lengkap kantor desa',
                'sort_order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '(0322) 123456',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon kantor desa',
                'sort_order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@desakarangrejo.id',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email',
                'description' => 'Alamat email resmi desa',
                'sort_order' => 3,
            ],
            [
                'key' => 'contact_hours',
                'value' => 'Senin - Jumat: 08:00 - 16:00',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Jam Operasional',
                'description' => 'Jam buka layanan kantor desa',
                'sort_order' => 4,
            ],
            
            // Social Media Settings
            [
                'key' => 'social_facebook',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook',
                'description' => 'URL halaman Facebook resmi desa',
                'sort_order' => 1,
            ],
            [
                'key' => 'social_instagram',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram',
                'description' => 'URL halaman Instagram resmi desa',
                'sort_order' => 2,
            ],
            [
                'key' => 'social_youtube',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube',
                'description' => 'URL channel YouTube resmi desa',
                'sort_order' => 3,
            ],
            [
                'key' => 'social_whatsapp',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'WhatsApp',
                'description' => 'URL WhatsApp resmi desa',
                'sort_order' => 4,
            ],
            
            // Footer Settings
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
            
            // Contact Page Settings - Office Info
            [
                'key' => 'office_address',
                'value' => 'Jl. Raya Karangrejo No. 123, Kecamatan Sukodadi, Kabupaten Lamongan, Jawa Timur 62253',
                'type' => 'textarea',
                'group' => 'contact_office',
                'label' => 'Alamat Kantor',
                'description' => 'Alamat lengkap kantor desa',
                'sort_order' => 1,
            ],
            [
                'key' => 'office_phone',
                'value' => '(0322) 123456',
                'type' => 'text',
                'group' => 'contact_office',
                'label' => 'Telepon Kantor',
                'description' => 'Nomor telepon kantor desa',
                'sort_order' => 2,
            ],
            [
                'key' => 'office_email',
                'value' => 'info@desakarangrejo.id',
                'type' => 'email',
                'group' => 'contact_office',
                'label' => 'Email Kantor',
                'description' => 'Email resmi kantor desa',
                'sort_order' => 3,
            ],
            
            // Contact Page Settings - Office Hours
            [
                'key' => 'office_hours_weekday',
                'value' => '08:00 - 16:00 WIB',
                'type' => 'text',
                'group' => 'contact_hours',
                'label' => 'Jam Kerja Senin-Jumat',
                'description' => 'Jam operasional hari kerja',
                'sort_order' => 1,
            ],
            [
                'key' => 'office_hours_saturday',
                'value' => '08:00 - 12:00 WIB',
                'type' => 'text',
                'group' => 'contact_hours',
                'label' => 'Jam Kerja Sabtu',
                'description' => 'Jam operasional hari Sabtu',
                'sort_order' => 2,
            ],
            [
                'key' => 'office_hours_sunday',
                'value' => 'Tutup',
                'type' => 'text',
                'group' => 'contact_hours',
                'label' => 'Jam Kerja Minggu',
                'description' => 'Status operasional hari Minggu',
                'sort_order' => 3,
            ],
            
            // Contact Page Settings - Emergency Contacts
            [
                'key' => 'emergency_kepala_desa',
                'value' => '081234567890',
                'type' => 'text',
                'group' => 'contact_emergency',
                'label' => 'Kontak Kepala Desa',
                'description' => 'Nomor telepon kepala desa',
                'sort_order' => 1,
            ],
            [
                'key' => 'emergency_sekretaris',
                'value' => '081234567891',
                'type' => 'text',
                'group' => 'contact_emergency',
                'label' => 'Kontak Sekretaris Desa',
                'description' => 'Nomor telepon sekretaris desa',
                'sort_order' => 2,
            ],
            [
                'key' => 'emergency_babinsa',
                'value' => '081234567892',
                'type' => 'text',
                'group' => 'contact_emergency',
                'label' => 'Kontak Babinsa',
                'description' => 'Nomor telepon Babinsa',
                'sort_order' => 3,
            ],
            [
                'key' => 'emergency_bhabinkamtibmas',
                'value' => '081234567893',
                'type' => 'text',
                'group' => 'contact_emergency',
                'label' => 'Kontak Bhabinkamtibmas',
                'description' => 'Nomor telepon Bhabinkamtibmas',
                'sort_order' => 4,
            ],
            
            // Contact Page Settings - Map
            [
                'key' => 'office_map_embed',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.123456789!2d112.123456!3d-7.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890',
                'type' => 'url',
                'group' => 'contact_map',
                'label' => 'Google Maps Embed URL',
                'description' => 'URL embed Google Maps untuk lokasi kantor desa',
                'sort_order' => 1,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

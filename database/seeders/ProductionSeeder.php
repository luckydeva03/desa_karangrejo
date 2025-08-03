<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Page;
use App\Models\VillageData;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductionSeeder extends Seeder
{
    /**
     * Run the production database seeds for deployment.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding production data...');

        // Create Roles and Permissions
        $this->createRolesAndPermissions();
        
        // Create default admin user
        $this->createAdminUser();
        
        // Create essential categories
        $this->createCategories();
        
        // Create essential pages
        $this->createPages();
        
        // Create village data
        $this->createVillageData();
        
        // Create settings
        $this->createSettings();

        $this->command->info('✅ Production seeding completed!');
        $this->command->info('👤 Admin login: admin@desakarangrejo.id / Admin123!');
    }

    private function createRolesAndPermissions()
    {
        $this->command->info('🔐 Creating roles and permissions...');

        // Create permissions
        $permissions = [
            'manage_users',
            'manage_posts',
            'manage_pages',
            'manage_categories',
            'manage_galleries',
            'manage_announcements',
            'manage_village_data',
            'manage_settings',
            'view_admin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);

        // Assign permissions to roles
        $adminRole->syncPermissions($permissions);
        $operatorRole->syncPermissions(['manage_posts', 'manage_galleries', 'view_admin']);
    }

    private function createAdminUser()
    {
        $this->command->info('👤 Creating admin user...');

        $admin = User::firstOrCreate(
            ['email' => 'admin@desakarangrejo.id'],
            [
                'name' => 'Administrator Desa',
                'password' => Hash::make('Admin123!'),
                'email_verified_at' => now(),
                'phone' => '081234567890',
                'role' => 'admin',
                'bio' => 'Administrator sistem website Desa Karangrejo',
                'status' => 'active',
            ]
        );

        $admin->assignRole('admin');
    }

    private function createCategories()
    {
        $this->command->info('📂 Creating categories...');

        $categories = [
            [
                'name' => 'Berita Desa',
                'slug' => 'berita-desa',
                'description' => 'Berita dan informasi terbaru dari Desa Karangrejo',
                'status' => 'active',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari pemerintah desa',
                'status' => 'active',
            ],
            [
                'name' => 'Kegiatan Desa',
                'slug' => 'kegiatan-desa',
                'description' => 'Dokumentasi kegiatan dan acara desa',
                'status' => 'active',
            ],
            [
                'name' => 'Pembangunan',
                'slug' => 'pembangunan',
                'description' => 'Informasi pembangunan dan infrastruktur desa',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }

    private function createPages()
    {
        $this->command->info('📄 Creating essential pages...');

        $pages = [
            [
                'title' => 'Profil Desa',
                'slug' => 'profil-desa',
                'content' => '<p>Desa Karangrejo adalah sebuah desa yang terletak di wilayah yang strategis dengan potensi alam dan sumber daya manusia yang melimpah.</p>',
                'type' => 'profile',
                'status' => 'active',
                'meta_description' => 'Profil lengkap Desa Karangrejo',
            ],
            [
                'title' => 'Sejarah Desa',
                'slug' => 'sejarah-desa',
                'content' => '<p>Sejarah berdirinya Desa Karangrejo dimulai dari...</p>',
                'type' => 'history',
                'status' => 'active',
                'meta_description' => 'Sejarah berdirinya Desa Karangrejo',
            ],
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'content' => '<p>Visi dan Misi Desa Karangrejo dalam pembangunan dan pelayanan masyarakat.</p>',
                'type' => 'vision_mission',
                'status' => 'active',
                'meta_description' => 'Visi dan Misi Desa Karangrejo',
                'vision_text' => 'Menjadikan Desa Karangrejo sebagai desa yang maju, mandiri, dan sejahtera.',
                'mission_text' => '<ul><li>Meningkatkan kualitas pelayanan publik</li><li>Mengembangkan potensi ekonomi desa</li><li>Memperkuat tata kelola pemerintahan</li></ul>',
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' => '<p>Struktur organisasi pemerintahan Desa Karangrejo.</p>',
                'type' => 'organization',
                'status' => 'active',
                'meta_description' => 'Struktur organisasi pemerintahan Desa Karangrejo',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }

    private function createVillageData()
    {
        $this->command->info('🏘️ Creating village data...');

        $villageData = [
            [
                'type' => 'demografi',
                'label' => 'Jumlah Penduduk',
                'value' => '2.500 jiwa',
                'icon' => 'users',
                'description' => 'Total penduduk Desa Karangrejo',
            ],
            [
                'type' => 'geografis',
                'label' => 'Luas Wilayah',
                'value' => '350 hektar',
                'icon' => 'map',
                'description' => 'Luas wilayah administratif desa',
            ],
            [
                'type' => 'demografi',
                'label' => 'Jumlah KK',
                'value' => '650 KK',
                'icon' => 'home',
                'description' => 'Total kepala keluarga',
            ],
            [
                'type' => 'geografis',
                'label' => 'Jumlah Dusun',
                'value' => '4 dusun',
                'icon' => 'building',
                'description' => 'Pembagian wilayah administratif',
            ],
        ];

        foreach ($villageData as $data) {
            VillageData::firstOrCreate(
                ['type' => $data['type'], 'label' => $data['label']],
                $data
            );
        }
    }

    private function createSettings()
    {
        $this->command->info('⚙️ Creating settings...');

        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Desa Karangrejo',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website',
            ],
            [
                'key' => 'site_description',
                'value' => 'Website resmi Desa Karangrejo',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi website',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@desakarangrejo.id',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Email Kontak',
                'description' => 'Email kontak desa',
            ],
            [
                'key' => 'contact_phone',
                'value' => '(0274) 123456',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon desa',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Raya Karangrejo No. 1, Karangrejo, Yogyakarta',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Alamat Kantor',
                'description' => 'Alamat kantor desa',
            ],
            [
                'key' => 'office_hours',
                'value' => 'Senin - Jumat: 08.00 - 15.00 WIB',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Jam Operasional',
                'description' => 'Jam operasional kantor',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/desakarangrejo',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook',
                'description' => 'Facebook page',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/desakarangrejo',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram',
                'description' => 'Instagram account',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

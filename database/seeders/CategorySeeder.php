<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Desa',
                'slug' => 'berita-desa',
                'description' => 'Berita terkini seputar kegiatan dan perkembangan desa',
                'status' => 'active'
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari pemerintah desa',
                'status' => 'active'
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Kegiatan dan acara yang dilaksanakan di desa',
                'status' => 'active'
            ],
            [
                'name' => 'Pembangunan',
                'slug' => 'pembangunan',
                'description' => 'Update progress pembangunan infrastruktur desa',
                'status' => 'active'
            ],
            [
                'name' => 'Sosial Budaya',
                'slug' => 'sosial-budaya',
                'description' => 'Kegiatan sosial dan budaya masyarakat',
                'status' => 'active'
            ],
            [
                'name' => 'Ekonomi',
                'slug' => 'ekonomi',
                'description' => 'Berita dan informasi terkait ekonomi desa',
                'status' => 'active'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']], 
                $category
            );
        }
        
        $this->command->info('✅ Categories created: ' . count($categories) . ' categories');
    }
}
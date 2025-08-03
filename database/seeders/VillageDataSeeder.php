<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageData;

class VillageDataSeeder extends Seeder
{
    public function run(): void
    {
        $villageData = [
            // Demografi
            [
                'type' => 'demografi',
                'label' => 'Jumlah Penduduk',
                'value' => '5,234',
                'description' => 'Total penduduk Desa Karangrejo berdasarkan data terbaru',
                'icon' => 'fas fa-users',
                'sort_order' => 1
            ],
            [
                'type' => 'demografi',
                'label' => 'Jumlah KK',
                'value' => '1,456',
                'description' => 'Total Kepala Keluarga yang terdaftar',
                'icon' => 'fas fa-home',
                'sort_order' => 2
            ],
            [
                'type' => 'demografi',
                'label' => 'Laki-laki',
                'value' => '2,678',
                'description' => 'Jumlah penduduk laki-laki',
                'icon' => 'fas fa-male',
                'sort_order' => 3
            ],
            [
                'type' => 'demografi',
                'label' => 'Perempuan',
                'value' => '2,556',
                'description' => 'Jumlah penduduk perempuan',
                'icon' => 'fas fa-female',
                'sort_order' => 4
            ],
            
            // Geografis
            [
                'type' => 'geografis',
                'label' => 'Luas Wilayah',
                'value' => '12.5 km²',
                'description' => 'Total luas wilayah administratif desa',
                'icon' => 'fas fa-map',
                'sort_order' => 1
            ],
            [
                'type' => 'geografis',
                'label' => 'Jumlah RT',
                'value' => '25',
                'description' => 'Total Rukun Tetangga di seluruh desa',
                'icon' => 'fas fa-building',
                'sort_order' => 2
            ],
            [
                'type' => 'geografis',
                'label' => 'Jumlah RW',
                'value' => '8',
                'description' => 'Total Rukun Warga di seluruh desa',
                'icon' => 'fas fa-city',
                'sort_order' => 3
            ],
            [
                'type' => 'geografis',
                'label' => 'Ketinggian',
                'value' => '245 mdpl',
                'description' => 'Ketinggian rata-rata dari permukaan laut',
                'icon' => 'fas fa-mountain',
                'sort_order' => 4
            ],
            
            // Ekonomi
            [
                'type' => 'ekonomi',
                'label' => 'Petani',
                'value' => '65%',
                'description' => 'Persentase penduduk yang berprofesi sebagai petani',
                'icon' => 'fas fa-seedling',
                'sort_order' => 1
            ],
            [
                'type' => 'ekonomi',
                'label' => 'Pedagang',
                'value' => '20%',
                'description' => 'Persentase penduduk yang berprofesi sebagai pedagang',
                'icon' => 'fas fa-store',
                'sort_order' => 2
            ],
            [
                'type' => 'ekonomi',
                'label' => 'PNS/TNI/POLRI',
                'value' => '10%',
                'description' => 'Persentase penduduk yang bekerja sebagai PNS/TNI/POLRI',
                'icon' => 'fas fa-user-tie',
                'sort_order' => 3
            ],
            [
                'type' => 'ekonomi',
                'label' => 'Lainnya',
                'value' => '5%',
                'description' => 'Persentase penduduk dengan profesi lainnya',
                'icon' => 'fas fa-briefcase',
                'sort_order' => 4
            ],
        ];

        foreach ($villageData as $data) {
            VillageData::updateOrCreate(
                ['label' => $data['label'], 'type' => $data['type']], 
                $data
            );
        }
        
        $this->command->info('✅ Village data created: ' . count($villageData) . ' data entries');
    }
}
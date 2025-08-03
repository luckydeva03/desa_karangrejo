<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Pembayaran PBB Tahun 2025',
                'content' => 'Pembayaran Pajak Bumi dan Bangunan (PBB) tahun 2025 telah dibuka. Warga dapat melakukan pembayaran di kantor desa atau melalui bank yang telah ditunjuk. Batas waktu pembayaran adalah 31 Agustus 2025.',
                'priority' => 'high',
                'valid_until' => Carbon::now()->addDays(30),
                'status' => 'active'
            ],
            [
                'title' => 'Gotong Royong Mingguan',
                'content' => 'Kegiatan gotong royong mingguan akan dilaksanakan setiap hari Sabtu pukul 06.00 WIB. Mari bergotong royong menjaga kebersihan lingkungan desa kita bersama-sama.',
                'priority' => 'medium',
                'valid_until' => null,
                'status' => 'active'
            ],
            [
                'title' => 'Pendaftaran Bantuan Sosial Tunai',
                'content' => 'Pendaftaran program bantuan sosial tunai tahun 2025 telah dibuka. Warga yang memenuhi syarat dapat mendaftar di kantor desa dengan membawa KTP, KK, dan surat keterangan tidak mampu dari RT/RW.',
                'priority' => 'urgent',
                'valid_until' => Carbon::now()->addDays(21),
                'status' => 'active'
            ],
            [
                'title' => 'Rapat RT/RW Bulanan',
                'content' => 'Rapat koordinasi RT/RW se-Desa Karangrejo akan dilaksanakan pada tanggal 25 setiap bulan pukul 19.00 WIB di Balai Desa. Mohon kehadiran seluruh pengurus RT/RW.',
                'priority' => 'medium',
                'valid_until' => null,
                'status' => 'active'
            ],
            [
                'title' => 'Penutupan Jalan untuk Perbaikan',
                'content' => 'Jalan utama desa akan ditutup sementara untuk perbaikan infrastruktur pada tanggal 28-30 Juli 2025. Harap gunakan jalur alternatif yang telah disediakan.',
                'priority' => 'high',
                'valid_until' => Carbon::now()->addDays(15),
                'status' => 'active'
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::updateOrCreate(
                ['title' => $announcement['title']], 
                $announcement
            );
        }
        
        $this->command->info('✅ Announcements created: ' . count($announcements) . ' announcements');
    }
}
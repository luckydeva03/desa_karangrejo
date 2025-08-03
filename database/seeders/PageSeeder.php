<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first(); // Ambil user pertama sebagai author

        $pages = [
            [
                'title' => 'Sejarah Desa Karangrejo',
                'slug' => 'sejarah-desa-karangrejo',
                'content' => '<h2>Sejarah Singkat Desa Karangrejo</h2>
                <p>Desa Karangrejo adalah sebuah desa yang terletak di Kecamatan [Nama Kecamatan], Kabupaten [Nama Kabupaten]. Desa ini memiliki sejarah panjang yang dimulai dari masa kolonial Belanda.</p>
                
                <h3>Asal Usul Nama</h3>
                <p>Nama "Karangrejo" berasal dari dua kata, yaitu "Karang" yang berarti batu karang dan "Rejo" yang berarti makmur atau sejahtera. Hal ini mencerminkan harapan agar desa ini menjadi tempat yang makmur dan sejahtera bagi seluruh warganya.</p>
                
                <h3>Perkembangan Zaman</h3>
                <p>Pada masa kemerdekaan Indonesia, Desa Karangrejo mengalami berbagai perkembangan, mulai dari bidang pendidikan, ekonomi, hingga infrastruktur. Masyarakat desa yang mayoritas bermata pencaharian sebagai petani terus berupaya meningkatkan kesejahteraan hidup.</p>
                
                <h3>Era Modern</h3>
                <p>Saat ini, Desa Karangrejo telah mengalami modernisasi dengan adanya berbagai fasilitas umum seperti jalan beraspal, listrik, dan akses internet. Namun, desa ini tetap mempertahankan nilai-nilai tradisional dan kearifan lokal yang telah diwariskan turun-temurun.</p>',
                'type' => 'history',
                'status' => 'active',
                'meta_title' => 'Sejarah Desa Karangrejo - Mengenal Asal Usul dan Perkembangan',
                'meta_description' => 'Pelajari sejarah lengkap Desa Karangrejo, mulai dari asal usul nama hingga perkembangan modern yang mempertahankan nilai tradisional.',
                'user_id' => $user->id,
            ],
            [
                'title' => 'Visi dan Misi Desa Karangrejo',
                'slug' => 'visi-misi-desa-karangrejo',
                'content' => '<h2>Visi Desa Karangrejo</h2>
                <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h3 style="color: #2c5aa0; text-align: center;">"Terwujudnya Desa Karangrejo yang Maju, Mandiri, dan Sejahtera Berdasarkan Nilai-Nilai Gotong Royong"</h3>
                </div>
                
                <h2>Misi Desa Karangrejo</h2>
                <ol>
                    <li><strong>Meningkatkan Kualitas Sumber Daya Manusia</strong><br>
                    Mengembangkan pendidikan dan keterampilan masyarakat melalui program-program pemberdayaan dan pelatihan.</li>
                    
                    <li><strong>Mengembangkan Ekonomi Desa</strong><br>
                    Mendorong pertumbuhan ekonomi melalui pengembangan usaha mikro, kecil, dan menengah serta optimalisasi potensi desa.</li>
                    
                    <li><strong>Meningkatkan Infrastruktur dan Fasilitas Umum</strong><br>
                    Membangun dan memperbaiki infrastruktur dasar seperti jalan, irigasi, dan fasilitas umum lainnya.</li>
                    
                    <li><strong>Melestarikan Lingkungan Hidup</strong><br>
                    Menjaga kelestarian lingkungan melalui program-program ramah lingkungan dan pengelolaan sampah yang baik.</li>
                    
                    <li><strong>Meningkatkan Pelayanan Publik</strong><br>
                    Memberikan pelayanan yang prima kepada masyarakat dengan prinsip transparansi dan akuntabilitas.</li>
                    
                    <li><strong>Memperkuat Kerukunan dan Keamanan</strong><br>
                    Memelihara keharmonisan antar warga dan menjaga keamanan desa melalui partisipasi aktif masyarakat.</li>
                </ol>
                
                <h2>Tujuan Pembangunan</h2>
                <ul>
                    <li>Terciptanya masyarakat yang berdaya dan mandiri</li>
                    <li>Terwujudnya tata kelola pemerintahan yang baik</li>
                    <li>Meningkatnya kesejahteraan masyarakat</li>
                    <li>Terpeliharanya lingkungan hidup yang berkelanjutan</li>
                    <li>Terjaganya nilai-nilai budaya dan kearifan lokal</li>
                </ul>',
                'type' => 'vision_mission',
                'status' => 'active',
                'meta_title' => 'Visi Misi Desa Karangrejo - Arah Pembangunan dan Tujuan',
                'meta_description' => 'Visi dan Misi Desa Karangrejo dalam mewujudkan desa yang maju, mandiri, dan sejahtera berdasarkan nilai-nilai gotong royong.',
                'user_id' => $user->id,
            ],
            [
                'title' => 'Struktur Organisasi Pemerintah Desa Karangrejo',
                'slug' => 'struktur-organisasi-desa-karangrejo',
                'content' => '<h2>Struktur Organisasi Pemerintah Desa</h2>
                <p>Pemerintahan Desa Karangrejo dipimpin oleh Kepala Desa yang dibantu oleh perangkat desa dan Badan Permusyawaratan Desa (BPD) dalam menjalankan tugas pemerintahan, pembangunan, dan pelayanan masyarakat.</p>
                
                <h3>Kepala Desa</h3>
                <div style="background-color: #e3f2fd; padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <h4>Nama Kepala Desa</h4>
                    <p><strong>Periode:</strong> 2019 - 2025<br>
                    <strong>Alamat:</strong> Desa Karangrejo<br>
                    <strong>Pendidikan:</strong> S1</p>
                </div>
                
                <h3>Perangkat Desa</h3>
                
                <h4>Sekretaris Desa</h4>
                <ul>
                    <li><strong>Nama:</strong> [Nama Sekretaris Desa]</li>
                    <li><strong>Pendidikan:</strong> S1</li>
                    <li><strong>Tugas:</strong> Membantu Kepala Desa dalam bidang administrasi pemerintahan</li>
                </ul>
                
                <h4>Kepala Urusan (Kaur)</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Kaur Tata Usaha dan Umum</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kaur TU]</li>
                            <li><strong>Tugas:</strong> Mengelola administrasi umum dan ketatausahaan</li>
                        </ul>
                        
                        <h5>Kaur Keuangan</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kaur Keuangan]</li>
                            <li><strong>Tugas:</strong> Mengelola keuangan desa</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Kaur Perencanaan</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kaur Perencanaan]</li>
                            <li><strong>Tugas:</strong> Menyusun perencanaan pembangunan desa</li>
                        </ul>
                    </div>
                </div>
                
                <h4>Kepala Seksi (Kasi)</h4>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Kasi Pemerintahan</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kasi Pemerintahan]</li>
                            <li><strong>Tugas:</strong> Menyelenggarakan urusan pemerintahan umum</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Kasi Kesejahteraan</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kasi Kesejahteraan]</li>
                            <li><strong>Tugas:</strong> Menyelenggarakan urusan kesejahteraan masyarakat</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Kasi Pelayanan</h5>
                        <ul>
                            <li><strong>Nama:</strong> [Nama Kasi Pelayanan]</li>
                            <li><strong>Tugas:</strong> Menyelenggarakan pelayanan kepada masyarakat</li>
                        </ul>
                    </div>
                </div>
                
                <h3>Kepala Dusun</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Dusun I</h4>
                        <ul>
                            <li><strong>Kepala Dusun:</strong> [Nama Kadus I]</li>
                            <li><strong>Wilayah:</strong> RT 01 - RT 05</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Dusun II</h4>
                        <ul>
                            <li><strong>Kepala Dusun:</strong> [Nama Kadus II]</li>
                            <li><strong>Wilayah:</strong> RT 06 - RT 10</li>
                        </ul>
                    </div>
                </div>
                
                <h3>Badan Permusyawaratan Desa (BPD)</h3>
                <ul>
                    <li><strong>Ketua:</strong> [Nama Ketua BPD]</li>
                    <li><strong>Wakil Ketua:</strong> [Nama Wakil Ketua BPD]</li>
                    <li><strong>Sekretaris:</strong> [Nama Sekretaris BPD]</li>
                    <li><strong>Anggota:</strong> [Nama-nama Anggota BPD]</li>
                </ul>
                
                <p><em>*Struktur organisasi dapat berubah sesuai dengan perkembangan dan kebutuhan organisasi</em></p>',
                'type' => 'organization_structure',
                'status' => 'active',
                'meta_title' => 'Struktur Organisasi Pemerintah Desa Karangrejo',
                'meta_description' => 'Struktur organisasi lengkap pemerintahan Desa Karangrejo mulai dari Kepala Desa, perangkat desa, hingga BPD.',
                'user_id' => $user->id,
            ],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::updateOrCreate(
                ['slug' => $page['slug']], 
                $page
            );
        }
        
        $this->command->info('✅ Pages created: ' . count($pages) . ' pages');
    }
}

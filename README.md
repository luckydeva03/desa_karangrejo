# Website Desa Karangrejo

Website berbasis Laravel untuk digitalisasi administrasi dan portal informasi Desa Karangrejo, Ujungpangkah.



https://github.com/user-attachments/assets/9ed2b535-562b-4bd3-9dd3-cea1f2d6bca0



## Tentang Aplikasi

Aplikasi Laravel 12 yang dibangun untuk manajemen administrasi desa dengan fitur:

- **Sistem Manajemen Konten** untuk pengumuman dan informasi desa
- **Manajemen Galeri** untuk foto dan dokumentasi
- **Manajemen Data Desa** untuk data demografi dan administratif
- **Manajemen Pengguna** dengan sistem role dan permission
- **Sistem Kontak** untuk pertanyaan warga
- **Desain Responsif** dengan Tailwind CSS

## Teknologi yang Digunakan

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade Templates, Alpine.js, Tailwind CSS
- **Database**: MySQL
- **Build Tools**: Vite
- **Library Tambahan**: 
  - Spatie Laravel Permission (roles & permissions)
  - Spatie Laravel Activitylog (audit trail)
  - Spatie Laravel Backup
  - Intervention Image (pemrosesan gambar)
  - Laravel Telescope (debugging)
  - DataTables (tampilan data)

## Kebutuhan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd desa-karangrejo
   ```

2. **Install dependensi PHP**
   ```bash
   composer install
   ```

3. **Install dependensi Node**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**
   - Update file `.env` dengan kredensial database Anda
   - Buat database baru

6. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Buat symbolic link storage**
   ```bash
   php artisan storage:link
   ```

## Development

Menjalankan server development:

```bash
# Server Laravel development
php artisan serve

# Server Vite development (di terminal terpisah)
npm run dev
```

## Fitur

### Panel Admin
- Dashboard dengan statistik
- Manajemen konten (artikel, halaman, pengumuman)
- Manajemen galeri
- Manajemen pengguna dengan roles
- Manajemen data desa
- Konfigurasi pengaturan

### Website Publik
- Homepage dengan informasi desa
- Berita dan pengumuman
- Galeri foto
- Tampilan data desa
- Form kontak

## Fitur Keamanan

- Kontrol akses berbasis role
- Proteksi CSRF
- Proteksi XSS
- Pencegahan SQL injection
- Logging aktivitas
- Upload file yang aman

## Kontribusi

1. Fork repository ini
2. Buat feature branch
3. Lakukan perubahan
4. Jalankan testing
5. Submit pull request

## Lisensi

Proyek ini adalah open-source software dengan lisensi [MIT license](LICENSE).

## Dukungan

Untuk dukungan dan pertanyaan, silakan hubungi tim development.

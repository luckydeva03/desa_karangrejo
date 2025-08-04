# 📖 Installation Guide

Panduan lengkap instalasi Website Desa Karangrejo.

## 📋 Kebutuhan Sistem

### Server Requirements
- **PHP**: 8.2 atau lebih tinggi
- **Web Server**: Apache/Nginx
- **Database**: MySQL 8.0+ / MariaDB 10.4+
- **Node.js**: 18+ (untuk build assets)
- **Composer**: 2.0+

### PHP Extensions
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD (untuk image processing)

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/luckydeva03/desa_karangrejo.git
cd desa_karangrejo
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_karangrejo
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
# Create database (manual atau via command)
mysql -u root -p -e "CREATE DATABASE desa_karangrejo"

# Run migrations
php artisan migrate

# Seed database with initial data
php artisan db:seed
```

### 6. Storage & Permissions
```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

## 🔧 Web Server Configuration

### Apache (.htaccess)
File `.htaccess` sudah disediakan di folder `public/`.

### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/desa_karangrejo/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 👤 Default User

Setelah seeding, login dengan:
- **Username**: admin@admin.com
- **Password**: password

⚠️ **PENTING**: Ganti password default setelah login pertama!

## ✅ Verifikasi Instalasi

1. Buka browser ke domain/IP server
2. Pastikan halaman home muncul tanpa error
3. Login ke admin panel di `/admin`
4. Check semua menu berfungsi dengan baik

## 🛠️ Troubleshooting

### Error "500 Internal Server Error"
- Check file permissions
- Check error log: `tail -f storage/logs/laravel.log`
- Pastikan semua requirements terpenuhi

### Error Database Connection
- Pastikan MySQL service running
- Check kredensial di file `.env`
- Test koneksi: `php artisan tinker` → `DB::connection()->getPdo()`

### Error "Key not found"
- Jalankan: `php artisan key:generate`

### Error "Class not found"
- Jalankan: `composer dump-autoload`

## 📞 Bantuan

Jika mengalami kesulitan:
- Check [Troubleshooting Guide](Troubleshooting)
- Create [Bug Report](https://github.com/luckydeva03/desa_karangrejo/issues/new?template=bug_report.md)
- Email: thendeanrichard29@gmail.com

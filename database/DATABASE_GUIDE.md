# 🗄️ Database Export & Setup Guide - Desa Karangrejo

## 📊 Database Overview

**Database Name:** `desa_karangrejo`  
**Total Tables:** 23  
**Total Size:** 592.00 KB  
**Engine:** MySQL 8.4.3

### Table Structure
| Table | Purpose | Size |
|-------|---------|------|
| `users` | User management & authentication | 32.00 KB |
| `roles` | User roles (Spatie Permission) | 16.00 KB |
| `permissions` | System permissions | 16.00 KB |
| `pages` | Static pages content | 64.00 KB |
| `posts` | News/blog posts | 64.00 KB |
| `categories` | Content categories | 32.00 KB |
| `galleries` | Photo/video galleries | 16.00 KB |
| `announcements` | Site announcements | 16.00 KB |
| `contact_messages` | Contact form submissions | 16.00 KB |
| `settings` | Site configuration | 48.00 KB |
| `village_data` | Village statistics | 16.00 KB |
| `organizational_members` | Staff directory | 32.00 KB |
| `cache` | Application cache | 16.00 KB |
| `sessions` | User sessions | 16.00 KB |
| `jobs` | Queue jobs | 16.00 KB |
| `migrations` | Migration history | 16.00 KB |
| *+ 7 other system tables* | Laravel framework tables | ~112.00 KB |

## 📁 Exported Files

### Available Exports (in `database/exports/`)

1. **Full Database with Data**
   - File: `desa_karangrejo_export_2025_07_25_043926.sql`
   - Size: 33.55 KB
   - Contains: Structure + Sample Data

2. **Structure Only**
   - File: `structure_only.sql`
   - Size: 15.71 KB
   - Contains: Tables structure only (no data)

## 🚀 Installation Methods

### Method 1: Using Laravel Commands (Recommended)

```bash
# Fresh installation with sample data
php artisan app:fresh-install --seed --force

# Fresh installation without sample data
php artisan app:fresh-install --force

# Just run migrations
php artisan migrate --force
```

### Method 2: Using SQL Files

```bash
# Import full database
mysql -u username -p database_name < database/exports/desa_karangrejo_export_2025_07_25_043926.sql

# Import structure only, then run seeders
mysql -u username -p database_name < database/exports/structure_only.sql
php artisan db:seed --force
```

### Method 3: Production Setup (Clean Install)

```bash
# 1. Run migrations
php artisan migrate --force

# 2. Create admin user and basic data
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=SettingsSeeder --force
php artisan db:seed --class=CategorySeeder --force

# 3. Create storage link
php artisan storage:link

# 4. Optimize for production
php artisan optimize
```

## 👥 Default Users (if using seeders)

| Role | Email | Password | Access |
|------|-------|----------|--------|
| Admin | thendeand@gmail.com | password | Full admin access |
| Editor | editor@desa.com | password | Content management |
| User | user@desa.com | password | Basic user access |

⚠️ **Important:** Change these passwords in production!

## 🔧 Database Configuration

### Production Environment (.env)
```env
DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_PORT=3306
DB_DATABASE=desa_karangrejo
DB_USERNAME=your_db_username
DB_PASSWORD=your_secure_password
```

### Required Database Permissions
- CREATE, DROP (for migrations)
- SELECT, INSERT, UPDATE, DELETE (for operations)
- INDEX, ALTER (for schema changes)

## 📋 Pre-configured Data

### Categories
- Berita Desa (Village News)
- Pengumuman (Announcements)
- Kegiatan (Activities)
- Pembangunan (Development)

### Pages
- Profil Desa (Village Profile)
- Visi & Misi (Vision & Mission)
- Sejarah (History)
- Struktur Organisasi (Organizational Structure)

### Settings
- Site name, logo, contact info
- Social media links
- Office hours
- Village statistics

## 🛠️ Custom Artisan Commands

### Database Export
```bash
# Export with data (PHP method)
php artisan db:export-php --with-data

# Export structure only
php artisan db:export-php --file=my_export.sql

# Export using mysqldump (if available)
php artisan db:export --with-data
```

### Fresh Installation
```bash
# Complete fresh install with sample data
php artisan app:fresh-install --seed --force

# Fresh install without data
php artisan app:fresh-install --force
```

## 📊 Database Features

### Content Management
- **Posts**: Full WYSIWYG editor with image upload
- **Pages**: Static content with rich text
- **Categories**: Hierarchical organization
- **Galleries**: Photo and video management

### User Management
- **Roles**: Admin, Editor, User
- **Permissions**: Granular access control
- **Authentication**: Laravel Breeze integration

### Village Data
- **Statistics**: Population, demographics
- **Announcements**: Public notices
- **Contact**: Message handling system
- **Organizational**: Staff directory

### System Features
- **Caching**: Database-driven cache
- **Sessions**: File-based sessions
- **Queues**: Database queue driver
- **Settings**: Dynamic configuration

## 🔒 Security Features

- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection
- Role-based access control

## 📈 Performance Optimizations

- Database indexing on key columns
- Eager loading for relationships
- Query optimization
- Caching strategies
- Optimized migrations

## 🚨 Troubleshooting

### Common Issues

1. **Migration Errors**
   ```bash
   php artisan migrate:reset
   php artisan migrate --force
   ```

2. **Permission Errors**
   ```bash
   php artisan permission:cache-reset
   php artisan optimize:clear
   ```

3. **Storage Issues**
   ```bash
   php artisan storage:link
   chmod -R 755 storage/
   ```

4. **Cache Problems**
   ```bash
   php artisan optimize:clear
   php artisan optimize
   ```

### Database Connection Issues
- Verify database credentials in `.env`
- Check database server status
- Ensure database exists
- Verify user permissions

---

**Last Updated:** July 25, 2025  
**Laravel Version:** 12.21.0  
**Database Version:** MySQL 8.4.3

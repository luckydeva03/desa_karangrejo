# 📊 DATABASE DOCUMENTATION - DESA KARANGREJO

## 🏗️ **DATABASE OVERVIEW**

**Database Name:** `desa_karangrejo`  
**Engine:** MySQL 8.4.3  
**Charset:** utf8mb4_unicode_ci  
**Total Tables:** 27  
**Total Size:** 768.00 KB  
**Export Date:** 2025-07-26  

---

## 📋 **TABLE STRUCTURE**

### **1. Core Application Tables**

#### **users** (32.00 KB)
- User management with authentication
- Supports multiple roles and permissions
- Contains admin and operator users

#### **roles** (32.00 KB) 
- Role-based access control
- Integrates with Spatie Laravel Permission

#### **permissions** (32.00 KB)
- Granular permission system
- Controls access to specific features

#### **model_has_roles** (32.00 KB)
- Many-to-many relationship between users and roles

#### **model_has_permissions** (32.00 KB)
- Many-to-many relationship between users and permissions

#### **role_has_permissions** (32.00 KB)
- Many-to-many relationship between roles and permissions

---

### **2. Content Management Tables**

#### **pages** (64.00 KB)
- Static pages (About, Vision-Mission, etc.)
- Rich content with HTML support
- SEO-friendly with meta fields

#### **posts** (48.00 KB)
- News and articles system
- Category-based organization
- Featured posts support

#### **categories** (32.00 KB)
- Content categorization
- Hierarchical support
- Used by posts and galleries

#### **galleries** (16.00 KB)
- Photo and video galleries
- Media management
- Category-based organization

#### **announcements** (16.00 KB)
- Important village announcements
- Priority and scheduling system

---

### **3. Communication Tables**

#### **contact_messages** (16.00 KB)
- Contact form submissions
- Message management system

---

### **4. Village Data Tables**

#### **village_data** (16.00 KB)
- Statistical data about the village
- Population, demographics, etc.

#### **organizational_members** (32.00 KB)
- Village organization structure
- Leadership and staff information

#### **settings** (48.00 KB)
- Application configuration
- Site settings and preferences

---

### **5. System Tables**

#### **migrations** (16.00 KB)
- Laravel migration tracking
- Database version control

#### **sessions** (48.00 KB)
- User session management
- Database-based sessions

#### **cache** (16.00 KB)
- Application cache storage

#### **cache_locks** (16.00 KB)
- Cache locking mechanism

#### **jobs** (16.00 KB)
- Background job queue

#### **job_batches** (16.00 KB)
- Batch job processing

#### **failed_jobs** (16.00 KB)
- Failed job tracking

#### **password_reset_tokens** (16.00 KB)
- Password reset functionality

---

### **6. Monitoring & Logging Tables**

#### **activity_log** (64.00 KB)
- Comprehensive activity logging
- User action tracking
- Audit trail functionality

#### **telescope_entries** (16.00 KB)
- Laravel Telescope monitoring
- Performance and debugging

#### **telescope_entries_tags** (32.00 KB)
- Telescope entry tagging

#### **telescope_monitoring** (16.00 KB)
- Telescope monitoring data

---

## 🔑 **KEY FEATURES**

### **Security Features**
- ✅ Role-based access control (RBAC)
- ✅ Permission-based authorization
- ✅ Activity logging and audit trail
- ✅ Secure password reset system
- ✅ Session management

### **Content Management**
- ✅ Dynamic page management
- ✅ News/article system with categories
- ✅ Gallery management (photos/videos)
- ✅ Announcement system
- ✅ Contact form handling

### **Village Management**
- ✅ Statistical data management
- ✅ Organizational structure
- ✅ Configurable settings
- ✅ Multi-language support ready

### **Developer Features**
- ✅ Migration system
- ✅ Queue system for background jobs
- ✅ Caching system
- ✅ Monitoring and debugging (Telescope)
- ✅ Comprehensive logging

---

## 📁 **EXPORT FILES GENERATED**

### **Complete Database (Structure + Data)**
- **File:** `desa_karangrejo_complete_fresh_2025-07-26_10-47-23.sql`
- **Size:** 47.24 KB
- **Contains:** All tables with structure and seeded data
- **Use Case:** Full restoration or new deployment

### **Structure Only**
- **File:** `desa_karangrejo_structure_only_2025-07-26_10-47-51.sql`
- **Size:** 18.99 KB
- **Contains:** Table structures without data
- **Use Case:** Fresh installation, then run seeders

---

## 🚀 **DEPLOYMENT INSTRUCTIONS**

### **For New Installation:**
1. Import structure-only SQL file
2. Run Laravel migrations: `php artisan migrate`
3. Run seeders: `php artisan db:seed`

### **For Complete Restoration:**
1. Import complete SQL file
2. Configure `.env` file
3. Run `php artisan key:generate`
4. Run `php artisan storage:link`

### **Default Credentials:**
- **Email:** thendeand@gmail.com
- **Password:** Karangrejo2025
- **Role:** Super Admin

---

## 🔧 **MAINTENANCE**

### **Regular Backups:**
- Use the export scripts provided
- Schedule daily backups for production
- Keep multiple backup versions

### **Performance Optimization:**
- Regular index optimization
- Cache management
- Log rotation

### **Security Updates:**
- Regular dependency updates
- Monitor activity logs
- Review user permissions

---

*Generated on: 2025-07-26 10:47:51*  
*Laravel Version: 12.21.0*  
*PHP Version: 8.4.9*

# Desa Karangrejo Website

Laravel-based website for Desa Karangrejo administration and information portal.

## About

This is a Laravel 12 application built for village administration management, featuring:

- **Content Management System** for village announcements and information
- **Gallery Management** for photos and documentation
- **Village Data Management** for demographic and administrative data
- **User Management** with role-based permissions
- **Contact System** for citizen inquiries
- **Responsive Design** with Tailwind CSS

## Technology Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade Templates, Alpine.js, Tailwind CSS
- **Database**: MySQL
- **Build Tools**: Vite
- **Additional Libraries**: 
  - Spatie Laravel Permission (roles & permissions)
  - Spatie Laravel Activitylog (audit trail)
  - Spatie Laravel Backup
  - Intervention Image (image processing)
  - Laravel Telescope (debugging)
  - DataTables (data display)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd desa-karangrejo
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - Create database

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Create storage link**
   ```bash
   php artisan storage:link
   ```

## Development

Start development servers:

```bash
# Laravel development server
php artisan serve

# Vite development server (in another terminal)
npm run dev
```

## Features

### Admin Panel
- Dashboard with statistics
- Content management (posts, pages, announcements)
- Gallery management
- User management with roles
- Village data management
- Settings configuration

### Public Website
- Homepage with village information
- News and announcements
- Photo gallery
- Village data display
- Contact form

## Security Features

- Role-based access control
- CSRF protection
- XSS protection
- SQL injection prevention
- Activity logging
- Secure file uploads

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support and questions, please contact the development team.

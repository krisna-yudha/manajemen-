# Laravel Management System - Development Environment

## Setup Instructions

### Prerequisites
- XAMPP with PHP 8.2+
- Composer
- Node.js & NPM
- VS Code

### Extension Requirements
This project automatically recommends the following VS Code extensions:
- **Tailwind CSS IntelliSense** - Smart autocomplete for Tailwind classes
- **Laravel Blade formatter** - Format Blade templates
- **Laravel Blade Snippets** - Blade syntax highlighting
- **Laravel Snippets** - Laravel code snippets
- **PHP Intelephense** - PHP language support
- **PHP Debug** - Xdebug debugging support
- **TypeScript** - JavaScript/TypeScript support
- **Prettier** - Code formatter

### Development Tasks
Use VS Code Command Palette (`Ctrl+Shift+P`) and search for "Tasks: Run Task":

1. **Laravel: Serve** - Start development server (http://localhost:8000)
2. **Laravel: Clear Cache** - Clear all Laravel caches
3. **Laravel: Run Migration** - Run database migrations
4. **Laravel: Optimize** - Clear all optimization caches
5. **Build Assets** - Build production assets
6. **Watch Assets** - Watch for asset changes (development)

### Debug Configuration
- Xdebug support is pre-configured
- Use F5 to start debugging
- Set breakpoints in PHP files
- Debug port: 9003

### Code Quality
- CSS validation is disabled for Tailwind CSS compatibility
- Blade templates have proper syntax highlighting
- Auto-formatting on save for supported file types

### Project Structure
- **Manager Role**: User management, system monitoring
- **Gudang Role**: Inventory management, rental approval
- **Member Role**: Item rental, history viewing

### API Documentation
API endpoints are available at `/api/` with Sanctum authentication.
Check `routes/api.php` for complete endpoint list.

### Features
- ✅ User Management (Manager)
- ✅ Inventory Management (Gudang)  
- ✅ Rental System (All roles)
- ✅ User Activation/Deactivation
- ✅ Role-based Access Control
- ✅ API Support with Sanctum
- ✅ Responsive UI with Tailwind CSS
- ✅ Modern Dashboard Design

### Common Commands
```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Clear caches
php artisan optimize:clear

# Build assets
npm run build

# Watch assets (development)
npm run dev
```

### Troubleshooting
- If you see CSS warnings, they are disabled in workspace settings
- Use "Laravel: Clear Cache" task if you encounter caching issues
- Restart PHP-FPM if Xdebug is not working
- Check `.env` file for database configuration

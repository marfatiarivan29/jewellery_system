# Jewellery Management System Setup

## Requirement
- Laragon (PHP 8.2+, MySQL, Composer)
- Node.js (Optional, only if you want to modify assets via Vite, but text is using CDN)

## Steps to Run

1. **Database Setup**:
   - Open Laragon and start All services (Apache/Nginx, MySQL).
   - Open Database Manager (HeidiSQL or phpMyAdmin).
   - Create a new database named `jewellery_system`.

2. **Configuration**:
   - The `.env` file should be at the root. If not, copy `.env.example` to `.env`.
   - Update DB settings in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=jewellery_system
     DB_USERNAME=root
     DB_PASSWORD=
     ```

3. **Install Dependencies** (If not already done):
   - Open specific Terminal in Laragon (Menu -> Tools -> Terminal).
   - Navigate to project folder: `cd C:\Users\PARTH\.gemini\antigravity\scratch\jewellery_system`
   - Run `composer install`
   - Generate key: `php artisan key:generate`

4. **Migrations & Seeding**:
   - Run: `php artisan migrate --seed`
   - This will create tables and default admin user.

5. **Run Application**:
   - If using Laragon's auto-virtual hosts, simply visit `http://jewellery_system.test` (reload Laragon access to update hosts).
   - Or run manual server: `php artisan serve` and visit `http://127.0.0.1:8000`.

## Default Login
- **Email**: admin@example.com
- **Password**: password

## Features
- **Admin Dashboard**: Overview of sales and stock.
- **Inventory**: Manage categories, suppliers, customers, and products.
- **Sales**: Create POS-like sales with dynamic calculation (Price + Making Charges + GST).
- **Settings**: Update daily gold/silver rates.
- **Reports**: View sales history.

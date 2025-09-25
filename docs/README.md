# RideNow - Sistem Rental Motor 🏍️

Selamat datang di dokumentasi lengkap sistem RideNow, platform rental motor yang menghubungkan pemilik motor dengan penyewa.

## 📚 Dokumentasi Role

-   [**Admin Documentation**](./admin.md) - Panduan lengkap untuk Administrator
-   [**Owner Documentation**](./owner.md) - Panduan lengkap untuk Pemilik Motor
-   [**Renter Documentation**](./renter.md) - Panduan lengkap untuk Penyewa Motor

## 🔧 Technical Documentation

-   [**API Documentation**](./api.md) - API endpoints dan integrasi
-   [**Database Schema**](./database.md) - Struktur database dan relationships
-   [**Deployment Guide**](./deployment.md) - Panduan deployment ke production
-   [**Changelog**](./changelog.md) - History perubahan dan update sistem

## 📋 Development Updates

-   [**Dashboard Owner Fix**](./dashboard-owner-fix-complete.md) - Perbaikan dashboard owner dengan dynamic data
-   [**Gmail Rental Implementation**](./gmail-rental-implementation.md) - Implementasi sistem rental menggunakan akun Gmail
-   [**Owner Dashboard Dynamic Fix**](./owner-dashboard-dynamic-fix.md) - Perbaikan dynamic content dashboard owner
-   [**Pagination Enhancement**](./pagination-enhancement.md) - Peningkatan sistem pagination

## 🎯 Overview Sistem

RideNow adalah platform rental motor berbasis web yang memungkinkan:

-   **Pemilik Motor** dapat mendaftarkan motor mereka untuk disewakan
-   **Penyewa** dapat mencari dan menyewa motor sesuai kebutuhan
-   **Admin** dapat mengelola sistem, verifikasi motor, dan mengawasi transaksi

## 🏗️ Arsitektur Sistem

### Roles dan Permissions

1. **Admin** - Mengelola sistem, verifikasi motor, manajemen pengguna
2. **Owner/Pemilik** - Mengelola motor, melihat pendapatan, mengatur ketersediaan
3. **Renter/Penyewa** - Mencari motor, melakukan booking, manajemen sewa

### Fitur Utama

-   ✅ **Multi-role Authentication System**
-   ✅ **Motor Verification Workflow**
-   ✅ **Booking Management System**
-   ✅ **Revenue Sharing System**
-   ✅ **Payment Integration**
-   ✅ **Real-time Dashboard Analytics**

## 🚀 Quick Start

### Default Login Credentials

| Role   | Email              | Password    |
| ------ | ------------------ | ----------- |
| Admin  | admin@ridenow.com  | password123 |
| Owner  | owner@ridenow.com  | password123 |
| Renter | renter@ridenow.com | password123 |

### URL Access

-   **Application URL**: http://127.0.0.1:8000
-   **Admin Panel**: http://127.0.0.1:8000/admin/dashboard
-   **Owner Panel**: http://127.0.0.1:8000/owner/dashboard
-   **Renter Panel**: http://127.0.0.1:8000/renter/dashboard

## 📋 System Requirements

-   PHP 8.4+
-   Laravel 12.30.1
-   MySQL/SQLite Database
-   Node.js & NPM (untuk frontend assets)

## 🛠️ Installation

```bash
# Clone repository
git clone <repository-url>

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start application
php artisan serve
```

## 📊 Database Schema

### Core Tables

-   `users` - User accounts dengan role-based access
-   `motors` - Motor listings dengan status verifikasi
-   `penyewaans` - Booking/rental records
-   `transaksis` - Transaction records
-   `bagi_hasils` - Revenue sharing calculations
-   `tarif_rentals` - Pricing configurations

## 🔧 Configuration

### Environment Variables

```env
APP_NAME="RideNow"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```

## 📱 Mobile Responsiveness

Sistem ini dirancang untuk dapat diakses dengan baik di:

-   💻 Desktop (1920x1080+)
-   📱 Tablet (768x1024)
-   📱 Mobile (375x667+)

## 🔐 Security Features

-   ✅ Role-based access control
-   ✅ CSRF protection
-   ✅ Password hashing
-   ✅ Input validation & sanitization
-   ✅ Authorization middleware

## 📈 Analytics & Reporting

-   Dashboard analytics untuk semua roles
-   Revenue tracking dan sharing calculations
-   Motor performance metrics
-   Booking trend analysis

## 🤝 Support

Untuk bantuan teknis dan pertanyaan:

-   📧 Email: support@ridenow.com
-   📱 WhatsApp: +62-xxx-xxxx-xxxx
-   🌐 Website: https://ridenow.com

---

**Last Updated**: September 25, 2025  
**Version**: 1.2.0  
**Documentation Created By**: RideNow Development Team

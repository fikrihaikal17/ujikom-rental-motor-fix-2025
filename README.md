# Laravel 12 Ujikom 2025 - SMKN 1 Ciamis

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-cyan.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

> **Project Ujian Kompetensi Keahlian 2025**  
> Sistem Rental Motor - Full Stack Web Application dengan Laravel Framework

---

## 👤 Data Siswa

<div align="center">

| **Biodata**               | **Keterangan**                     |
| ------------------------- | ---------------------------------- |
| **Nama Lengkap**          | Muhammad Fikri Haikal              |
| **NIS**                   | 232410560                          |
| **NISN**                  | 0084673783                         |
| **Tempat, Tanggal Lahir** | Nusa Tenggara Timur, 17 Maret 2008 |
| **Kelas**                 | XII PPLG                           |
| **Sekolah**               | SMKN 1 Ciamis                      |
| **Tahun Ujikom**          | 2025                               |

</div>

## 🏫 Informasi Ujikom

-   **📚 Mata Pelajaran**: Junior Developer
-   **🎯 Kompetensi Keahlian**: Pengembangan Perangkat Lunak dan Gim (PPLG)
-   **📅 Periode Ujikom**: 2025
-   **💻 Project Type**: Full-Stack Web Application Development
-   **🌐 Framework**: Laravel 12 + TailwindCSS

---

## 🚀 About RideNow - Sistem Rental Motor

**RideNow** adalah platform rental motor berbasis web yang menghubungkan pemilik motor dengan penyewa. Sistem ini dibangun menggunakan Laravel 12 dengan fitur-fitur modern dan user experience yang optimal.

### 🎯 Tujuan Aplikasi

-   Memudahkan pemilik motor untuk menyewakan kendaraan mereka
-   Memberikan platform pencarian motor yang mudah bagi penyewa
-   Menyediakan sistem manajemen lengkap untuk admin
-   Mengotomatisasi proses booking dan pembayaran rental motor

---

## 🚀 Tech Stack & Features

### 🔧 Backend Stack

-   **Laravel 12** - Modern PHP framework dengan fitur terbaru
-   **MySQL 8.0+** - Relational database dengan Eloquent ORM
-   **PHP 8.2+** - Server-side scripting dengan type declarations
-   **DomPDF** - PDF generation untuk laporan dan export

### 🎯 Frontend Stack

-   **TailwindCSS 4.x** - Utility-first CSS framework untuk styling modern
-   **Alpine.js 3.x** - Lightweight JavaScript framework
-   **Vite** - Lightning-fast frontend build tool dan dev server
-   **Axios** - HTTP client untuk AJAX requests

### 🧪 Development Tools

-   **PHPUnit 11.5+** - Unit testing framework untuk backend
-   **Laravel Pint** - Code style fixer
-   **Laravel Sail** - Docker-based development environment
-   **Composer** - PHP dependency management

### ✨ Key Features

#### 🔐 Multi-Role Authentication System

-   **Admin** - Sistem verifikasi motor, manajemen pengguna, analytics
-   **Owner/Pemilik Motor** - Pendaftaran motor, pengaturan tarif, laporan pendapatan
-   **Renter/Penyewa** - Pencarian motor, booking, riwayat penyewaan

#### 🏍️ Motor Management System

-   ✅ **Pendaftaran Motor** dengan upload foto dan dokumen
-   ✅ **Sistem Verifikasi** oleh admin dengan approval workflow
-   ✅ **Multi-tipe Motor** (100cc, 125cc, 150cc)
-   ✅ **Status Tracking** (Pending, Verified, Available, Rented, Maintenance)
-   ✅ **Real-time Availability Check**

#### 📋 Booking & Rental System

-   ✅ **Advanced Search & Filter** (merk, tipe, harga, lokasi)
-   ✅ **Flexible Rental Duration** (harian, mingguan, bulanan)
-   ✅ **Booking Status Management** (Pending, Confirmed, Active, Completed)
-   ✅ **Auto Calculation** sistem perhitungan harga otomatis
-   ✅ **Return Confirmation** dengan validasi kondisi motor

#### 💰 Revenue Sharing System

-   ✅ **Configurable Revenue Split** antara owner dan platform
-   ✅ **Automated Payment Processing**
-   ✅ **Detailed Financial Reports** dengan export PDF
-   ✅ **Monthly Revenue Analytics** dengan grafik visual
-   ✅ **Payment History Tracking**

#### 📊 Analytics & Reporting

-   ✅ **Real-time Dashboard** dengan statistik lengkap
-   ✅ **Revenue Analytics** dengan chart dan metrics
-   ✅ **Motor Performance Reports**
-   ✅ **User Activity Monitoring**
-   ✅ **Export to PDF** untuk semua laporan

#### 🔒 Security Features

-   ✅ **Role-based Access Control (RBAC)**
-   ✅ **CSRF Protection** pada semua form
-   ✅ **Input Validation & Sanitization**
-   ✅ **Secure File Upload** dengan type validation
-   ✅ **SQL Injection Prevention** via Eloquent ORM

#### 📱 Modern UI/UX

-   ✅ **Responsive Design** - Mobile-first approach
-   ✅ **Dark Mode Support** (optional enhancement)
-   ✅ **Interactive Components** dengan Alpine.js
-   ✅ **Loading States & Feedback** untuk better UX
-   ✅ **Toast Notifications** untuk user feedback

---

## 📋 Requirements

### 🔧 Development Environment (Laragon Recommended!)

-   **Laragon** v6+ - All-in-one development stack
    -   ✅ PHP 8.2+
    -   ✅ MySQL 8.0+
    -   ✅ Apache/Nginx
    -   ✅ Node.js 18+
    -   ✅ Git integration
-   **Alternative**: XAMPP + Node.js manual setup

### 🛠️ VS Code Extensions

-   **PHP Intelephense** - PHP language support
-   **Laravel Extension Pack** - Laravel development tools
-   **Tailwind CSS IntelliSense** - CSS class autocomplete
-   **Alpine.js IntelliSense** - Alpine.js support
-   **GitLens** - Enhanced Git capabilities

### 🌐 Browser Support

-   Chrome 88+ | Firefox 85+ | Safari 14+ | Edge 88+

---

## 🔧 Installation Guide

### 🚀 Quick Setup dengan Laragon (Recommended)

#### Step 1: Install Laragon

1. Download **Laragon Full** dari [laragon.org](https://laragon.org/download/)
2. Install dengan default settings
3. Start Laragon → **Start All** (Apache, MySQL, PHP)
4. Pastikan semua service hijau ✅

#### Step 2: Clone Repository

```bash
# Open Terminal di Laragon
cd C:\laragon\www
git clone https://github.com/fikrihaikal17/rental-motor-v1.git
cd rental-motor-v1
```

#### Step 3: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

#### Step 4: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Step 5: Database Configuration

1. **Buka Laragon** → **Database** → **Open**
2. Create database: `rental_motor_db`
3. Configure database di `.env`:

```env
APP_NAME="RideNow - Rental Motor"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://rental-motor-v1.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rental_motor_db
DB_USERNAME=root
DB_PASSWORD=
```

#### Step 6: Database Migration & Seeding

```bash
# Run migrations
php artisan migrate

# Run seeders (optional - untuk data dummy)
php artisan db:seed

# Link storage untuk file uploads
php artisan storage:link
```

#### Step 7: Build Frontend Assets

```bash
# Development mode (dengan hot reload)
npm run dev

# Production build
npm run build
```

#### Step 8: Start Development Server

```bash
# Laravel development server
php artisan serve

# Atau gunakan Laragon virtual host
# Akses via: http://rental-motor-v1.test
```

**🎉 Open browser**: `http://127.0.0.1:8000` atau `http://rental-motor-v1.test`

---

## 👥 Default Login Credentials

| Role       | Email              | Password    | Dashboard URL       |
| ---------- | ------------------ | ----------- | ------------------- |
| **Admin**  | admin@ridenow.com  | password123 | `/admin/dashboard`  |
| **Owner**  | owner@ridenow.com  | password123 | `/owner/dashboard`  |
| **Renter** | renter@ridenow.com | password123 | `/renter/dashboard` |

---

## 📁 Project Structure

```
rental-motor-v1/
├── app/
│   ├── Enums/                  # Enum classes (BookingStatus, MotorType, etc)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── Owner/          # Owner controllers
│   │   │   └── Renter/         # Renter controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
├── config/                     # Configuration files
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── docs/                       # Documentation
│   ├── admin.md               # Admin documentation
│   ├── owner.md               # Owner documentation
│   ├── renter.md              # Renter documentation
│   └── api.md                 # API documentation
├── public/                     # Public web files
├── resources/
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript files
│   └── views/                 # Blade templates
├── routes/
│   ├── web.php               # Web routes
│   └── console.php           # Console routes
├── storage/                   # File storage
├── tests/                     # Test files
└── vendor/                    # Dependencies
```

---

## 🛠️ Development Workflow

### 🎯 Frontend Development

```bash
# Start development dengan hot reload
npm run dev

# Build untuk production
npm run build

# Watch mode untuk development
npm run dev -- --watch
```

### 🔧 Backend Development

```bash
# Start Laravel development server
php artisan serve

# Run tests
php artisan test

# Database operations
php artisan migrate
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### 📊 Code Quality

```bash
# Fix code style
./vendor/bin/pint

# Run static analysis (jika menggunakan Larastan)
./vendor/bin/phpstan analyse
```

---

## 🌟 Fitur Unggulan Aplikasi

### 📱 User Experience

-   **Responsive Design** yang optimal di semua device
-   **Fast Loading** dengan optimasi aset dan caching
-   **Intuitive Navigation** dengan breadcrumb dan menu yang jelas
-   **Real-time Notifications** untuk status update
-   **Search & Filter** yang powerful dan user-friendly

### 🔐 Security Implementation

-   **Multi-layer Authentication** dengan middleware protection
-   **File Upload Security** dengan type dan size validation
-   **XSS Protection** pada semua user input
-   **HTTPS Ready** untuk production deployment
-   **Rate Limiting** untuk API endpoints

### 📈 Business Intelligence

-   **Advanced Analytics** dengan grafik interaktif
-   **Revenue Forecasting** berdasarkan historical data
-   **Motor Performance Metrics** untuk optimasi bisnis
-   **User Behavior Analysis** untuk improvement insights
-   **Export Capabilities** dalam format PDF dan Excel

### 🚀 Performance Optimization

-   **Database Indexing** untuk query optimization
-   **Eager Loading** untuk mengurangi N+1 queries
-   **File Storage** dengan Laravel Storage abstraction
-   **Caching Strategy** untuk frequently accessed data
-   **Asset Bundling** dengan Vite untuk faster loading

---

## 🎯 Tujuan Project

Project ini dibuat sebagai bagian dari **Ujian Kompetensi Keahlian (Ujikom) 2025** untuk mendemonstrasikan kemampuan dalam:

-   ✅ **Full-Stack Web Development** dengan Laravel Framework
-   ✅ **Database Design & Management** dengan MySQL
-   ✅ **Modern Frontend Development** dengan TailwindCSS & Alpine.js
-   ✅ **RESTful API Development** untuk internal services
-   ✅ **Authentication & Authorization** dengan role-based access control
-   ✅ **File Management** untuk upload dan storage handling
-   ✅ **PDF Generation** untuk reporting dan export features
-   ✅ **Testing Implementation** dengan PHPUnit framework
-   ✅ **Version Control** dengan Git & GitHub workflow
-   ✅ **Problem Solving** dalam real-world business case
-   ✅ **Project Documentation** yang profesional dan lengkap

---

## 📚 Documentation

Dokumentasi lengkap tersedia di folder `docs/`:

-   📖 [**Admin Guide**](docs/admin.md) - Panduan lengkap untuk Administrator
-   📖 [**Owner Guide**](docs/owner.md) - Panduan untuk Pemilik Motor
-   📖 [**Renter Guide**](docs/renter.md) - Panduan untuk Penyewa Motor
-   📖 [**API Documentation**](docs/api.md) - API endpoints dan usage
-   📖 [**Database Schema**](docs/database.md) - ERD dan struktur database
-   📖 [**Deployment Guide**](docs/deployment.md) - Production deployment steps

---

## 🛡️ Testing Strategy

### Unit Tests

-   Model relationships dan business logic
-   Helper functions dan utilities
-   Validation rules dan custom rules

### Feature Tests

-   Authentication flow untuk semua roles
-   Motor registration dan verification process
-   Booking workflow dari pencarian hingga completion
-   Payment processing dan revenue sharing
-   File upload dan management

### Browser Tests (Dusk)

-   End-to-end user journeys
-   JavaScript interactions
-   Form submissions dan validations
-   Dashboard functionality

---

## 🚀 Deployment

### Production Requirements

-   **PHP 8.2+** dengan extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
-   **MySQL 8.0+** atau **PostgreSQL 13+**
-   **Nginx** atau **Apache** dengan URL rewriting
-   **SSL Certificate** untuk HTTPS
-   **Storage** untuk file uploads (local atau cloud)

### Deployment Steps

```bash
# Clone repository
git clone https://github.com/fikrihaikal17/rental-motor-v1.git
cd rental-motor-v1

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --force
php artisan storage:link

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 👨‍💻 Contact & Social Media

**Muhammad Fikri Haikal**

<div align="center">

| **Platform**    | **Link/Info**                                                     |
| --------------- | ----------------------------------------------------------------- |
| 📧 **Email**    | [fikrihaikal170308@gmail.com](mailto:fikrihaikal170308@gmail.com) |
| 🐙 **GitHub**   | [@fikrihaikal17](https://github.com/fikrihaikal17)                |
| 💼 **LinkedIn** | [Muhammad Fikri Haikal](https://linkedin.com/in/fikrihaikal17)    |
| 🏫 **Sekolah**  | SMKN 1 Ciamis                                                     |
| 📚 **Jurusan**  | Pengembangan Perangkat Lunak dan Gim (PPLG)                       |
| 🎓 **Angkatan** | 2022-2025                                                         |

</div>

---

## 🏫 Informasi Sekolah

**SMK Negeri 1 Ciamis**

<div align="center">

-   📍 **Alamat**: Jl. Jenderal Sudirman No.269, Ciamis, Jawa Barat
-   🌐 **Website**: [smkn1ciamis.sch.id](https://smkn1ciamis.sch.id)
-   ⭐ **Kompetensi Keahlian**: Pengembangan Perangkat Lunak dan Gim (PPLG)
-   📅 **Periode Ujikom**: Tahun Pelajaran 2024/2025

</div>

---

## 🏆 Achievement Targets

Melalui project ini, diharapkan dapat menunjukkan pencapaian kompetensi:

-   [x] **Merancang dan membangun aplikasi web** dengan framework modern
-   [x] **Mengimplementasikan multi-role system** dengan authentication yang aman
-   [x] **Menerapkan responsive design** untuk berbagai device
-   [x] **Menggunakan version control** untuk manajemen kode profesional
-   [x] **Dokumentasi project** yang lengkap dan mudah dipahami
-   [x] **Performance optimization** dengan best practices Laravel
-   [x] **Security implementation** sesuai standar industri
-   [x] **Testing strategy** untuk code quality assurance

---

## 🤝 Contributing

Jika Anda ingin berkontribusi pada project ini:

1. Fork repository ini
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📝 Changelog

### Version 1.0.0 (2025-01-XX)

-   ✅ Initial release dengan complete rental motor system
-   ✅ Multi-role authentication (Admin, Owner, Renter)
-   ✅ Motor management dengan verification workflow
-   ✅ Booking system dengan status tracking
-   ✅ Revenue sharing system
-   ✅ Analytics dan reporting features
-   ✅ PDF export capabilities
-   ✅ Responsive design implementation

---

## 📜 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

<div align="center">

**🎓 Laravel 12 Ujikom 2025 - SMKN 1 Ciamis 🎓**

_Dibuat dengan 🔥 oleh Muhammad Fikri Haikal_

**Ready for modern rental motor system!** 🏍️

---

⭐ **Star this repo if you find it helpful!** ⭐

![Rental Motor System](https://img.shields.io/badge/System-Rental%20Motor-success)
![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)
![Laravel](https://img.shields.io/badge/Framework-Laravel%2012-red)
![TailwindCSS](https://img.shields.io/badge/Styling-TailwindCSS-cyan)

</div>

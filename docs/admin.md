# Admin Documentation - RideNow 👨‍💼

## 📋 Table of Contents

1. [Overview](#overview)
2. [Dashboard](#dashboard)
3. [Motor Verification](#motor-verification)
4. [User Management](#user-management)
5. [Revenue Management](#revenue-management)
6. [Reporting & Analytics](#reporting--analytics)
7. [System Settings](#system-settings)
8. [Troubleshooting](#troubleshooting)

## 🎯 Overview

Sebagai **Administrator**, Anda memiliki akses penuh untuk mengelola seluruh sistem RideNow, termasuk verifikasi motor, manajemen pengguna, dan pengawasan transaksi.

### Key Responsibilities

-   ✅ Verifikasi motor yang didaftarkan pemilik
-   ✅ Manajemen pengguna dan role assignment
-   ✅ Monitoring transaksi dan revenue sharing
-   ✅ Konfigurasi tarif dan sistem
-   ✅ Analisis performa platform

### Access Level

-   **Dashboard**: `/admin/dashboard`
-   **Motor Verification**: `/admin/motors`
-   **User Management**: `/admin/users`
-   **Revenue Management**: `/admin/bagi-hasil`
-   **Settings**: `/admin/settings`

---

## 🏠 Dashboard

### Dashboard Overview

Dashboard admin menyediakan ringkasan komprehensif aktivitas platform:

#### Key Metrics

-   **Total Users**: Jumlah seluruh pengguna terdaftar
-   **Total Motors**: Jumlah motor yang terdaftar
-   **Pending Verifications**: Motor yang menunggu verifikasi
-   **Monthly Revenue**: Pendapatan bulan ini
-   **Completed Bookings**: Penyewaan yang telah selesai

#### Recent Activities Widget

-   Pengguna baru yang mendaftar
-   Motor yang baru didaftarkan
-   Booking terbaru
-   Transaksi terbaru

#### Quick Actions

-   Verifikasi motor pending
-   Review user reports
-   Export data
-   System health check

### Navigation Menu

```
📊 Dashboard
👥 Kelola Pengguna
🏍️ Verifikasi Motor
💰 Bagi Hasil
📊 Transaksi
⚙️ Pengaturan
📤 Logout
```

---

## 🔍 Motor Verification

Motor verification adalah salah satu fungsi terpenting admin untuk memastikan kualitas dan keamanan motor di platform.

### Verification Process

#### 1. Pending Motors Tab

-   Melihat daftar motor yang menunggu verifikasi
-   Filter berdasarkan tanggal submission
-   Quick preview informasi motor

#### 2. Motor Detail Review

**Informasi yang perlu diverifikasi:**

-   ✅ **Basic Information**

    -   Merk dan model motor
    -   Tahun pembuatan
    -   Tipe mesin (CC)
    -   Nomor plat
    -   Warna

-   ✅ **Documentation**

    -   Foto motor (multiple angles)
    -   Dokumen kepemilikan (STNK/BPKB)
    -   Kondisi fisik motor

-   ✅ **Owner Information**
    -   Profil pemilik
    -   Contact details
    -   Previous motor listings

#### 3. Verification Actions

**Approve Motor:**

```php
// Set rental rates
- Tarif Harian: Rp 50,000 - 150,000
- Tarif Mingguan: Rp 300,000 - 900,000
- Tarif Bulanan: Rp 1,200,000 - 3,500,000

// Add verification notes (optional)
"Motor dalam kondisi baik, dokumentasi lengkap"
```

**Reject Motor:**

```php
// Rejection reasons
- Dokumentasi tidak lengkap
- Foto motor tidak jelas
- Kondisi motor tidak layak
- STNK/BPKB tidak valid
- Informasi tidak sesuai
```

#### 4. Verification Status

-   **Pending**: Menunggu review admin
-   **Verified**: Sudah diverifikasi dan aktif
-   **Rejected**: Ditolak dengan alasan

### Motor Management Features

#### Search & Filter

-   Filter by verification status
-   Search by merk/model/plat
-   Date range filtering
-   Owner filtering

#### Bulk Actions

-   Bulk verification
-   Export motor data
-   Update pricing
-   Status management

#### Export Options

-   CSV export all motors
-   PDF verification reports
-   Excel financial reports

---

## 👥 User Management

### User Overview

Mengelola seluruh pengguna dalam sistem dengan role-based access control.

#### User Roles

1. **Admin** - Full system access
2. **Pemilik** - Motor management
3. **Penyewa** - Booking management

### User Management Features

#### 1. User Listing

-   View all registered users
-   Filter by role (Admin/Pemilik/Penyewa)
-   Search by name/email/phone
-   Registration date sorting
-   Status indicators

#### 2. User Creation

**Create New User:**

```php
Required Fields:
- Nama Lengkap
- Email (unique)
- Password (min 8 characters)
- Role (admin/pemilik/penyewa)
- Nomor Telepon
- Alamat
```

#### 3. User Profile Management

**User Detail View:**

-   Personal information
-   Registration details
-   Activity history
-   Associated motors (for owners)
-   Booking history (for renters)
-   Revenue statistics

#### 4. User Actions

-   **Edit Profile**: Update user information
-   **Change Role**: Modify user permissions
-   **Suspend Account**: Temporary deactivation
-   **Delete User**: Permanent removal (with confirmation)
-   **Reset Password**: Send password reset link

### User Statistics Dashboard

-   Total registrations per month
-   Role distribution chart
-   Active user metrics
-   Registration trends

---

## 💰 Revenue Management (Bagi Hasil)

### Revenue Sharing System

RideNow menggunakan sistem bagi hasil antara platform, admin, dan pemilik motor.

#### Revenue Distribution

-   **Admin Share**: 10-15% dari total booking
-   **Owner Share**: 85-90% dari total booking
-   **Platform Fee**: Included in admin share

#### Revenue Management Features

#### 1. Revenue Dashboard

-   Total platform revenue
-   Monthly revenue trends
-   Revenue by motor category
-   Top earning owners
-   Pending settlements

#### 2. Revenue Breakdown

**Per Booking Analysis:**

```php
Booking Value: Rp 150,000
- Admin Share (15%): Rp 22,500
- Owner Share (85%): Rp 127,500
- Platform Fee: Included in admin share
```

#### 3. Settlement Management

-   **Pending Settlements**: Booking yang belum dibagi hasilnya
-   **Settled Transactions**: Riwayat pembagian yang sudah selesai
-   **Settlement Calendar**: Jadwal pembayaran otomatis
-   **Manual Settlement**: Override otomatis settlement

#### 4. Financial Reports

-   Monthly revenue reports
-   Owner earning statements
-   Platform performance analytics
-   Tax reporting preparation

### Revenue Analytics

-   Revenue growth charts
-   Seasonal booking trends
-   Motor category performance
-   Geographic revenue distribution

---

## 📊 Reporting & Analytics

### Built-in Reports

#### 1. User Analytics

-   **Registration Trends**: Daily/monthly user growth
-   **User Activity**: Login frequency, engagement metrics
-   **Role Distribution**: Breakdown by user roles
-   **Geographic Distribution**: User locations

#### 2. Motor Analytics

-   **Motor Performance**: Most rented motors
-   **Verification Stats**: Approval vs rejection rates
-   **Category Trends**: Popular motor types
-   **Availability Metrics**: Motor utilization rates

#### 3. Booking Analytics

-   **Booking Trends**: Daily/monthly booking patterns
-   **Duration Analysis**: Average rental periods
-   **Cancellation Rates**: Booking cancellation statistics
-   **Revenue per Booking**: Average transaction values

#### 4. Financial Analytics

-   **Revenue Trends**: Platform earning patterns
-   **Payment Analysis**: Payment method preferences
-   **Settlement Reports**: Revenue sharing summaries
-   **Profitability Metrics**: Platform performance indicators

### Export Capabilities

-   **CSV Export**: All data tables
-   **PDF Reports**: Formatted reports with charts
-   **Excel Sheets**: Detailed financial reports
-   **JSON API**: Programmatic data access

---

## ⚙️ System Settings

### Configuration Management

#### 1. Platform Settings

```php
// General Settings
- Platform Name: "RideNow"
- Contact Email: admin@ridenow.com
- Support Phone: +62-xxx-xxxx-xxxx
- Default Currency: IDR
- Timezone: Asia/Jakarta
```

#### 2. Revenue Settings

```php
// Revenue Sharing Configuration
- Admin Share Percentage: 15%
- Owner Share Percentage: 85%
- Minimum Booking Amount: Rp 25,000
- Settlement Period: Weekly/Monthly
```

#### 3. Motor Verification Settings

```php
// Verification Requirements
- Required Documents: STNK, BPKB, Photo
- Auto-verification: Disabled
- Verification SLA: 24-48 hours
- Photo Quality: High resolution required
```

#### 4. Notification Settings

```php
// Email Notifications
- New User Registration: Enabled
- Motor Verification: Enabled
- Booking Confirmations: Enabled
- Payment Reminders: Enabled

// SMS Notifications
- Booking Updates: Enabled
- Payment Confirmations: Enabled
```

#### 5. Security Settings

```php
// Authentication
- Session Timeout: 120 minutes
- Password Requirements: 8+ characters
- Two-Factor Authentication: Available
- Login Attempt Limits: 5 attempts
```

---

## 🛠️ Troubleshooting

### Common Issues & Solutions

#### 1. Motor Verification Issues

**Problem**: Motor stuck in pending status

```php
Solution:
1. Check if all required documents uploaded
2. Verify image quality and visibility
3. Contact owner for missing information
4. Manual verification if documents valid
```

**Problem**: Unable to set pricing

```php
Solution:
1. Ensure motor is in verified status
2. Check minimum/maximum price limits
3. Validate tariff calculation logic
4. Review pricing permissions
```

#### 2. User Management Issues

**Problem**: Cannot create new admin user

```php
Solution:
1. Check role permissions
2. Verify email uniqueness
3. Validate password requirements
4. Check database constraints
```

**Problem**: User registration failing

```php
Solution:
1. Review validation rules
2. Check email service configuration
3. Verify database connectivity
4. Review server logs
```

#### 3. Revenue Calculation Issues

**Problem**: Incorrect revenue sharing

```php
Solution:
1. Verify percentage configurations
2. Check booking amount calculations
3. Review settlement logic
4. Validate database integrity
```

**Problem**: Missing revenue records

```php
Solution:
1. Check booking completion status
2. Verify payment confirmations
3. Review settlement triggers
4. Manual revenue calculation
```

#### 4. System Performance Issues

**Problem**: Slow dashboard loading

```php
Solution:
1. Optimize database queries
2. Enable query caching
3. Review server resources
4. Implement pagination
```

**Problem**: High server load

```php
Solution:
1. Monitor resource usage
2. Optimize image processing
3. Implement CDN for assets
4. Database query optimization
```

### Debug Tools

#### 1. Laravel Debugging

```bash
# Enable debug mode
APP_DEBUG=true

# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 2. Database Debugging

```bash
# Check database connectivity
php artisan tinker
> DB::connection()->getPdo();

# Run migrations
php artisan migrate:status
php artisan migrate --force
```

#### 3. Queue Management

```bash
# Process background jobs
php artisan queue:work

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

---

## 📞 Support & Maintenance

### Regular Maintenance Tasks

#### Daily Tasks

-   ✅ Review new motor submissions
-   ✅ Monitor booking activities
-   ✅ Check system performance
-   ✅ Review user reports

#### Weekly Tasks

-   ✅ Process revenue settlements
-   ✅ Generate performance reports
-   ✅ Update pricing configurations
-   ✅ System backup verification

#### Monthly Tasks

-   ✅ Comprehensive analytics review
-   ✅ User feedback analysis
-   ✅ Platform optimization
-   ✅ Security audit

### Emergency Contacts

-   **Technical Support**: tech@ridenow.com
-   **Emergency Hotline**: +62-xxx-xxxx-xxxx
-   **Database Admin**: dba@ridenow.com

---

**Admin Documentation v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_

# Database Schema Documentation - RideNow 🗄️

## 📋 Table of Contents

1. [Overview](#overview)
2. [Database Design](#database-design)
3. [Core Tables](#core-tables)
4. [Relationships](#relationships)
5. [Indexes & Performance](#indexes--performance)
6. [Migrations](#migrations)
7. [Seeders](#seeders)
8. [Best Practices](#best-practices)

## 🎯 Overview

RideNow menggunakan database relational (SQLite/MySQL) dengan design yang normalized dan optimized untuk performance. Database dirancang untuk mendukung multi-role system dengan scalability yang baik.

### Database Information

-   **Database Engine**: SQLite (Development) / MySQL (Production)
-   **Framework**: Laravel Eloquent ORM
-   **Migration System**: Laravel Migrations
-   **Seeding**: Laravel Seeders
-   **Version Control**: Git-tracked migrations

### Key Design Principles

-   ✅ **Normalized Structure**: Menghindari data redundancy
-   ✅ **Foreign Key Constraints**: Data integrity enforcement
-   ✅ **Indexed Queries**: Optimized untuk performance
-   ✅ **Soft Deletes**: Data preservation untuk audit trail
-   ✅ **Timestamps**: Created/updated tracking
-   ✅ **Enum Validation**: Type-safe status fields

---

## 🏗️ Database Design

### Entity Relationship Diagram (ERD)

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│    Users    │◄─────►│   Motors    │◄─────►│ TarifRentals│
│             │       │             │       │             │
│ id (PK)     │       │ id (PK)     │       │ id (PK)     │
│ nama        │       │ pemilik_id  │       │ motor_id    │
│ email       │       │ merk        │       │ tarif_harian│
│ role        │       │ nama_motor  │       │ tarif_minggu│
│ password    │       │ status      │       │ tarif_bulan │
│ no_tlpn     │       │ ketersediaan│       └─────────────┘
│ alamat      │       └─────────────┘              │
└─────────────┘              │                     │
       │                     │                     │
       │                     ▼                     │
       │            ┌─────────────┐                │
       │            │ Penyewaans  │◄───────────────┘
       │            │             │
       │            │ id (PK)     │
       │            │ motor_id    │
       │            │ penyewa_id  │
       │            │ tanggal_*   │
       │            │ status      │
       │            │ harga       │
       │            └─────────────┘
       │                     │
       │                     ▼
       │            ┌─────────────┐
       │            │ Transaksis  │
       │            │             │
       │            │ id (PK)     │
       │            │ penyewaan_id│
       │            │ jumlah      │
       │            │ status      │
       │            │ metode      │
       │            └─────────────┘
       │                     │
       │                     ▼
       │            ┌─────────────┐
       │            │  Payments   │
       │            │             │
       │            │ id (PK)     │
       │            │ transaksi_id│
       │            │ amount      │
       │            │ method      │
       │            │ status      │
       │            └─────────────┘
       │                     │
       │                     ▼
       │            ┌─────────────┐
       └───────────►│ BagiHasils  │
                    │             │
                    │ id (PK)     │
                    │ penyewaan_id│
                    │ pemilik_id  │
                    │ admin_share │
                    │ owner_share │
                    │ settled_at  │
                    └─────────────┘
```

---

## 📊 Core Tables

### 1. Users Table

**Purpose**: Central user management dengan role-based access

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    no_tlpn VARCHAR(15) NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pemilik', 'penyewa') NOT NULL,
    alamat TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_role (role),
    INDEX idx_email_role (email, role)
);
```

**Field Descriptions:**

-   `id`: Primary key, auto-increment
-   `nama`: Full name (max 100 chars)
-   `email`: Unique email address for login
-   `no_tlpn`: Phone number (Indonesian format)
-   `role`: User role (admin/pemilik/penyewa)
-   `alamat`: Full address (optional)

**Sample Data:**

```sql
INSERT INTO users VALUES
(1, 'Admin RideNow', 'admin@ridenow.com', '081234567890', NOW(), '$2y$12$hash...', 'admin', 'Jakarta', NULL, NOW(), NOW()),
(2, 'Budi Pemilik Motor', 'owner@ridenow.com', '081234567891', NOW(), '$2y$12$hash...', 'pemilik', 'Bandung', NULL, NOW(), NOW()),
(3, 'Sari Penyewa', 'renter@ridenow.com', '081234567892', NOW(), '$2y$12$hash...', 'penyewa', 'Surabaya', NULL, NOW(), NOW());
```

### 2. Motors Table

**Purpose**: Motor inventory dengan verification status

```sql
CREATE TABLE motors (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    pemilik_id BIGINT NOT NULL,
    merk VARCHAR(50) NOT NULL,
    nama_motor VARCHAR(100) NOT NULL,
    model VARCHAR(50) NULL,
    tahun YEAR NULL,
    tipe_cc ENUM('110cc', '125cc', '150cc', '250cc', '400cc+') NOT NULL,
    no_plat VARCHAR(15) NOT NULL,
    warna VARCHAR(30) NULL,
    deskripsi TEXT NULL,
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    ketersediaan ENUM('tersedia', 'tidak_tersedia') DEFAULT 'tersedia',
    photo VARCHAR(255) NULL,
    dokumen_kepemilikan VARCHAR(255) NULL,
    admin_notes TEXT NULL,
    verified_at TIMESTAMP NULL,
    verified_by BIGINT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (pemilik_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_ketersediaan (ketersediaan),
    INDEX idx_pemilik_status (pemilik_id, status),
    INDEX idx_merk_model (merk, model)
);
```

**Field Descriptions:**

-   `pemilik_id`: Foreign key ke users table (owner)
-   `merk`: Motor brand (Honda, Yamaha, etc.)
-   `nama_motor`: Motor name/model
-   `tipe_cc`: Engine capacity enum
-   `status`: Verification status by admin
-   `ketersediaan`: Current availability status
-   `verified_by`: Admin who verified the motor

### 3. Tarif_Rentals Table

**Purpose**: Pricing configuration per motor

```sql
CREATE TABLE tarif_rentals (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    motor_id BIGINT NOT NULL,
    tarif_harian DECIMAL(10,2) NOT NULL,
    tarif_mingguan DECIMAL(10,2) NOT NULL,
    tarif_bulanan DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (motor_id) REFERENCES motors(id) ON DELETE CASCADE,
    UNIQUE KEY unique_motor (motor_id),
    INDEX idx_active (is_active)
);
```

**Field Descriptions:**

-   `motor_id`: Foreign key to motors table (unique)
-   `tarif_harian`: Daily rental rate
-   `tarif_mingguan`: Weekly rental rate
-   `tarif_bulanan`: Monthly rental rate
-   `is_active`: Rate status (active/inactive)

### 4. Penyewaans Table

**Purpose**: Booking/rental transactions

```sql
CREATE TABLE penyewaans (
    id VARCHAR(50) PRIMARY KEY,
    motor_id BIGINT NOT NULL,
    penyewa_id BIGINT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    tipe_durasi ENUM('harian', 'mingguan', 'bulanan') NOT NULL,
    durasi INT NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    keperluan TEXT NULL,
    catatan TEXT NULL,
    confirmed_at TIMESTAMP NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (motor_id) REFERENCES motors(id) ON DELETE CASCADE,
    FOREIGN KEY (penyewa_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_dates (tanggal_mulai, tanggal_selesai),
    INDEX idx_penyewa_status (penyewa_id, status),
    INDEX idx_motor_status (motor_id, status)
);
```

**Field Descriptions:**

-   `id`: Custom booking ID (e.g., BK-2025092401)
-   `tipe_durasi`: Rental duration type
-   `durasi`: Duration in days/weeks/months
-   `status`: Booking lifecycle status
-   `keperluan`: Purpose of rental
-   Status timestamps track booking lifecycle

### 5. Transaksis Table

**Purpose**: Financial transactions untuk payments

```sql
CREATE TABLE transaksis (
    id VARCHAR(50) PRIMARY KEY,
    penyewaan_id VARCHAR(50) NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    metode_pembayaran ENUM('bank_transfer', 'credit_card', 'e_wallet', 'cash') NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    bukti_pembayaran VARCHAR(255) NULL,
    catatan TEXT NULL,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (penyewaan_id) REFERENCES penyewaans(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_metode (metode_pembayaran),
    INDEX idx_tanggal (created_at)
);
```

### 6. Payments Table

**Purpose**: Detailed payment processing records

```sql
CREATE TABLE payments (
    id VARCHAR(50) PRIMARY KEY,
    transaksi_id VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    external_id VARCHAR(100) NULL,
    payment_url TEXT NULL,
    expires_at TIMESTAMP NULL,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (transaksi_id) REFERENCES transaksis(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_external (external_id),
    INDEX idx_expires (expires_at)
);
```

### 7. Bagi_Hasils Table

**Purpose**: Revenue sharing calculations

```sql
CREATE TABLE bagi_hasils (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    penyewaan_id VARCHAR(50) NOT NULL,
    pemilik_id BIGINT NOT NULL,
    total_pendapatan DECIMAL(10,2) NOT NULL,
    persentase_admin DECIMAL(5,2) DEFAULT 15.00,
    persentase_pemilik DECIMAL(5,2) DEFAULT 85.00,
    bagi_hasil_admin DECIMAL(10,2) NOT NULL,
    bagi_hasil_pemilik DECIMAL(10,2) NOT NULL,
    settled_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (penyewaan_id) REFERENCES penyewaans(id) ON DELETE CASCADE,
    FOREIGN KEY (pemilik_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_pemilik (pemilik_id),
    INDEX idx_settled (settled_at),
    INDEX idx_tanggal (created_at)
);
```

**Field Descriptions:**

-   `total_pendapatan`: Total booking revenue
-   `persentase_admin`: Admin commission percentage (default 15%)
-   `persentase_pemilik`: Owner share percentage (default 85%)
-   `bagi_hasil_admin`: Calculated admin share amount
-   `bagi_hasil_pemilik`: Calculated owner share amount
-   `settled_at`: When revenue was distributed

---

## 🔗 Relationships

### User Relationships

```php
class User extends Model {
    // Owner has many motors
    public function motors(): HasMany {
        return $this->hasMany(Motor::class, 'pemilik_id');
    }

    // Renter has many bookings
    public function penyewaans(): HasMany {
        return $this->hasMany(Penyewaan::class, 'penyewa_id');
    }

    // Owner has many revenue records
    public function bagiHasils(): HasMany {
        return $this->hasMany(BagiHasil::class, 'pemilik_id');
    }
}
```

### Motor Relationships

```php
class Motor extends Model {
    // Motor belongs to owner
    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    // Motor has one pricing
    public function tarifRental(): HasOne {
        return $this->hasOne(TarifRental::class);
    }

    // Motor has many bookings
    public function penyewaans(): HasMany {
        return $this->hasMany(Penyewaan::class);
    }

    // Motor verified by admin
    public function verifiedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
```

### Booking Relationships

```php
class Penyewaan extends Model {
    // Booking belongs to motor
    public function motor(): BelongsTo {
        return $this->belongsTo(Motor::class);
    }

    // Booking belongs to renter
    public function renter(): BelongsTo {
        return $this->belongsTo(User::class, 'penyewa_id');
    }

    // Booking has many transactions
    public function transaksis(): HasMany {
        return $this->hasMany(Transaksi::class, 'penyewaan_id');
    }

    // Booking has revenue sharing
    public function bagiHasil(): HasOne {
        return $this->hasOne(BagiHasil::class, 'penyewaan_id');
    }
}
```

---

## 🚀 Indexes & Performance

### Primary Indexes

```sql
-- Performance critical indexes
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_email_role ON users(email, role);
CREATE INDEX idx_motors_status ON motors(status);
CREATE INDEX idx_motors_pemilik_status ON motors(pemilik_id, status);
CREATE INDEX idx_penyewaans_status ON penyewaans(status);
CREATE INDEX idx_penyewaans_dates ON penyewaans(tanggal_mulai, tanggal_selesai);
CREATE INDEX idx_bagi_hasils_pemilik ON bagi_hasils(pemilik_id);
CREATE INDEX idx_bagi_hasils_settled ON bagi_hasils(settled_at);
```

### Query Optimization Examples

```sql
-- Optimized motor search query
SELECT m.*, tr.tarif_harian, u.nama as owner_name
FROM motors m
JOIN tarif_rentals tr ON m.id = tr.motor_id
JOIN users u ON m.pemilik_id = u.id
WHERE m.status = 'verified'
  AND m.ketersediaan = 'tersedia'
  AND m.merk LIKE '%Honda%'
ORDER BY tr.tarif_harian ASC;

-- Optimized booking history query
SELECT p.*, m.merk, m.nama_motor, u.nama as owner_name
FROM penyewaans p
JOIN motors m ON p.motor_id = m.id
JOIN users u ON m.pemilik_id = u.id
WHERE p.penyewa_id = ?
  AND p.status IN ('completed', 'active')
ORDER BY p.created_at DESC;
```

---

## 🔄 Migrations

### Migration Files Structure

```
database/migrations/
├── 2025_09_22_001024_create_users_table.php
├── 2025_09_22_001419_create_motors_table.php
├── 2025_09_22_001500_create_tarif_rentals_table.php
├── 2025_09_22_001525_create_penyewaans_table.php
├── 2025_09_22_001550_create_transaksis_table.php
├── 2025_09_22_001600_create_payments_table.php
├── 2025_09_22_001625_create_bagi_hasils_table.php
└── 2025_09_22_040341_add_verification_fields_to_motors_table.php
```

### Running Migrations

```bash
# Run all migrations
php artisan migrate

# Check migration status
php artisan migrate:status

# Rollback last batch
php artisan migrate:rollback

# Fresh migration (danger: drops all tables)
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Example Migration File

```php
<?php
// 2025_09_22_001419_create_motors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade');
            $table->string('merk', 50);
            $table->string('nama_motor', 100);
            $table->string('model', 50)->nullable();
            $table->year('tahun')->nullable();
            $table->enum('tipe_cc', ['110cc', '125cc', '150cc', '250cc', '400cc+']);
            $table->string('no_plat', 15);
            $table->string('warna', 30)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('ketersediaan', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->string('photo')->nullable();
            $table->string('dokumen_kepemilikan')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes for performance
            $table->index('status');
            $table->index('ketersediaan');
            $table->index(['pemilik_id', 'status']);
            $table->index(['merk', 'model']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
```

---

## 🌱 Seeders

### Seeder Files Structure

```
database/seeders/
├── DatabaseSeeder.php (main seeder)
├── UserSeeder.php
├── MotorSeeder.php
├── TarifRentalSeeder.php
└── PenyewaanSeeder.php (untuk testing data)
```

### UserSeeder Example

```php
<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'nama' => 'Admin RideNow',
            'email' => 'admin@ridenow.com',
            'no_tlpn' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN,
            'alamat' => 'Jl. Admin No. 1, Jakarta',
            'email_verified_at' => now(),
        ]);

        // Create Owner User
        User::create([
            'nama' => 'Budi Pemilik Motor',
            'email' => 'owner@ridenow.com',
            'no_tlpn' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => UserRole::PEMILIK,
            'alamat' => 'Jl. Pemilik No. 2, Bandung',
            'email_verified_at' => now(),
        ]);

        // Create Renter User
        User::create([
            'nama' => 'Sari Penyewa',
            'email' => 'renter@ridenow.com',
            'no_tlpn' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => UserRole::PENYEWA,
            'alamat' => 'Jl. Penyewa No. 3, Surabaya',
            'email_verified_at' => now(),
        ]);
    }
}
```

### Running Seeders

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

---

## 📋 Best Practices

### Database Design Guidelines

#### 1. Naming Conventions

```php
// Table names: plural, snake_case
users, motors, tarif_rentals, penyewaans

// Column names: snake_case
created_at, updated_at, pemilik_id, no_plat

// Foreign keys: singular_table_name + _id
user_id, motor_id, penyewaan_id

// Indexes: idx_purpose_description
idx_users_role, idx_motors_status
```

#### 2. Data Types Selection

```sql
-- Use appropriate data types
id: BIGINT (for scalability)
nama: VARCHAR(100) (limit based on requirements)
email: VARCHAR(100) UNIQUE
harga: DECIMAL(10,2) (for currency)
status: ENUM (for fixed values)
catatan: TEXT (for unlimited text)
tanggal: DATE (for dates only)
timestamp: TIMESTAMP (for datetime)
```

#### 3. Foreign Key Constraints

```sql
-- Always use foreign key constraints
FOREIGN KEY (pemilik_id) REFERENCES users(id) ON DELETE CASCADE
FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL

-- Use appropriate ON DELETE actions
CASCADE: Delete dependent records
SET NULL: Set FK to NULL when parent deleted
RESTRICT: Prevent deletion if dependencies exist
```

#### 4. Index Strategy

```sql
-- Index frequently queried columns
INDEX idx_status (status)
INDEX idx_email (email)

-- Composite indexes for complex queries
INDEX idx_pemilik_status (pemilik_id, status)
INDEX idx_tanggal_status (created_at, status)

-- Unique indexes for business rules
UNIQUE KEY unique_motor_tarif (motor_id)
UNIQUE KEY unique_email (email)
```

### Performance Optimization

#### 1. Query Optimization

```php
// Use eager loading to prevent N+1 queries
$motors = Motor::with(['owner', 'tarifRental'])->get();

// Use specific columns instead of SELECT *
$motors = Motor::select('id', 'merk', 'nama_motor', 'status')->get();

// Use pagination for large datasets
$motors = Motor::paginate(15);

// Use database-level filtering
$motors = Motor::where('status', 'verified')->get();
```

#### 2. Database Maintenance

```bash
# Analyze table performance
ANALYZE TABLE motors;

# Optimize tables
OPTIMIZE TABLE users, motors, penyewaans;

# Check table sizes
SELECT
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES
WHERE table_schema = 'ridenow'
ORDER BY (data_length + index_length) DESC;
```

#### 3. Backup Strategy

```bash
# Daily backup (production)
mysqldump -u username -p ridenow > backup_$(date +%Y%m%d).sql

# Restore from backup
mysql -u username -p ridenow < backup_20250923.sql

# Laravel backup (using spatie/laravel-backup)
php artisan backup:run
```

---

## 🔧 Database Maintenance

### Regular Maintenance Tasks

#### Daily Tasks

```sql
-- Check table sizes
SELECT table_name,
       ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb
FROM information_schema.TABLES
WHERE table_schema = DATABASE();

-- Monitor slow queries
SHOW PROCESSLIST;
SHOW FULL PROCESSLIST;
```

#### Weekly Tasks

```sql
-- Analyze table statistics
ANALYZE TABLE users, motors, penyewaans, transaksis;

-- Check for unused indexes
SELECT * FROM sys.schema_unused_indexes;

-- Review query performance
SELECT * FROM sys.statements_with_runtimes_in_95th_percentile;
```

#### Monthly Tasks

```sql
-- Optimize tables
OPTIMIZE TABLE users, motors, penyewaans, transaksis, bagi_hasils;

-- Check data integrity
CHECKSUM TABLE users, motors, penyewaans;

-- Review and clean old data
DELETE FROM payments WHERE status = 'expired' AND created_at < DATE_SUB(NOW(), INTERVAL 3 MONTH);
```

---

**Database Schema Documentation v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_

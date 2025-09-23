# Owner Documentation - RideNow 🏍️👨‍💼

## 📋 Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [Dashboard](#dashboard)
4. [Motor Management](#motor-management)
5. [Rental Management](#rental-management)
6. [Revenue & Earnings](#revenue--earnings)
7. [Profile Settings](#profile-settings)
8. [Best Practices](#best-practices)
9. [FAQ](#faq)

## 🎯 Overview

Sebagai **Pemilik Motor** di RideNow, Anda dapat mendaftarkan motor untuk disewakan dan mendapatkan penghasilan pasif. Platform ini menghubungkan Anda dengan penyewa yang membutuhkan kendaraan.

### Key Benefits

-   💰 **Passive Income**: Dapatkan penghasilan dari motor yang jarang digunakan
-   🛡️ **Secure Platform**: Sistem verifikasi dan asuransi yang komprehensif
-   📱 **Easy Management**: Kelola motor dan booking melalui dashboard yang mudah
-   📊 **Real-time Analytics**: Monitor performa dan pendapatan secara real-time
-   🤝 **Professional Support**: Tim support yang siap membantu 24/7

### Access Level

-   **Dashboard**: `/owner/dashboard`
-   **Motor Management**: `/owner/motors`
-   **Rental Management**: `/owner/rentals`
-   **Revenue Tracking**: `/owner/revenue`
-   **Settings**: `/owner/settings`

---

## 🚀 Getting Started

### 1. Registration Process

Untuk menjadi pemilik motor di RideNow:

1. **Daftar Akun**

    - Kunjungi halaman registrasi
    - Pilih role "Pemilik Kendaraan"
    - Isi informasi personal lengkap
    - Verifikasi email

2. **Persiapan Dokumen**

    ```
    📋 Dokumen yang Diperlukan:
    ✅ STNK (Surat Tanda Nomor Kendaraan)
    ✅ BPKB (Buku Pemilik Kendaraan Bermotor)
    ✅ KTP Pemilik
    ✅ Foto Motor (minimal 4 angle)
    ✅ Foto Interior/Detail Motor
    ```

3. **Verifikasi Identitas**
    - Upload dokumen identitas
    - Verifikasi nomor telepon
    - Konfirmasi alamat

### 2. First Motor Registration

```php
Step 1: Basic Information
- Merk Motor (Honda, Yamaha, Suzuki, dll)
- Model/Nama Motor (Vario, PCX, Beat, dll)
- Tahun Pembuatan
- Tipe Mesin (125cc, 150cc, dll)
- Nomor Plat
- Warna

Step 2: Documentation
- Upload foto motor (4-6 foto berbeda angle)
- Upload STNK (scan/foto jelas)
- Upload BPKB (scan/foto jelas)

Step 3: Description
- Deskripsi kondisi motor
- Fitur-fitur khusus
- Riwayat perawatan
- Catatan untuk penyewa
```

---

## 🏠 Dashboard

### Dashboard Overview

Dashboard owner memberikan ringkasan komprehensif tentang performa motor dan earning Anda.

#### Key Metrics Cards

1. **Total Motor Terdaftar**

    - Jumlah motor yang sudah didaftarkan
    - Status verifikasi (Pending/Verified/Rejected)

2. **Motor Terverifikasi**

    - Motor yang sudah lolos verifikasi admin
    - Siap untuk disewakan

3. **Pending Verifikasi**

    - Motor yang masih menunggu verifikasi
    - Estimasi waktu review: 24-48 jam

4. **Booking Aktif**

    - Jumlah penyewaan yang sedang berlangsung
    - Revenue potential dari booking aktif

5. **Total Pendapatan**
    - Akumulasi pendapatan dari semua motor
    - Breakdown per bulan/tahun

#### Recent Activities

-   Motor baru yang didaftarkan
-   Booking requests terbaru
-   Pembayaran yang masuk
-   Status verifikasi updates

#### Quick Actions

```
➕ Daftar Motor Baru
👁️ Lihat Semua Motor
📊 Lihat Laporan Revenue
⚙️ Pengaturan Profil
```

### Navigation Menu

```
🏠 Dashboard
🏍️ Kelola Motor
📅 Kelola Penyewaan
💰 Pendapatan
⚙️ Pengaturan
📤 Logout
```

---

## 🏍️ Motor Management

### Motor Registration Process

#### 1. Add New Motor

**Route**: `/owner/motors/create`

**Required Information:**

```php
Basic Details:
- Merk: Honda, Yamaha, Suzuki, Kawasaki, dll
- Nama Motor: Beat, Vario, PCX, NMAX, dll
- Model: Specific model year variant
- Tahun: 2015-2025
- Tipe CC: 110cc, 125cc, 150cc, 250cc, dll
- Nomor Plat: Format sesuai wilayah
- Warna: Warna dominan motor

Advanced Details:
- Deskripsi: Kondisi dan fitur motor
- Kilometer: Current odometer reading
- Service History: Riwayat perawatan
- Special Features: Fitur tambahan
```

**Required Documents:**

```php
Photos (4-6 images):
1. Front view (tampak depan)
2. Side view (tampak samping)
3. Rear view (tampak belakang)
4. Dashboard/speedometer
5. Engine area (optional)
6. Special features (optional)

Legal Documents:
1. STNK (clear scan/photo)
2. BPKB (clear scan/photo)
3. Insurance document (if any)
```

#### 2. Motor Status Management

**Status Types:**

-   🟡 **Pending**: Menunggu verifikasi admin
-   ✅ **Verified**: Terverifikasi dan aktif
-   ❌ **Rejected**: Ditolak (perlu perbaikan)
-   🔵 **Available**: Tersedia untuk disewa
-   🟠 **Unavailable**: Tidak tersedia sementara

**Actions Available:**

```php
For Verified Motors:
- Edit motor information
- Update availability status
- Set custom pricing (if allowed)
- Upload additional photos
- Update description

For Pending Motors:
- Edit submission
- Add missing documents
- Update information
- Cancel submission

For Rejected Motors:
- View rejection reason
- Fix issues mentioned
- Resubmit for verification
```

#### 3. Motor Listing Management

**Motor Card Information Display:**

```php
Motor Card Shows:
- Motor photo (primary)
- Merk & Model
- Tahun & CC
- Nomor Plat
- Current status
- Rental statistics
- Action buttons
```

**Filtering & Search Options:**

-   Filter by status (All/Pending/Verified/Rejected)
-   Search by merk/model/plat
-   Sort by date added/revenue/bookings

#### 4. Pricing Configuration

Setelah motor diverifikasi admin, owner dapat melihat tarif yang ditetapkan:

```php
Standard Pricing (Set by Admin):
- Tarif Harian: Rp 50,000 - 150,000
- Tarif Mingguan: Rp 300,000 - 900,000
- Tarif Bulanan: Rp 1,200,000 - 3,500,000

Note: Pricing disesuaikan dengan:
- Jenis dan kondisi motor
- Market rate di area Anda
- Demand motor tersebut
```

---

## 📅 Rental Management

### Booking Overview

Kelola semua booking requests dan rental yang sedang berlangsung.

#### 1. Booking Requests

**New Booking Notifications:**

-   Real-time notifications untuk booking baru
-   Detail penyewa dan keperluan sewa
-   Tanggal dan durasi yang diminta
-   Total amount yang akan diterima

**Booking Request Actions:**

```php
Available Actions:
✅ Accept: Terima booking request
❌ Decline: Tolak dengan alasan
💬 Message: Kirim pesan ke penyewa
📞 Contact: Hubungi penyewa langsung
```

#### 2. Active Rentals

**Monitor Ongoing Rentals:**

-   Daftar motor yang sedang disewa
-   Contact information penyewa
-   Tanggal mulai dan selesai
-   Status pembayaran
-   Location tracking (if enabled)

**Rental Management Features:**

```php
During Rental:
- Send messages to renter
- Update rental status
- Report issues/damages
- Extend rental period
- Emergency contact

End of Rental:
- Confirm motor return
- Inspect motor condition
- Report any damages
- Release security deposit
- Rate the renter
```

#### 3. Booking History

**Comprehensive Rental Records:**

-   Complete history semua booking
-   Revenue per booking
-   Renter ratings and feedback
-   Motor performance analytics
-   Seasonal booking patterns

**Export Options:**

-   Download booking reports (PDF/Excel)
-   Tax reporting documents
-   Revenue statements
-   Motor utilization reports

---

## 💰 Revenue & Earnings

### Revenue Sharing Model

RideNow menggunakan sistem revenue sharing yang transparan:

#### Revenue Split

```php
Per Booking Revenue Distribution:
💰 Owner Share: 85% dari total booking
🏢 Platform Fee: 15% dari total booking

Example Calculation:
Booking Value: Rp 150,000 (3 hari)
- Your Earning: Rp 127,500 (85%)
- Platform Fee: Rp 22,500 (15%)
```

#### Payment Schedule

```php
Payment Processing:
- Booking Completion: Revenue calculated
- Settlement Period: Weekly/Monthly
- Payment Method: Bank transfer
- Payment Time: 1-3 business days
- Minimum Payout: Rp 50,000
```

### Revenue Dashboard

#### 1. Earnings Overview

**Monthly Earnings Card:**

-   Current month earnings
-   Comparison dengan bulan sebelumnya
-   Growth percentage
-   Projected earnings

**Year-to-Date Summary:**

-   Total revenue tahun ini
-   Best performing motor
-   Peak earning months
-   Average per booking

#### 2. Revenue Analytics

**Performance Metrics:**

```php
Key Performance Indicators:
- Revenue per Motor per Month
- Booking Utilization Rate
- Average Booking Duration
- Seasonal Performance Trends
- Motor ROI Calculation
```

**Revenue Charts:**

-   Monthly revenue trends
-   Revenue by motor comparison
-   Booking frequency patterns
-   Seasonal demand analysis

#### 3. Motor Performance Analysis

**Individual Motor Stats:**

```php
Per Motor Analytics:
- Total bookings completed
- Total revenue generated
- Average rating from renters
- Utilization percentage
- Maintenance cost vs revenue
```

**Comparison Tools:**

-   Motor-to-motor performance
-   Market rate comparison
-   ROI analysis per motor
-   Optimization recommendations

### Financial Management

#### 1. Payment History

**Transaction Records:**

-   All payment received
-   Payment dates dan amounts
-   Payment method details
-   Tax withholding information
-   Outstanding payments

#### 2. Tax Reporting

**Tax Documentation:**

```php
Available Reports:
- Monthly earning statements
- Annual tax summary
- Expense tracking (maintenance)
- Depreciation calculations
- Business expense records
```

#### 3. Bank Account Management

**Payment Settings:**

-   Bank account information
-   Payment preferences
-   Automatic/manual withdrawals
-   Payment notifications
-   Transaction limits

---

## ⚙️ Profile Settings

### Account Management

#### 1. Personal Information

**Editable Profile Fields:**

```php
Personal Details:
- Nama Lengkap
- Email Address
- Nomor Telepon
- Alamat Lengkap
- Tanggal Lahir
- Jenis Kelamin

Business Information:
- Business Name (if applicable)
- Tax ID Number
- Business Address
- Business Type
```

#### 2. Security Settings

**Account Security:**

```php
Security Options:
- Change Password
- Two-Factor Authentication
- Login Session Management
- Device Management
- Security Questions
- Account Recovery Options
```

#### 3. Notification Preferences

**Communication Settings:**

```php
Email Notifications:
✅ New booking requests
✅ Booking confirmations
✅ Payment notifications
✅ Motor verification updates
✅ Platform updates

SMS Notifications:
✅ Urgent booking updates
✅ Payment confirmations
✅ Emergency notifications

Push Notifications:
✅ Real-time booking alerts
✅ Chat messages
✅ System notifications
```

#### 4. Bank Account Settings

**Payment Information:**

```php
Bank Account Details:
- Bank Name
- Account Holder Name
- Account Number
- Branch Information
- Swift Code (if international)
```

### Verification Status

**Account Verification Levels:**

```php
Verification Checklist:
✅ Email Verified
✅ Phone Number Verified
✅ Identity Document Verified
✅ Bank Account Verified
✅ Address Verified

Benefits of Full Verification:
- Higher booking priority
- Faster payment processing
- Increased renter trust
- Access to premium features
```

---

## 🎯 Best Practices

### Motor Registration Best Practices

#### 1. Photography Tips

```php
High-Quality Photos Guidelines:
📸 Use natural lighting (avoid flash)
📸 Clean the motor before photography
📸 Show all angles (front, side, rear, dashboard)
📸 Highlight special features
📸 Include interior/storage details
📸 Resolution: minimum 1080p
📸 Format: JPG or PNG
```

#### 2. Description Writing

```php
Effective Description Elements:
✅ Honest condition assessment
✅ Maintenance history highlights
✅ Special features and accessories
✅ Fuel efficiency information
✅ Comfort and riding experience
✅ Any recent improvements
✅ Clear usage instructions
```

#### 3. Pricing Strategy

```php
Competitive Pricing Tips:
- Research similar motors in your area
- Consider seasonal demand patterns
- Factor in motor age and condition
- Include value-added services
- Be flexible with long-term rentals
- Offer package deals for regular customers
```

### Customer Service Excellence

#### 1. Response Time

```php
Best Response Practices:
- Respond to booking requests within 2 hours
- Answer renter questions promptly
- Provide clear pickup/return instructions
- Be available during booking period
- Handle issues professionally
```

#### 2. Motor Maintenance

```php
Maintenance Schedule:
Daily: Visual inspection, fuel check
Weekly: Tire pressure, basic cleaning
Monthly: Oil level, brake check, deep cleaning
Quarterly: Professional service, document update
Annually: Insurance renewal, registration update
```

#### 3. Renter Relations

```php
Building Good Relationships:
- Be welcoming and professional
- Provide clear operating instructions
- Share local riding tips and routes
- Be flexible with timing when possible
- Address concerns immediately
- Follow up after rental completion
```

---

## ❓ FAQ

### General Questions

**Q: Berapa lama proses verifikasi motor?**
A: Proses verifikasi biasanya memakan waktu 24-48 jam kerja. Tim admin akan melakukan review dokumen dan foto yang Anda submit.

**Q: Apakah saya bisa mengubah harga sewa motor?**
A: Harga sewa ditetapkan oleh admin berdasarkan market rate dan kondisi motor. Namun, Anda bisa mengajukan request perubahan harga melalui support.

**Q: Bagaimana jika motor saya rusak saat disewa?**
A: RideNow memiliki sistem asuransi dan deposit keamanan. Kerusakan akan ditanggung sesuai dengan ketentuan yang berlaku.

**Q: Kapan saya akan menerima pembayaran?**
A: Pembayaran diproses setiap minggu (untuk weekly settlement) atau setiap bulan (untuk monthly settlement) setelah booking selesai.

### Motor Management

**Q: Berapa banyak motor yang bisa saya daftarkan?**
A: Tidak ada batasan jumlah motor yang bisa didaftarkan, selama semua memenuhi persyaratan platform.

**Q: Bisakah saya menonaktifkan motor sementara?**
A: Ya, Anda bisa mengubah status motor menjadi "Tidak Tersedia" kapan saja melalui dashboard.

**Q: Apa yang terjadi jika motor saya ditolak verifikasi?**
A: Anda akan menerima penjelasan alasan penolakan dan bisa memperbaiki serta mengajukan ulang verifikasi.

### Booking & Revenue

**Q: Bagaimana cara menolak booking request?**
A: Anda bisa menolak booking request melalui dashboard dengan memberikan alasan yang jelas kepada penyewa.

**Q: Apakah ada minimum booking duration?**
A: Minimum booking biasanya 1 hari, namun bisa disesuaikan berdasarkan kebijakan motor tertentu.

**Q: Bagaimana sistem rating bekerja?**
A: Setelah setiap booking, penyewa bisa memberikan rating dan review. Rating tinggi akan meningkatkan visibilitas motor Anda.

### Technical Support

**Q: Bagaimana cara menghubungi customer support?**
A: Anda bisa menghubungi support melalui:

-   Email: support@ridenow.com
-   WhatsApp: +62-xxx-xxxx-xxxx
-   Live chat di platform (tersedia 24/7)

**Q: Apakah ada aplikasi mobile?**
A: Saat ini platform dapat diakses melalui web mobile yang responsif. Aplikasi mobile native sedang dalam development.

---

## 📞 Support & Contact

### Customer Support

-   **Email**: owner-support@ridenow.com
-   **WhatsApp**: +62-xxx-xxxx-xxxx
-   **Live Chat**: Available 24/7 on platform
-   **Response Time**: Average 2 hours during business hours

### Technical Support

-   **Email**: tech-support@ridenow.com
-   **Emergency**: +62-xxx-xxxx-xxxx (for urgent technical issues)

### Business Inquiries

-   **Email**: business@ridenow.com
-   **Partnership**: partnership@ridenow.com

---

**Owner Documentation v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_

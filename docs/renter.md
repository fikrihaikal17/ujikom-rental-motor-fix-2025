# Renter Documentation - RideNow 🏍️🏍️

## 📋 Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [Dashboard](#dashboard)
4. [Finding Motors](#finding-motors)
5. [Booking Process](#booking-process)
6. [Payment & Transactions](#payment--transactions)
7. [Rental Management](#rental-management)
8. [Safety & Guidelines](#safety--guidelines)
9. [FAQ](#faq)

## 🎯 Overview

Sebagai **Penyewa** di RideNow, Anda dapat dengan mudah menemukan dan menyewa motor sesuai kebutuhan perjalanan Anda. Platform ini menyediakan berbagai pilihan motor berkualitas dari pemilik terpercaya.

### Key Benefits

-   🏍️ **Wide Selection**: Berbagai jenis motor dari berbagai merk
-   💰 **Competitive Prices**: Harga sewa yang kompetitif dan transparan
-   🛡️ **Safe & Secure**: Platform aman dengan sistem verifikasi ketat
-   📱 **Easy Booking**: Proses booking yang simpel dan cepat
-   🤝 **24/7 Support**: Dukungan customer service sepanjang waktu
-   📍 **Location Flexible**: Tersedia di berbagai lokasi

### Access Level

-   **Dashboard**: `/renter/dashboard`
-   **Search Motors**: `/renter/motors`
-   **My Bookings**: `/renter/bookings`
-   **Payment History**: `/renter/payments`
-   **Profile Settings**: `/renter/settings`

---

## 🚀 Getting Started

### 1. Registration Process

Untuk mulai menyewa motor di RideNow:

1. **Create Account**

    - Kunjungi halaman registrasi RideNow
    - Pilih role "Penyewa - Saya ingin menyewa motor"
    - Isi informasi personal lengkap
    - Verifikasi email address

2. **Required Information**

    ```php
    Personal Details:
    ✅ Nama Lengkap
    ✅ Email Address (unique)
    ✅ Nomor Telepon (format: 08xxxxxxxxxx)
    ✅ Password (minimum 6 karakter)
    ✅ Alamat Lengkap
    ```

3. **Account Verification**
    ```php
    Verification Steps:
    📧 Email Verification (klik link di email)
    📱 Phone Number Verification (SMS code)
    🆔 Identity Verification (upload KTP)
    🏦 Payment Method Setup (optional)
    ```

### 2. Profile Completion

**Recommended Profile Setup:**

```php
Profile Enhancement:
- Upload profile photo
- Add emergency contact
- Set payment preferences
- Configure notifications
- Complete driving license info
```

### 3. First Booking Preparation

**Before Your First Rental:**

```php
Preparation Checklist:
✅ Valid driving license (SIM)
✅ Payment method ready
✅ Emergency contact information
✅ Understanding of rental terms
✅ Familiarity with motor operation
```

---

## 🏠 Dashboard

### Dashboard Overview

Dashboard penyewa memberikan ringkasan lengkap aktivitas rental dan akses cepat ke fitur utama.

#### Welcome Section

-   Personal greeting dengan nama user
-   Quick summary sewa aktif
-   Action buttons untuk fitur utama

#### Key Statistics Cards

1. **Sewa Aktif**

    - Jumlah motor yang sedang disewa
    - Detail motor dan tanggal return
    - Quick action untuk extend/contact owner

2. **Total Booking**

    - Total booking yang pernah dilakukan
    - Success rate dan completion rate
    - Loyalty status berdasarkan activity

3. **Riwayat Sewa**

    - Jumlah rental yang telah selesai
    - Average rental duration
    - Favorite motor types

4. **Total Pengeluaran**
    - Total amount yang sudah dibayar
    - Monthly spending overview
    - Savings dari loyal customer discounts

#### Quick Actions

```
🔍 Cari Motor Baru
📋 Lihat Booking Saya
💳 Riwayat Pembayaran
⭐ Rate & Review
⚙️ Pengaturan Profil
```

#### Active Rentals Widget

Jika ada sewa aktif, dashboard menampilkan:

```php
Active Rental Card:
- Motor details (merk, model, plat)
- Owner contact information
- Rental period (start - end date)
- Current status badge
- Action buttons (contact, extend, report)
```

#### Recent Activities

-   Booking terbaru dan statusnya
-   Payment confirmations
-   Owner communications
-   System notifications

---

## 🔍 Finding Motors

### Motor Search System

RideNow menyediakan sistem pencarian komprehensif untuk menemukan motor yang sesuai kebutuhan.

#### 1. Search & Filter Interface

**Main Search Bar:**

```php
Search Capabilities:
- Cari berdasarkan merk (Honda, Yamaha, Suzuki, dll)
- Cari berdasarkan model (Beat, Vario, PCX, NMAX, dll)
- Cari berdasarkan nomor plat
- Free text search untuk keywords
```

**Advanced Filters:**

```php
Filter Options:
🏍️ Merk Motor: Honda, Yamaha, Suzuki, Kawasaki, dll
⚙️ Tipe Mesin: 110cc, 125cc, 150cc, 250cc+
💰 Range Harga: Minimum - Maximum per hari
📅 Ketersediaan: Available dates
📍 Lokasi: Area/wilayah motor
⭐ Rating: Minimum rating dari penyewa lain
```

**Sort Options:**

```php
Sorting Preferences:
- Harga terendah ke tertinggi
- Harga tertinggi ke terendah
- Rating tertinggi
- Motor terbaru didaftarkan
- Paling dekat lokasi
- Paling sering disewa
```

#### 2. Motor Listing Display

**Motor Card Information:**

```php
Each Motor Card Shows:
📸 Motor photo (primary image)
🏍️ Merk & Model (Honda Beat, Yamaha NMAX)
📅 Tahun & Tipe CC (2022, 125cc)
📍 Lokasi/Area motor
⭐ Rating & jumlah reviews
👤 Owner information & rating
💰 Harga per hari/minggu/bulan
✅ Availability status
🎯 Quick action buttons
```

**Motor Status Indicators:**

-   ✅ **Available**: Tersedia untuk disewa
-   🔄 **Booked**: Sedang disewa orang lain
-   ⚠️ **Maintenance**: Sedang dalam perawatan
-   ❌ **Unavailable**: Tidak tersedia sementara

#### 3. Motor Categories

**Popular Categories:**

```php
Motor Types Available:
🛵 Matic/Automatic (Beat, Vario, PCX)
🏍️ Manual/Bebek (Supra, Blade, Revo)
🚀 Sport (CBR, R15, Ninja)
🛴 Listrik (Gesits, Selis, Volta)
🏔️ Adventure (CRF, KLX, Versys)
```

**Special Collections:**

-   ⭐ Premium Motors
-   💰 Budget Friendly
-   🆕 Latest Models
-   🔥 Most Popular
-   📍 Near You

---

## 📅 Booking Process

### Step-by-Step Booking Guide

#### 1. Motor Selection & Details

**Motor Detail Page includes:**

```php
Comprehensive Motor Information:
📸 Photo gallery (multiple angles)
🏍️ Specifications (merk, model, tahun, CC)
📋 Features & accessories
💰 Pricing structure (harian/mingguan/bulanan)
👤 Owner profile & rating
⭐ Previous renter reviews
📍 Pickup location details
📞 Contact information
```

**Pricing Information:**

```php
Transparent Pricing Display:
- Tarif Harian: Base daily rate
- Tarif Mingguan: Weekly rate (often discounted)
- Tarif Bulanan: Monthly rate (best value)
- Additional fees (if any)
- Security deposit requirement
```

#### 2. Booking Form

**Required Booking Information:**

```php
Booking Details Form:
📅 Tanggal Mulai: Start date (tidak boleh hari ini atau masa lalu)
📅 Tanggal Selesai: End date (setelah tanggal mulai)
⏰ Jam Pickup: Preferred pickup time
⏰ Jam Return: Preferred return time
📝 Keperluan: Purpose of rental (work, travel, dll)
📍 Pickup Location: Alamat pickup (if different)
💬 Catatan: Special requests atau instructions
```

**Duration Type Selection:**

```php
Rental Duration Options:
📅 Harian: Per hari (minimum 1 hari)
📆 Mingguan: Per minggu (7 hari)
📅 Bulanan: Per bulan (30 hari)

Auto-calculation berdasarkan:
- Tanggal mulai dan selesai
- Best rate untuk duration tersebut
```

#### 3. Booking Confirmation

**Real-time Price Calculation:**

```php
Price Breakdown Display:
Base Rate: Rp XXX × X hari = Rp XXX
Platform Fee: Rp XXX (sudah termasuk)
Security Deposit: Rp XXX (dikembalikan)
----------------------------------------
Total Amount: Rp XXX

Duration: X hari (tanggal mulai - selesai)
```

**Booking Summary:**

-   Motor details confirmation
-   Rental period summary
-   Total cost breakdown
-   Owner contact info
-   Terms & conditions acceptance

#### 4. Booking Submission

**After Submit:**

```php
Booking Process Flow:
1. Booking request dikirim ke owner
2. Notification sent ke owner (real-time)
3. Booking status: "Pending Confirmation"
4. Owner review & decision (24 jam)
5. Confirmation atau rejection notification
6. Jika approved: Payment instruction
7. Payment completion → Booking confirmed
```

---

## 💳 Payment & Transactions

### Payment Methods

RideNow mendukung berbagai metode pembayaran untuk kemudahan transaksi.

#### Available Payment Options

```php
Supported Payment Methods:
🏦 Bank Transfer (Manual confirmation)
💳 Credit/Debit Card (Visa, Mastercard)
📱 E-Wallet (OVO, GoPay, DANA, LinkAja)
🏪 Convenience Store (Alfamart, Indomaret)
💰 QRIS (Quick Response Code Indonesian Standard)
```

#### Payment Process

**Step 1: Payment Instruction**
Setelah booking dikonfirmasi owner:

```php
Payment Details Provided:
- Total amount yang harus dibayar
- Payment method options
- Payment deadline (biasanya 24 jam)
- Virtual account number (untuk bank transfer)
- Payment reference code
```

**Step 2: Payment Completion**

```php
Payment Confirmation Process:
1. Complete payment via chosen method
2. Upload payment proof (if manual transfer)
3. System verify payment (auto/manual)
4. Booking status update ke "Confirmed"
5. Owner & renter notification
6. Pickup instructions shared
```

#### Security Deposit System

```php
Security Deposit Information:
Amount: Biasanya 20-30% dari rental fee
Purpose: Cover potential damages atau late return
Hold Period: During rental + 24-48 jam setelah return
Return: Auto-refund jika tidak ada issue
Deduction: Only jika ada kerusakan atau keterlambatan
```

### Transaction Management

#### Payment History

**Transaction Records Include:**

```php
Comprehensive Transaction Log:
- Booking reference number
- Motor details & owner info
- Rental period & duration
- Amount breakdown (rental + fees)
- Payment method & timestamp
- Transaction status
- Receipt & invoice download
```

#### Invoice & Receipts

```php
Available Documents:
📄 Booking Confirmation (PDF)
🧾 Payment Receipt (PDF)
📊 Expense Report (Excel) - monthly
📋 Tax Invoice (for business users)
```

---

## 🏍️ Rental Management

### Pre-Rental Preparation

#### Before Pickup

**Preparation Checklist:**

```php
Essential Items to Bring:
🆔 Valid ID (KTP/SIM)
📄 Booking confirmation
💳 Payment proof
📱 Emergency contact numbers
🧥 Safety gear (helmet - recommended)
```

**Communication with Owner:**

```php
Pre-Pickup Communication:
- Confirm pickup time & location
- Ask about motor-specific instructions
- Clarify any special requirements
- Exchange contact numbers
- Understand return procedures
```

#### Motor Inspection

**Pickup Inspection Process:**

```php
Joint Inspection Checklist:
✅ Physical condition (scratches, dents)
✅ Engine performance & sound
✅ Tire condition & pressure
✅ Brake functionality
✅ Lights & electrical systems
✅ Fuel level at pickup
✅ Accessories & tools included
✅ Document photos of current condition
```

### During Rental Period

#### Rental Guidelines

**Responsible Usage:**

```php
Rental Best Practices:
🛡️ Always wear helmet & safety gear
⛽ Monitor fuel level regularly
🛠️ Report any mechanical issues immediately
📱 Keep owner contact readily available
🚦 Follow all traffic rules & regulations
🔒 Secure parking when not in use
📷 Document any incidents immediately
```

**Emergency Procedures:**

```php
In Case of Emergency:
1. Ensure personal safety first
2. Contact owner immediately
3. Contact RideNow support if needed
4. Document situation (photos, videos)
5. File police report if accident occurs
6. Do not admit fault or make agreements
7. Follow insurance claim procedures
```

#### Maintenance During Rental

```php
Basic Maintenance Responsibilities:
- Keep motor clean & presentable
- Check oil level (if rental > 7 days)
- Monitor tire pressure
- Report unusual sounds atau performance
- Refuel as needed (return dengan fuel level agreed)
```

### Return Process

#### Pre-Return Preparation

```php
Before Returning Motor:
🧽 Clean the motor (remove dirt, dust)
⛽ Fuel to agreed level (usually same as pickup)
🔍 Check for any new damage
📸 Take photos of motor condition
📱 Contact owner to arrange return time
📍 Confirm return location
```

#### Return Inspection

**Joint Return Inspection:**

```php
Return Inspection Checklist:
✅ Compare condition vs pickup photos
✅ Check for new damages atau scratches
✅ Verify fuel level
✅ Test all functions (lights, brakes, etc)
✅ Return keys & accessories
✅ Complete inspection form
✅ Process security deposit return
```

#### Post-Return Activities

```php
After Successful Return:
- Receive security deposit refund
- Rate & review the owner
- Rate & review the motor
- Share feedback about experience
- Receive final receipt
- Check for any follow-up needed
```

---

## 🛡️ Safety & Guidelines

### Safety Requirements

#### Driver Prerequisites

```php
Mandatory Requirements:
🆔 Valid Indonesian SIM (Driving License)
👤 Age minimum 18 tahun
🧠 Understanding basic motor operation
🛡️ Commitment to safety practices
📖 Knowledge of traffic rules
```

#### Safety Equipment

```php
Essential Safety Gear:
⛑️ Helmet (provided atau bring your own)
🦺 Reflective vest (untuk night riding)
🧤 Gloves (recommended)
👕 Long pants & closed shoes
🕶️ Eye protection
📱 Phone dengan emergency contacts
```

### Traffic & Legal Guidelines

#### Traffic Rules Compliance

```php
Must Follow Rules:
🚦 Obey all traffic signals & signs
🛣️ Use designated motorcycle lanes
🏃 No riding against traffic flow
📱 No phone usage while riding
🍺 Absolutely no alcohol atau drugs
👥 Maximum passengers as per motor capacity
⚡ Speed limits compliance
```

#### Legal Responsibilities

```php
Renter Legal Obligations:
- Valid license required at all times
- Comply with local traffic regulations
- Report accidents to police
- Responsible for traffic violations
- Insurance cooperation when needed
- Return motor dalam agreed condition
```

### Insurance & Protection

#### Coverage Information

```php
Insurance Coverage Includes:
🛡️ Third-party liability
🏥 Medical expenses (basic)
🔧 Mechanical breakdown assistance
🚨 Emergency roadside support
🔒 Theft protection (partial)

Not Covered:
❌ Reckless atau illegal usage
❌ Racing atau extreme sports
❌ Unlicensed drivers
❌ Intentional damage
❌ Personal belongings theft
```

---

## ❓ FAQ

### General Questions

**Q: Berapa usia minimum untuk menyewa motor?**
A: Usia minimum adalah 18 tahun dengan SIM yang masih berlaku.

**Q: Apakah saya perlu deposit keamanan?**
A: Ya, setiap booking memerlukan security deposit yang akan dikembalikan setelah motor dikembalikan dalam kondisi baik.

**Q: Bagaimana jika motor rusak saat saya sewa?**
A: Segera hubungi owner dan RideNow support. Kerusakan akan ditangani sesuai dengan polis asuransi yang berlaku.

**Q: Bisakah saya membatalkan booking?**
A: Ya, namun kebijakan pembatalan berbeda tergantung timing. Pembatalan 24 jam sebelum pickup biasanya tanpa penalty.

### Booking & Payment

**Q: Berapa lama owner merespon booking request?**
A: Owner diharapkan merespon dalam 24 jam. Jika tidak ada respon, booking otomatis dibatalkan.

**Q: Metode pembayaran apa saja yang tersedia?**
A: Kami menerima bank transfer, kartu kredit/debit, e-wallet (OVO, GoPay, DANA), dan pembayaran di convenience store.

**Q: Kapan saya harus melakukan pembayaran?**
A: Pembayaran harus diselesaikan dalam 24 jam setelah booking dikonfirmasi owner.

**Q: Bisakah saya mengubah tanggal booking setelah konfirmasi?**
A: Perubahan tanggal bisa dilakukan dengan persetujuan owner dan mungkin ada biaya tambahan.

### Motor & Rental

**Q: Bagaimana cara memilih motor yang tepat?**
A: Pertimbangkan kebutuhan (jarak, durasi, jumlah penumpang), budget, dan rating motor/owner.

**Q: Apakah motor sudah termasuk BBM?**
A: Biasanya motor diserahkan dengan BBM tertentu dan harus dikembalikan dengan level yang sama.

**Q: Bisakah saya memperpanjang masa sewa?**
A: Ya, extension bisa dilakukan dengan persetujuan owner dan pembayaran tambahan.

**Q: Apa yang harus saya lakukan jika motor mogok?**
A: Hubungi owner segera. Jika perlu, RideNow menyediakan roadside assistance.

### Safety & Legal

**Q: Apakah saya perlu asuransi tambahan?**
A: Motor sudah tercover asuransi dasar. Asuransi tambahan bisa dibeli jika dibutuhkan.

**Q: Siapa yang bertanggung jawab jika ada tilang?**
A: Penyewa bertanggung jawab atas tilang yang diterima selama masa sewa.

**Q: Bagaimana jika terjadi kecelakaan?**
A: Utamakan keselamatan, hubungi polisi jika perlu, lalu hubungi owner dan RideNow support.

### Technical Support

**Q: Bagaimana cara menghubungi customer support?**
A: Hubungi kami melalui:

-   Live chat di platform (24/7)
-   WhatsApp: +62-xxx-xxxx-xxxx
-   Email: support@ridenow.com

**Q: Apakah ada aplikasi mobile?**
A: Saat ini tersedia web mobile yang responsif. Aplikasi native sedang dalam pengembangan.

---

## 📞 Support & Contact

### Customer Support

-   **Live Chat**: Available 24/7 pada platform
-   **WhatsApp**: +62-xxx-xxxx-xxxx
-   **Email**: renter-support@ridenow.com
-   **Response Time**: Average 15 minutes during business hours

### Emergency Support

-   **Emergency Hotline**: +62-xxx-xxxx-xxxx (tersedia 24/7)
-   **Roadside Assistance**: Available dalam aplikasi
-   **Medical Emergency**: Call 118 (Ambulance) atau 119 (Emergency)

### Technical Support

-   **Email**: tech-support@ridenow.com
-   **Platform Issues**: Report melalui support chat
-   **Payment Issues**: payment-support@ridenow.com

### Feedback & Suggestions

-   **Feedback Email**: feedback@ridenow.com
-   **Feature Requests**: features@ridenow.com
-   **Partnership Inquiries**: partnership@ridenow.com

---

## 🏆 Loyalty Program

### RideNow Loyalty Benefits

```php
Loyalty Tiers:
🥉 Bronze (0-5 bookings): Basic support
🥈 Silver (6-15 bookings): 5% discount, priority support
🥇 Gold (16-30 bookings): 10% discount, free insurance upgrade
💎 Platinum (31+ bookings): 15% discount, premium support, exclusive motors

Benefits Include:
- Progressive discounts
- Priority booking access
- Exclusive motor access
- Enhanced customer support
- Special promotions
- Birthday rewards
```

---

**Renter Documentation v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_

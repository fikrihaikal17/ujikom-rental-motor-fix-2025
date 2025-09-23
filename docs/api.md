# API Documentation - RideNow 🔌

## 📋 Table of Contents

1. [Overview](#overview)
2. [Authentication](#authentication)
3. [User Management APIs](#user-management-apis)
4. [Motor Management APIs](#motor-management-apis)
5. [Booking APIs](#booking-apis)
6. [Payment APIs](#payment-apis)
7. [Revenue APIs](#revenue-apis)
8. [Error Handling](#error-handling)
9. [Rate Limiting](#rate-limiting)

## 🎯 Overview

RideNow provides RESTful APIs untuk integrasi dengan sistem eksternal dan mobile applications. API ini mendukung semua core functionalities platform.

### Base URL

```
Production: https://api.ridenow.com/v1
Development: http://127.0.0.1:8000/api/v1
```

### API Principles

-   RESTful design patterns
-   JSON request/response format
-   HTTP status codes untuk response status
-   Bearer token authentication
-   Comprehensive error messages
-   Rate limiting untuk API protection

---

## 🔐 Authentication

### Authentication Methods

#### 1. Bearer Token Authentication

```http
Authorization: Bearer {access_token}
Content-Type: application/json
Accept: application/json
```

#### 2. Login API

```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "nama": "John Doe",
            "email": "user@example.com",
            "role": "penyewa"
        },
        "token": "1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "expires_at": "2025-10-23T12:00:00Z"
    },
    "message": "Login successful"
}
```

#### 3. Register API

```http
POST /api/v1/auth/register
Content-Type: application/json

{
    "nama": "John Doe",
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "no_tlpn": "081234567890",
    "role": "penyewa",
    "alamat": "Jl. Example No. 123"
}
```

#### 4. Logout API

```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

---

## 👥 User Management APIs

### Get Current User

```http
GET /api/v1/user
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "nama": "John Doe",
        "email": "user@example.com",
        "no_tlpn": "081234567890",
        "role": "penyewa",
        "alamat": "Jl. Example No. 123",
        "email_verified_at": "2025-09-23T10:00:00Z",
        "created_at": "2025-09-20T08:00:00Z"
    }
}
```

### Update User Profile

```http
PUT /api/v1/user/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "nama": "John Updated",
    "no_tlpn": "081234567891",
    "alamat": "Jl. New Address No. 456"
}
```

### Change Password

```http
PUT /api/v1/user/password
Authorization: Bearer {token}
Content-Type: application/json

{
    "current_password": "oldpassword",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
}
```

---

## 🏍️ Motor Management APIs

### Get Motors List

```http
GET /api/v1/motors
Authorization: Bearer {token}

Query Parameters:
- page: Page number (default: 1)
- per_page: Items per page (default: 15, max: 100)
- search: Search term (merk, model, plat)
- merk: Filter by brand
- tipe_cc: Filter by engine type
- status: Filter by status (available, verified, pending)
- min_price: Minimum daily price
- max_price: Maximum daily price
- sort: Sort by (price, rating, created_at)
- order: Sort order (asc, desc)
```

**Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "merk": "Honda",
                "nama_motor": "Beat Street",
                "model": "2023",
                "tahun": 2023,
                "tipe_cc": "125cc",
                "no_plat": "B 1234 ABC",
                "warna": "Hitam",
                "status": "verified",
                "ketersediaan": "tersedia",
                "photo": "https://example.com/photos/motor1.jpg",
                "rating": 4.5,
                "total_reviews": 12,
                "owner": {
                    "id": 2,
                    "nama": "Motor Owner",
                    "rating": 4.8
                },
                "tarif_rental": {
                    "tarif_harian": 75000,
                    "tarif_mingguan": 450000,
                    "tarif_bulanan": 1800000
                }
            }
        ],
        "per_page": 15,
        "total": 45,
        "last_page": 3
    }
}
```

### Get Motor Detail

```http
GET /api/v1/motors/{motor_id}
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "merk": "Honda",
        "nama_motor": "Beat Street",
        "model": "2023",
        "tahun": 2023,
        "tipe_cc": "125cc",
        "no_plat": "B 1234 ABC",
        "warna": "Hitam",
        "deskripsi": "Motor dalam kondisi prima, perawatan rutin",
        "status": "verified",
        "ketersediaan": "tersedia",
        "photo": "https://example.com/photos/motor1.jpg",
        "photos": [
            "https://example.com/photos/motor1_1.jpg",
            "https://example.com/photos/motor1_2.jpg"
        ],
        "rating": 4.5,
        "total_reviews": 12,
        "owner": {
            "id": 2,
            "nama": "Motor Owner",
            "no_tlpn": "081234567890",
            "rating": 4.8,
            "total_motors": 3
        },
        "tarif_rental": {
            "tarif_harian": 75000,
            "tarif_mingguan": 450000,
            "tarif_bulanan": 1800000,
            "is_active": true
        },
        "reviews": [
            {
                "id": 1,
                "rating": 5,
                "comment": "Motor sangat bagus dan terawat",
                "renter_name": "Anonymous",
                "created_at": "2025-09-20T10:00:00Z"
            }
        ]
    }
}
```

### Create Motor (Owner Only)

```http
POST /api/v1/motors
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "merk": "Honda",
    "nama_motor": "Beat Street",
    "model": "2023",
    "tahun": 2023,
    "tipe_cc": "125cc",
    "no_plat": "B 1234 ABC",
    "warna": "Hitam",
    "deskripsi": "Motor dalam kondisi prima",
    "photo": (file),
    "dokumen_kepemilikan": (file)
}
```

### Update Motor (Owner Only)

```http
PUT /api/v1/motors/{motor_id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "nama_motor": "Beat Street Updated",
    "deskripsi": "Updated description",
    "ketersediaan": "tidak_tersedia"
}
```

---

## 📅 Booking APIs

### Create Booking

```http
POST /api/v1/bookings
Authorization: Bearer {token}
Content-Type: application/json

{
    "motor_id": 1,
    "tanggal_mulai": "2025-09-25",
    "tanggal_selesai": "2025-09-27",
    "tipe_durasi": "harian",
    "keperluan": "Liburan keluarga",
    "catatan": "Pickup di alamat owner"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": "BK-2025092401",
        "motor_id": 1,
        "penyewa_id": 1,
        "tanggal_mulai": "2025-09-25",
        "tanggal_selesai": "2025-09-27",
        "tipe_durasi": "harian",
        "durasi": 3,
        "harga": 225000,
        "status": "pending",
        "keperluan": "Liburan keluarga",
        "catatan": "Pickup di alamat owner",
        "motor": {
            "id": 1,
            "merk": "Honda",
            "nama_motor": "Beat Street",
            "no_plat": "B 1234 ABC"
        },
        "created_at": "2025-09-24T10:00:00Z"
    },
    "message": "Booking berhasil dibuat. Menunggu konfirmasi owner."
}
```

### Get User Bookings

```http
GET /api/v1/bookings
Authorization: Bearer {token}

Query Parameters:
- status: Filter by status (pending, confirmed, active, completed, cancelled)
- page: Page number
- per_page: Items per page
```

**Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": "BK-2025092401",
                "motor_id": 1,
                "tanggal_mulai": "2025-09-25",
                "tanggal_selesai": "2025-09-27",
                "durasi": 3,
                "harga": 225000,
                "status": "confirmed",
                "motor": {
                    "merk": "Honda",
                    "nama_motor": "Beat Street",
                    "no_plat": "B 1234 ABC",
                    "photo": "https://example.com/photos/motor1.jpg"
                },
                "owner": {
                    "nama": "Motor Owner",
                    "no_tlpn": "081234567890"
                },
                "created_at": "2025-09-24T10:00:00Z"
            }
        ],
        "total": 5
    }
}
```

### Get Booking Detail

```http
GET /api/v1/bookings/{booking_id}
Authorization: Bearer {token}
```

### Update Booking Status (Owner Only)

```http
PUT /api/v1/bookings/{booking_id}/status
Authorization: Bearer {token}
Content-Type: application/json

{
    "status": "confirmed",
    "notes": "Booking dikonfirmasi, silakan lakukan pembayaran"
}
```

### Cancel Booking

```http
DELETE /api/v1/bookings/{booking_id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "reason": "Perubahan rencana"
}
```

---

## 💳 Payment APIs

### Create Payment

```http
POST /api/v1/payments
Authorization: Bearer {token}
Content-Type: application/json

{
    "booking_id": "BK-2025092401",
    "payment_method": "bank_transfer",
    "amount": 225000
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": "PAY-2025092401",
        "booking_id": "BK-2025092401",
        "amount": 225000,
        "payment_method": "bank_transfer",
        "status": "pending",
        "payment_details": {
            "bank_name": "BCA",
            "account_number": "1234567890",
            "account_name": "RideNow Indonesia",
            "payment_code": "PAY2025092401"
        },
        "expires_at": "2025-09-25T10:00:00Z",
        "created_at": "2025-09-24T10:00:00Z"
    },
    "message": "Payment instruction created successfully"
}
```

### Confirm Payment

```http
POST /api/v1/payments/{payment_id}/confirm
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "payment_proof": (file),
    "notes": "Transfer completed via mobile banking"
}
```

### Get Payment History

```http
GET /api/v1/payments
Authorization: Bearer {token}

Query Parameters:
- status: Filter by status (pending, completed, failed)
- booking_id: Filter by specific booking
- page: Page number
```

---

## 💰 Revenue APIs (Owner Only)

### Get Revenue Summary

```http
GET /api/v1/owner/revenue/summary
Authorization: Bearer {token}

Query Parameters:
- period: monthly, yearly (default: monthly)
- year: Specific year (default: current year)
- month: Specific month (required if period=monthly)
```

**Response:**

```json
{
    "success": true,
    "data": {
        "period": "2025-09",
        "total_revenue": 2750000,
        "total_bookings": 12,
        "completed_bookings": 10,
        "average_booking_value": 275000,
        "owner_share": 2337500,
        "platform_fee": 412500,
        "motors_performance": [
            {
                "motor_id": 1,
                "merk": "Honda",
                "nama_motor": "Beat Street",
                "bookings": 5,
                "revenue": 1250000,
                "utilization_rate": 67
            }
        ]
    }
}
```

### Get Revenue Details

```http
GET /api/v1/owner/revenue/details
Authorization: Bearer {token}

Query Parameters:
- motor_id: Filter by specific motor
- start_date: Start date (YYYY-MM-DD)
- end_date: End date (YYYY-MM-DD)
- page: Page number
```

---

## ⚠️ Error Handling

### Standard Error Response Format

```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "The given data was invalid.",
        "details": {
            "email": ["The email field is required."],
            "password": ["The password must be at least 8 characters."]
        }
    },
    "timestamp": "2025-09-24T10:00:00Z"
}
```

### HTTP Status Codes

```
200 OK - Request successful
201 Created - Resource created successfully
400 Bad Request - Invalid request data
401 Unauthorized - Authentication required
403 Forbidden - Access denied
404 Not Found - Resource not found
422 Unprocessable Entity - Validation error
429 Too Many Requests - Rate limit exceeded
500 Internal Server Error - Server error
```

### Error Codes

```
AUTH_FAILED - Authentication failed
INVALID_TOKEN - Invalid or expired token
VALIDATION_ERROR - Request validation failed
RESOURCE_NOT_FOUND - Requested resource not found
PERMISSION_DENIED - Insufficient permissions
BUSINESS_RULE_VIOLATION - Business logic error
EXTERNAL_SERVICE_ERROR - Third-party service error
RATE_LIMIT_EXCEEDED - Too many requests
```

---

## 🚦 Rate Limiting

### Rate Limit Rules

```
General API: 100 requests per minute per IP
Authentication: 10 requests per minute per IP
File Upload: 5 requests per minute per user
Search API: 60 requests per minute per user
```

### Rate Limit Headers

```http
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1695456123
```

### Rate Limit Exceeded Response

```json
{
    "success": false,
    "error": {
        "code": "RATE_LIMIT_EXCEEDED",
        "message": "Too many requests. Please try again later.",
        "retry_after": 60
    }
}
```

---

## 📚 SDK & Libraries

### PHP SDK Example

```php
use RideNow\SDK\Client;

$client = new Client([
    'base_uri' => 'https://api.ridenow.com/v1',
    'token' => 'your-access-token'
]);

// Get motors
$motors = $client->motors()->list([
    'merk' => 'Honda',
    'status' => 'available'
]);

// Create booking
$booking = $client->bookings()->create([
    'motor_id' => 1,
    'tanggal_mulai' => '2025-09-25',
    'tanggal_selesai' => '2025-09-27'
]);
```

### JavaScript SDK Example

```javascript
import RideNowSDK from "@ridenow/sdk";

const client = new RideNowSDK({
    baseURL: "https://api.ridenow.com/v1",
    token: "your-access-token",
});

// Get motors
const motors = await client.motors.list({
    merk: "Honda",
    status: "available",
});

// Create booking
const booking = await client.bookings.create({
    motor_id: 1,
    tanggal_mulai: "2025-09-25",
    tanggal_selesai: "2025-09-27",
});
```

---

**API Documentation v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_

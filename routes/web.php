<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MotorVerificationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\MotorController as OwnerMotorController;
use App\Http\Controllers\Owner\RevenueController;
use App\Http\Controllers\Renter\RenterController;
use App\Http\Controllers\Renter\DashboardController as RenterDashboard;
use App\Http\Controllers\Renter\MotorSearchController;
use App\Http\Controllers\Renter\BookingController;
use App\Http\Controllers\Renter\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root route - redirect to appropriate dashboard or login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Simple role-based redirect
        $dashboardRoute = match ($user->role->value) {
            'admin' => 'admin.dashboard',
            'pemilik' => 'owner.dashboard',
            'penyewa' => 'admin.dashboard', // Temporary fallback to admin dashboard until renter dashboard is implemented
            default => 'login'
        };
        return redirect()->route($dashboardRoute);
    }
    return redirect()->route('login');
})->name('home');



// Guest routes (login and registration)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout route (for authenticated users)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Motor Verification
    Route::get('/motors', [MotorVerificationController::class, 'index'])->name('motors.index');
    Route::get('/motors/export', [MotorVerificationController::class, 'exportPdf'])->name('motors.export');
    Route::get('/motors/{motor}', [MotorVerificationController::class, 'show'])->name('motors.show');
    Route::patch('/motors/{motor}/verify', [MotorVerificationController::class, 'verify'])->name('motors.verify');
    Route::patch('/motors/{motor}/reject', [MotorVerificationController::class, 'reject'])->name('motors.reject');

    // User Management
    Route::get('/users/export', [AdminUserController::class, 'exportPdf'])->name('users.export');
    Route::resource('users', AdminUserController::class);

    // Transaction Management - using Penyewaan data as real transactions
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/export', [TransaksiController::class, 'export'])->name('transaksi.export');
    Route::get('/transaksi/{penyewaan}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{penyewaan}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');

    // Penyewaan Management
    Route::prefix('penyewaan')->name('penyewaan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PenyewaanController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PenyewaanController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PenyewaanController::class, 'store'])->name('store');
        Route::get('/{penyewaan}', [\App\Http\Controllers\Admin\PenyewaanController::class, 'show'])->name('show');
        Route::get('/{penyewaan}/edit', [\App\Http\Controllers\Admin\PenyewaanController::class, 'edit'])->name('edit');
        Route::put('/{penyewaan}', [\App\Http\Controllers\Admin\PenyewaanController::class, 'update'])->name('update');
        Route::delete('/{penyewaan}', [\App\Http\Controllers\Admin\PenyewaanController::class, 'destroy'])->name('destroy');
        Route::patch('/{penyewaan}/status', [\App\Http\Controllers\Admin\PenyewaanController::class, 'updateStatus'])->name('update-status');
        Route::get('/export/pdf', [\App\Http\Controllers\Admin\PenyewaanController::class, 'exportPdf'])->name('export.pdf');
    });

    // Payments Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('store');
        Route::get('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('show');
        Route::get('/{payment}/edit', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('edit');
        Route::put('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('destroy');
        Route::patch('/{payment}/verify', [\App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('verify');
        Route::get('/export/csv', [\App\Http\Controllers\Admin\PaymentController::class, 'exportCsv'])->name('export.csv');
        Route::get('/report', [\App\Http\Controllers\Admin\PaymentController::class, 'report'])->name('report');
        Route::get('/report/export/pdf', [\App\Http\Controllers\Admin\PaymentController::class, 'exportPdf'])->name('report.export.pdf');
        Route::get('/report/export/excel', [\App\Http\Controllers\Admin\PaymentController::class, 'exportExcel'])->name('report.export.excel');
    });

    // Bagi Hasil Management
    Route::prefix('bagi-hasil')->name('bagi-hasil.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BagiHasilController::class, 'index'])->name('index');
        Route::get('/{bagiHasil}', [\App\Http\Controllers\Admin\BagiHasilController::class, 'show'])->name('show');
        Route::patch('/{bagiHasil}/process', [\App\Http\Controllers\Admin\BagiHasilController::class, 'process'])->name('process');
        Route::get('/export/pdf', [\App\Http\Controllers\Admin\BagiHasilController::class, 'exportPdf'])->name('export.pdf');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('index');
        Route::get('/export', [\App\Http\Controllers\Admin\AnalyticsController::class, 'export'])->name('export');
        Route::get('/data/bookings', [\App\Http\Controllers\Admin\AnalyticsController::class, 'bookingsData'])->name('data.bookings');
        Route::get('/data/revenue', [\App\Http\Controllers\Admin\AnalyticsController::class, 'revenueData'])->name('data.revenue');
        Route::get('/data/motors', [\App\Http\Controllers\Admin\AnalyticsController::class, 'motorsData'])->name('data.motors');
        Route::get('/data/times', [\App\Http\Controllers\Admin\AnalyticsController::class, 'timesData'])->name('data.times');
        Route::get('/data/payments', [\App\Http\Controllers\Admin\AnalyticsController::class, 'paymentsData'])->name('data.payments');
    });

    // Reports (Laporan)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
        Route::get('/revenue', [\App\Http\Controllers\Admin\LaporanController::class, 'revenue'])->name('revenue');
        Route::get('/rental', [\App\Http\Controllers\Admin\LaporanController::class, 'rental'])->name('rental');
        Route::get('/motor', [\App\Http\Controllers\Admin\LaporanController::class, 'motor'])->name('motor');
        Route::get('/user', [\App\Http\Controllers\Admin\LaporanController::class, 'user'])->name('user');
        Route::get('/export', [\App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('export');
    });

    // Admin Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password');
        Route::get('/system', [SettingsController::class, 'systemSettings'])->name('system');
        Route::put('/system', [SettingsController::class, 'updateSystemSettings'])->name('system.update');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup', [SettingsController::class, 'createBackup'])->name('backup.create');
        Route::get('/logs', [SettingsController::class, 'logs'])->name('logs');
    });
});

// Owner Routes
Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

    // Motor Management
    Route::get('/motors', [OwnerController::class, 'motors'])->name('motors.index');
    Route::get('/motors/create', [OwnerController::class, 'createMotor'])->name('motors.create');
    Route::post('/motors', [OwnerController::class, 'storeMotor'])->name('motors.store');
    Route::get('/motors/{motor}', [OwnerController::class, 'showMotor'])->name('motors.show');
    Route::get('/motors/{motor}/edit', [OwnerController::class, 'editMotor'])->name('motors.edit');
    Route::put('/motors/{motor}', [OwnerController::class, 'updateMotor'])->name('motors.update');
    Route::delete('/motors/{motor}', [OwnerController::class, 'destroyMotor'])->name('motors.destroy');

    // Motor Status Management
    Route::patch('/motors/{motor}/maintenance', [OwnerController::class, 'setMaintenance'])->name('motors.set-maintenance');
    Route::patch('/motors/{motor}/activate', [OwnerController::class, 'activateFromMaintenance'])->name('motors.activate');

    // Revenue Reports
    Route::get('/revenue', [OwnerController::class, 'revenue'])->name('revenue');
    Route::get('/revenue/history', [OwnerController::class, 'revenueHistory'])->name('revenue.history');
    Route::get('/revenue/history/export-pdf', [OwnerController::class, 'exportRevenueHistoryPDF'])->name('revenue.history.export.pdf');
    Route::get('/revenue/total', [OwnerController::class, 'totalRevenue'])->name('revenue.total');
    Route::get('/revenue/export', [OwnerController::class, 'exportRevenue'])->name('revenue.export');
    Route::get('/revenue/export-pdf', [OwnerController::class, 'exportRevenuePDF'])->name('revenue.export.pdf');

    // Rental Reports
    Route::get('/rentals', [OwnerController::class, 'rentalsReport'])->name('rentals');
    Route::get('/rentals/report', [OwnerController::class, 'rentalsReport'])->name('rentals.report');
    Route::get('/rentals/export-pdf', [OwnerController::class, 'exportRentalsPDF'])->name('rentals.export.pdf');

    // Profile and Settings
    Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');
    Route::put('/profile', [OwnerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [OwnerController::class, 'settings'])->name('settings');
    Route::put('/settings', [OwnerController::class, 'updateSettings'])->name('settings.update');
});

// Renter Routes
Route::middleware(['auth', 'renter'])->prefix('renter')->name('renter.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [RenterController::class, 'dashboard'])->name('dashboard');

    // Motor Search and Browse
    Route::get('/motors', [RenterController::class, 'motors'])->name('motors.index');
    Route::get('/motors/{motor}', [RenterController::class, 'showMotor'])->name('motors.show');

    // Booking Management
    Route::get('/bookings', [RenterController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/create/{motor}', [RenterController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [RenterController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/bookings/{booking}', [RenterController::class, 'showBooking'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [RenterController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/confirm-return', [RenterController::class, 'confirmReturn'])->name('bookings.confirm-return');

    // History and Reports
    Route::get('/history', [RenterController::class, 'history'])->name('history');
    Route::get('/history/export', [RenterController::class, 'exportHistory'])->name('history.export');
});

// API Routes for AJAX calls
Route::middleware('auth')->prefix('api')->group(function () {
    // Motor availability check
    Route::post('/motors/{motor}/availability', [MotorSearchController::class, 'apiCheckAvailability']);

    // Real-time notifications (future implementation)
    Route::get('/notifications', function () {
        return response()->json(['notifications' => []]);
    });

    // Dashboard statistics
    Route::get('/dashboard/stats', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return response()->json([
            'role' => $user->role->value,

            'stats' => match ($user->role->value) {
                'admin' => [
                    'total_users' => \App\Models\User::count(),
                    'total_motors' => \App\Models\Motor::count(),
                    'pending_verifications' => \App\Models\Motor::where('status', 'pending')->count(),
                ],
                'pemilik' => [
                    'total_motors' => $user->motors()->count(),
                    'active_bookings' => \App\Models\Penyewaan::whereIn('motor_id', $user->motors()->pluck('id'))->whereIn('status', ['confirmed', 'active'])->count(),
                    'total_earnings' => $user->bagiHasils()->where('settled_at', '!=', null)->sum('bagi_hasil_pemilik'),
                ],
                'penyewa' => [
                    'active_bookings' => $user->penyewaans()->whereIn('status', ['confirmed', 'active'])->count(),
                    'total_bookings' => $user->penyewaans()->count(),
                    'completed_bookings' => $user->penyewaans()->where('status', 'completed')->count(),
                ],
                default => [],
            }
        ]);
    });
});

/// Fallback route for 404
// Fallback route for 404
Route::fallback(function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Simple role-based redirect
        $dashboardRoute = match ($user->role->value) {
            'admin' => 'admin.dashboard',
            'pemilik' => 'owner.dashboard',
            'penyewa' => 'renter.dashboard',
            default => 'login'
        };
        return redirect()->route($dashboardRoute)
            ->with('error', 'Halaman yang Anda cari tidak ditemukan.');
    }
    return redirect()->route('login')
        ->with('error', 'Halaman yang Anda cari tidak ditemukan.');
});

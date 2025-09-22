<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MotorVerificationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\MotorController as OwnerMotorController;
use App\Http\Controllers\Owner\RevenueController;
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
    Route::get('/motors/export', [MotorVerificationController::class, 'export'])->name('motors.export');
    Route::get('/motors/{motor}', [MotorVerificationController::class, 'show'])->name('motors.show');
    Route::patch('/motors/{motor}/verify', [MotorVerificationController::class, 'verify'])->name('motors.verify');
    Route::patch('/motors/{motor}/reject', [MotorVerificationController::class, 'reject'])->name('motors.reject');

    // User Management
    Route::resource('users', AdminUserController::class);
    Route::get('/users/export', [AdminUserController::class, 'export'])->name('users.export');

    // Rental Tariff Management
    Route::resource('tarif', TarifController::class);
    Route::post('/tarif/{motor}/set-rates', [TarifController::class, 'setRates'])->name('tarif.set-rates');

    // Transaction Management
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
    Route::get('/transaksi/export', [TransaksiController::class, 'export'])->name('transaksi.export');

    // Reports and Analytics
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/revenue', [LaporanController::class, 'revenue'])->name('revenue');
        Route::get('/motors', [LaporanController::class, 'motors'])->name('motors');
        Route::get('/users', [LaporanController::class, 'users'])->name('users');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
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

    // Revenue Reports
    Route::get('/revenue', [OwnerController::class, 'revenue'])->name('revenue');
    Route::get('/revenue/export', [OwnerController::class, 'exportRevenue'])->name('revenue.export');
});

// Renter Routes (temporarily disabled - controllers not implemented yet)
Route::middleware(['auth', 'renter'])->prefix('renter')->name('renter.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [RenterDashboard::class, 'index'])->name('dashboard');

    // Motor Search and Browse
    Route::get('/motors', [MotorSearchController::class, 'index'])->name('motors.index');
    Route::get('/motors/{motor}', [MotorSearchController::class, 'show'])->name('motors.show');
    Route::post('/motors/{motor}/check-availability', [MotorSearchController::class, 'checkAvailability'])->name('motors.check-availability');

    // Booking Management
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment Management
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{booking}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/callback/midtrans', [PaymentController::class, 'midtransCallback'])->name('payments.midtrans-callback');
    Route::get('/payments/{transaction}/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/{transaction}/failed', [PaymentController::class, 'failed'])->name('payments.failed');
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

    // Revenue Reports
    Route::get('/revenue', [OwnerController::class, 'revenue'])->name('revenue');
    Route::get('/revenue/export', [OwnerController::class, 'exportRevenue'])->name('revenue.export');
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
            'penyewa' => 'admin.dashboard', // Temporary fallback to admin dashboard until renter dashboard is implemented
            default => 'login'
        };
        return redirect()->route($dashboardRoute)
            ->with('error', 'Halaman yang Anda cari tidak ditemukan.');
    }
    return redirect()->route('login')
        ->with('error', 'Halaman yang Anda cari tidak ditemukan.');
});

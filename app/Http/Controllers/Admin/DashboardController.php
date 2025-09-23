<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\User;
use App\Enums\BookingStatus;
use App\Enums\MotorStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate monthly revenue from completed bookings
        $monthlyRevenue = Penyewaan::where('status', BookingStatus::COMPLETED)
            ->where(function ($query) use ($currentMonth, $currentYear) {
                $query->where(function ($q) use ($currentMonth, $currentYear) {
                    // First try completed_at
                    $q->whereNotNull('completed_at')
                        ->whereMonth('completed_at', $currentMonth)
                        ->whereYear('completed_at', $currentYear);
                })->orWhere(function ($q) use ($currentMonth, $currentYear) {
                    // Fallback to created_at if completed_at is null
                    $q->whereNull('completed_at')
                        ->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                });
            })
            ->sum('harga');

        // Additional revenue statistics
        $totalRevenue = Penyewaan::where('status', BookingStatus::COMPLETED)->sum('harga');
        $completedBookingsThisMonth = Penyewaan::where('status', BookingStatus::COMPLETED)
            ->where(function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('completed_at', $currentMonth)
                    ->whereYear('completed_at', $currentYear)
                    ->orWhere(function ($q) use ($currentMonth, $currentYear) {
                        $q->whereNull('completed_at')
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear);
                    });
            })
            ->count();

        // Get statistics
        $totalUsers = User::count();
        $totalMotors = Motor::count();
        $pendingMotors = Motor::where('status', MotorStatus::PENDING)->count();
        $activeBookings = Penyewaan::whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])->count();

        // Get recent users
        $recentUsers = User::latest()->take(5)->get();

        // Get pending motors
        $pendingMotorsList = Motor::where('status', MotorStatus::PENDING)
            ->with('owner')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'monthlyRevenue',
            'totalRevenue',
            'completedBookingsThisMonth',
            'totalUsers',
            'totalMotors',
            'pendingMotors',
            'activeBookings',
            'recentUsers',
            'pendingMotorsList'
        ));
    }
}

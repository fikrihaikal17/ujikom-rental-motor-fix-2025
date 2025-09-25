<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\BagiHasil;
use App\Enums\BookingStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    // Statistik motor owner
    $totalMotors = Motor::where('pemilik_id', $user->id)->count();

    $activeMotoRentals = Motor::where('pemilik_id', $user->id)
      ->whereHas('penyewaans', function ($query) {
        $query->where('status', BookingStatus::ACTIVE);
      })
      ->count();

    // Pendapatan bulan ini (dari bagi hasil)
    $currentMonth = Carbon::now()->format('Y-m');
    $monthlyRevenue = BagiHasil::whereHas('penyewaan.motor', function ($query) use ($user) {
      $query->where('pemilik_id', $user->id);
    })
      ->where('tanggal', 'like', $currentMonth . '%')
      ->sum('bagi_hasil_pemilik');

    // Total pendapatan semua waktu
    $totalRevenue = BagiHasil::whereHas('penyewaan.motor', function ($query) use ($user) {
      $query->where('pemilik_id', $user->id);
    })
      ->sum('bagi_hasil_pemilik');

    // Data untuk chart - pendapatan 6 bulan terakhir
    $monthlyRevenueChart = [];
    for ($i = 5; $i >= 0; $i--) {
      $month = Carbon::now()->subMonths($i);
      $monthKey = $month->format('Y-m');
      $monthName = $month->format('M Y');

      $revenue = BagiHasil::whereHas('penyewaan.motor', function ($query) use ($user) {
        $query->where('pemilik_id', $user->id);
      })
        ->where('tanggal', 'like', $monthKey . '%')
        ->sum('bagi_hasil_pemilik');

      $monthlyRevenueChart[] = [
        'month' => $monthName,
        'revenue' => $revenue
      ];
    }

    // Recent rentals untuk owner ini
    $recentRentals = Penyewaan::whereHas('motor', function ($query) use ($user) {
      $query->where('pemilik_id', $user->id);
    })
      ->with(['motor', 'penyewa'])
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();

    return view('dashboard.owner', compact(
      'totalMotors',
      'activeMotoRentals',
      'monthlyRevenue',
      'totalRevenue',
      'monthlyRevenueChart',
      'recentRentals'
    ));
  }
}

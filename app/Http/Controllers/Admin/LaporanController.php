<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
  public function index()
  {
    // Current period stats
    $today = now();
    $startOfMonth = $today->copy()->startOfMonth();
    $startOfYear = $today->copy()->startOfYear();

    $stats = [
      // Revenue stats
      'daily_revenue' => Transaksi::where('status', 'paid')
        ->whereDate('created_at', $today)
        ->sum('jumlah'),
      'monthly_revenue' => Transaksi::where('status', 'paid')
        ->whereBetween('created_at', [$startOfMonth, $today])
        ->sum('jumlah'),
      'yearly_revenue' => Transaksi::where('status', 'paid')
        ->whereBetween('created_at', [$startOfYear, $today])
        ->sum('jumlah'),

      // Rental stats
      'active_rentals' => Penyewaan::where('status', 'active')->count(),
      'total_rentals' => Penyewaan::count(),
      'monthly_rentals' => Penyewaan::whereBetween('created_at', [$startOfMonth, $today])->count(),

      // Motor stats
      'total_motors' => Motor::count(),
      'available_motors' => Motor::where('ketersediaan', 'tersedia')->count(),
      'rented_motors' => Motor::where('ketersediaan', 'disewa')->count(),

      // User stats
      'total_users' => User::count(),
      'monthly_new_users' => User::whereBetween('created_at', [$startOfMonth, $today])->count(),
    ];

    // Revenue trend (last 12 months)
    $revenueTrend = [];
    for ($i = 11; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $revenue = Transaksi::where('status', 'paid')
        ->whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('jumlah');

      $revenueTrend[] = [
        'month' => $date->format('M Y'),
        'revenue' => $revenue
      ];
    }

    // Top performing motors
    $topMotors = Motor::withCount(['penyewaans as rental_count'])
      ->with(['tarifRental' => function ($query) {
        $query->where('is_active', true);
      }])
      ->orderBy('rental_count', 'desc')
      ->limit(5)
      ->get();

    // Payment method distribution
    $paymentMethods = Transaksi::where('status', 'paid')
      ->select('metode_pembayaran')
      ->selectRaw('COUNT(*) as count')
      ->selectRaw('SUM(jumlah) as total_amount')
      ->groupBy('metode_pembayaran')
      ->get();

    return view('admin.laporan.index', compact('stats', 'revenueTrend', 'topMotors', 'paymentMethods'));
  }

  public function revenue(Request $request)
  {
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();
    $groupBy = $request->group_by ?? 'day';

    $query = Transaksi::where('status', 'paid')
      ->whereBetween('created_at', [$startDate, $endDate]);

    // Group by period
    switch ($groupBy) {
      case 'hour':
        $data = $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as period')
          ->selectRaw('SUM(jumlah) as revenue')
          ->selectRaw('COUNT(*) as transaction_count')
          ->groupBy('period')
          ->orderBy('period')
          ->get();
        break;
      case 'day':
        $data = $query->selectRaw('DATE(created_at) as period')
          ->selectRaw('SUM(jumlah) as revenue')
          ->selectRaw('COUNT(*) as transaction_count')
          ->groupBy('period')
          ->orderBy('period')
          ->get();
        break;
      case 'month':
        $data = $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period')
          ->selectRaw('SUM(jumlah) as revenue')
          ->selectRaw('COUNT(*) as transaction_count')
          ->groupBy('period')
          ->orderBy('period')
          ->get();
        break;
      case 'year':
        $data = $query->selectRaw('YEAR(created_at) as period')
          ->selectRaw('SUM(jumlah) as revenue')
          ->selectRaw('COUNT(*) as transaction_count')
          ->groupBy('period')
          ->orderBy('period')
          ->get();
        break;
    }

    $totalRevenue = $data->sum('revenue');
    $totalTransactions = $data->sum('transaction_count');
    $averagePerTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

    return view('admin.laporan.revenue', compact('data', 'startDate', 'endDate', 'groupBy', 'totalRevenue', 'totalTransactions', 'averagePerTransaction'));
  }

  public function motors(Request $request)
  {
    $query = Motor::with(['owner', 'tarifRental' => function ($q) {
      $q->where('is_active', true);
    }])
      ->withCount(['penyewaans as total_rentals'])
      ->withSum(['penyewaans as total_revenue' => function ($q) {
        $q->join('transaksis', 'penyewaans.id', '=', 'transaksis.penyewaan_id')
          ->where('transaksis.status', 'paid');
      }], 'transaksis.jumlah');

    // Filter by availability
    if ($request->availability) {
      $query->where('ketersediaan', $request->availability);
    }

    // Filter by owner
    if ($request->owner_id) {
      $query->where('user_id', $request->owner_id);
    }

    // Sort options
    $sortBy = $request->sort_by ?? 'total_rentals';
    $sortOrder = $request->sort_order ?? 'desc';

    $query->orderBy($sortBy, $sortOrder);

    $motors = $query->paginate(20);
    $owners = User::where('role', 'owner')->get();

    return view('admin.laporan.motors', compact('motors', 'owners'));
  }

  public function users(Request $request)
  {
    $query = User::query();

    // Filter by role
    if ($request->role) {
      $query->where('role', $request->role);
    }

    // Filter by registration date
    if ($request->start_date) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Add relationship counts
    $query->withCount([
      'ownedMotors as motor_count',
      'penyewaans as rental_count'
    ]);

    $users = $query->latest()->paginate(20);

    // User registration trend
    $registrationTrend = User::selectRaw('DATE(created_at) as date')
      ->selectRaw('COUNT(*) as count')
      ->whereBetween('created_at', [now()->subDays(30), now()])
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    // Role distribution
    $roleDistribution = User::selectRaw('role, COUNT(*) as count')
      ->groupBy('role')
      ->get();

    return view('admin.laporan.users', compact('users', 'registrationTrend', 'roleDistribution'));
  }

  public function export(Request $request)
  {
    $type = $request->type ?? 'revenue';
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

    $filename = "laporan_{$type}_" . $startDate->format('Y_m_d') . '_to_' . $endDate->format('Y_m_d') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($type, $startDate, $endDate) {
      $file = fopen('php://output', 'w');

      // UTF-8 BOM
      fwrite($file, "\xEF\xBB\xBF");

      switch ($type) {
        case 'revenue':
          $this->exportRevenue($file, $startDate, $endDate);
          break;
        case 'motors':
          $this->exportMotors($file);
          break;
        case 'users':
          $this->exportUsers($file, $startDate, $endDate);
          break;
        case 'transactions':
          $this->exportTransactions($file, $startDate, $endDate);
          break;
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  private function exportRevenue($file, $startDate, $endDate)
  {
    fputcsv($file, ['Tanggal', 'Total Revenue', 'Jumlah Transaksi', 'Rata-rata per Transaksi']);

    $data = Transaksi::where('status', 'paid')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->selectRaw('DATE(created_at) as date')
      ->selectRaw('SUM(jumlah) as revenue')
      ->selectRaw('COUNT(*) as count')
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    foreach ($data as $row) {
      $average = $row->count > 0 ? $row->revenue / $row->count : 0;
      fputcsv($file, [
        $row->date,
        $row->revenue,
        $row->count,
        round($average, 2)
      ]);
    }
  }

  private function exportMotors($file)
  {
    fputcsv($file, ['Motor', 'Pemilik', 'Plat Nomor', 'Status', 'Total Penyewaan', 'Total Revenue']);

    $motors = Motor::with(['owner'])
      ->withCount(['penyewaans as total_rentals'])
      ->withSum(['penyewaans as total_revenue' => function ($q) {
        $q->join('transaksis', 'penyewaans.id', '=', 'transaksis.penyewaan_id')
          ->where('transaksis.status', 'paid');
      }], 'transaksis.jumlah')
      ->get();

    foreach ($motors as $motor) {
      fputcsv($file, [
        $motor->merk . ' ' . $motor->model,
        $motor->owner->name,
        $motor->plat_nomor,
        $motor->ketersediaan,
        $motor->total_rentals,
        $motor->total_revenue ?? 0
      ]);
    }
  }

  private function exportUsers($file, $startDate, $endDate)
  {
    fputcsv($file, ['Nama', 'Email', 'Role', 'Tanggal Daftar', 'Jumlah Motor', 'Jumlah Penyewaan']);

    $users = User::whereBetween('created_at', [$startDate, $endDate])
      ->withCount([
        'ownedMotors as motor_count',
        'penyewaans as rental_count'
      ])
      ->get();

    foreach ($users as $user) {
      fputcsv($file, [
        $user->name,
        $user->email,
        $user->role->value,
        $user->created_at->format('Y-m-d'),
        $user->motor_count,
        $user->rental_count
      ]);
    }
  }

  private function exportTransactions($file, $startDate, $endDate)
  {
    fputcsv($file, ['Kode Transaksi', 'Penyewa', 'Motor', 'Metode Pembayaran', 'Jumlah', 'Status', 'Tanggal']);

    $transactions = Transaksi::with(['penyewaan.motor', 'penyewaan.renter'])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->get();

    foreach ($transactions as $transaction) {
      fputcsv($file, [
        $transaction->kode_transaksi,
        $transaction->penyewaan->renter->name ?? '-',
        ($transaction->penyewaan->motor->merk ?? '') . ' ' . ($transaction->penyewaan->motor->model ?? ''),
        $transaction->metode_pembayaran,
        $transaction->jumlah,
        $transaction->status,
        $transaction->created_at->format('Y-m-d H:i:s')
      ]);
    }
  }
}

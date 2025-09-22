<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
  public function index(Request $request)
  {
    $query = Transaksi::with(['penyewaan.motor', 'penyewaan.renter'])
      ->latest();

    // Filter by status
    if ($request->status) {
      $query->where('status', $request->status);
    }

    // Filter by date range
    if ($request->start_date) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Search by transaction code or renter name
    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('kode_transaksi', 'like', '%' . $request->search . '%')
          ->orWhereHas('penyewaan.renter', function ($sq) use ($request) {
            $sq->where('name', 'like', '%' . $request->search . '%');
          });
      });
    }

    $transaksis = $query->paginate(15);

    // Statistics
    $stats = [
      'total_transaksi' => Transaksi::count(),
      'pending_transaksi' => Transaksi::where('status', 'pending')->count(),
      'paid_transaksi' => Transaksi::where('status', 'paid')->count(),
      'total_revenue' => Transaksi::where('status', 'paid')->sum('jumlah'),
      'today_revenue' => Transaksi::where('status', 'paid')
        ->whereDate('created_at', today())
        ->sum('jumlah'),
      'monthly_revenue' => Transaksi::where('status', 'paid')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('jumlah'),
    ];

    return view('admin.transaksi.index', compact('transaksis', 'stats'));
  }

  public function show(Transaksi $transaksi)
  {
    $transaksi->load(['penyewaan.motor.owner', 'penyewaan.renter']);
    return view('admin.transaksi.show', compact('transaksi'));
  }

  public function updateStatus(Request $request, Transaksi $transaksi)
  {
    $request->validate([
      'status' => 'required|in:pending,paid,failed,refunded',
      'admin_notes' => 'nullable|string|max:500'
    ]);

    $transaksi->update([
      'status' => $request->status,
      'admin_notes' => $request->admin_notes,
      'verified_at' => $request->status === 'paid' ? now() : null,
    ]);

    // Update penyewaan status if payment is confirmed
    if ($request->status === 'paid' && $transaksi->penyewaan) {
      $transaksi->penyewaan->update(['status' => 'confirmed']);
    }

    return back()->with('success', 'Status transaksi berhasil diperbarui.');
  }

  public function export(Request $request)
  {
    $query = Transaksi::with(['penyewaan.motor', 'penyewaan.renter']);

    // Apply same filters as index
    if ($request->status) {
      $query->where('status', $request->status);
    }
    if ($request->start_date) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    $transaksis = $query->get();

    $filename = 'transaksi_' . now()->format('Y_m_d_H_i_s') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($transaksis) {
      $file = fopen('php://output', 'w');

      // UTF-8 BOM for Excel compatibility
      fwrite($file, "\xEF\xBB\xBF");

      // Headers
      fputcsv($file, [
        'Kode Transaksi',
        'Penyewa',
        'Motor',
        'Tanggal Transaksi',
        'Metode Pembayaran',
        'Jumlah Bayar',
        'Status',
        'Catatan Admin'
      ]);

      // Data
      foreach ($transaksis as $transaksi) {
        fputcsv($file, [
          $transaksi->kode_transaksi,
          $transaksi->penyewaan->renter->name ?? '-',
          ($transaksi->penyewaan->motor->merk ?? '') . ' ' . ($transaksi->penyewaan->motor->model ?? ''),
          $transaksi->created_at->format('Y-m-d H:i:s'),
          $transaksi->metode_pembayaran,
          $transaksi->jumlah,
          ucfirst($transaksi->status),
          $transaksi->admin_notes ?? '-'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  public function dashboard()
  {
    // Monthly revenue data for chart
    $monthlyData = [];
    for ($i = 11; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $revenue = Transaksi::where('status', 'paid')
        ->whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('jumlah');

      $monthlyData[] = [
        'month' => $date->format('M Y'),
        'revenue' => $revenue
      ];
    }

    // Daily revenue for current month
    $dailyData = [];
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
      $revenue = Transaksi::where('status', 'paid')
        ->whereDate('created_at', $date)
        ->sum('jumlah');

      $dailyData[] = [
        'date' => $date->format('Y-m-d'),
        'revenue' => $revenue
      ];
    }

    // Payment method distribution
    $paymentMethods = Transaksi::where('status', 'paid')
      ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(jumlah) as total')
      ->groupBy('metode_pembayaran')
      ->get();

    return view('admin.transaksi.dashboard', compact('monthlyData', 'dailyData', 'paymentMethods'));
  }
}

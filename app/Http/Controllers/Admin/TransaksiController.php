<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
  public function index(Request $request)
  {
    // Use Penyewaan data as real transaction data
    $query = Penyewaan::with(['motor', 'penyewa'])
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

    // Search by booking code or renter name
    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('booking_code', 'like', '%' . $request->search . '%')
          ->orWhereHas('penyewa', function ($sq) use ($request) {
            $sq->where('name', 'like', '%' . $request->search . '%');
          });
      });
    }

    $transaksis = $query->paginate(15);

    // Transform data to include transaction-like fields
    $transaksis->getCollection()->transform(function ($penyewaan) {
      $penyewaan->kode_transaksi = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->metode_pembayaran = 'cash'; // COD
      $penyewaan->jumlah = $penyewaan->harga;

      // Map booking status to payment status
      switch ($penyewaan->status) {
        case BookingStatus::COMPLETED:
          $penyewaan->payment_status = 'paid';
          break;
        case BookingStatus::CANCELLED:
          $penyewaan->payment_status = 'failed';
          break;
        case BookingStatus::PENDING:
          $penyewaan->payment_status = 'pending';
          break;
        default:
          $penyewaan->payment_status = 'pending';
      }

      return $penyewaan;
    });

    // Statistics from Penyewaan data
    $stats = [
      'total_transaksi' => Penyewaan::count(),
      'pending_transaksi' => Penyewaan::where('status', BookingStatus::PENDING)->count(),
      'paid_transaksi' => Penyewaan::where('status', BookingStatus::COMPLETED)->count(),
      'total_revenue' => Penyewaan::where('status', BookingStatus::COMPLETED)->sum('harga'),
      'today_revenue' => Penyewaan::where('status', BookingStatus::COMPLETED)
        ->whereDate('created_at', today())
        ->sum('harga'),
      'monthly_revenue' => Penyewaan::where('status', BookingStatus::COMPLETED)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('harga'),
    ];

    return view('admin.transaksi.index', compact('transaksis', 'stats'));
  }

  public function show(Penyewaan $penyewaan)
  {
    $penyewaan->load(['motor', 'penyewa']);
    // Transform to match expected view data
    $penyewaan->kode_transaksi = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
    $penyewaan->metode_pembayaran = 'cash';
    $penyewaan->jumlah = $penyewaan->harga;

    // Pass as transaksi for view compatibility
    $transaksi = $penyewaan;
    return view('admin.transaksi.show', compact('transaksi'));
  }

  public function updateStatus(Request $request, Penyewaan $penyewaan)
  {
    $request->validate([
      'status' => 'required|in:pending,confirmed,active,completed,cancelled',
      'admin_notes' => 'nullable|string|max:500'
    ]);

    $penyewaan->update([
      'status' => $request->status,
      'catatan' => $request->admin_notes,
    ]);

    return back()->with('success', 'Status transaksi berhasil diperbarui.');
  }

  public function export(Request $request)
  {
    $query = Penyewaan::with(['motor', 'penyewa']);

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

    // Transform data to include transaction-like fields
    $transaksis->transform(function ($penyewaan) {
      $penyewaan->kode_transaksi = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->metode_pembayaran = 'cash';
      $penyewaan->jumlah = $penyewaan->harga;

      // Map booking status to payment status
      switch ($penyewaan->status) {
        case BookingStatus::COMPLETED:
          $penyewaan->payment_status = 'paid';
          break;
        case BookingStatus::CANCELLED:
          $penyewaan->payment_status = 'failed';
          break;
        case BookingStatus::PENDING:
          $penyewaan->payment_status = 'pending';
          break;
        default:
          $penyewaan->payment_status = 'pending';
      }

      return $penyewaan;
    });

    // Statistics
    $stats = [
      'total_transaksi' => $transaksis->count(),
      'completed_transaksi' => $transaksis->where('payment_status', 'paid')->count(),
      'cancelled_transaksi' => $transaksis->where('payment_status', 'failed')->count(),
      'total_revenue' => $transaksis->where('payment_status', 'paid')->sum('jumlah'),
    ];

    // Filter dates for display
    $startDate = $request->start_date ?? 'Semua';
    $endDate = $request->end_date ?? 'Semua';

    // Generate PDF
    $pdf = Pdf::loadView('admin.transaksi.report-pdf', compact(
      'transaksis',
      'stats',
      'startDate',
      'endDate'
    ));

    $pdf->setPaper('a4', 'landscape');
    $pdf->setOptions([
      'isHtml5ParserEnabled' => true,
      'isPhpEnabled' => true,
      'defaultFont' => 'Arial'
    ]);

    $filename = 'laporan-transaksi-' . date('Y-m-d-His') . '.pdf';
    return $pdf->download($filename);
  }

  public function dashboard()
  {
    // Monthly revenue data for chart from Penyewaan
    $monthlyData = [];
    for ($i = 11; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $revenue = Penyewaan::where('status', BookingStatus::COMPLETED)
        ->whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('harga');

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
      $revenue = Penyewaan::where('status', BookingStatus::COMPLETED)
        ->whereDate('created_at', $date)
        ->sum('harga');

      $dailyData[] = [
        'date' => $date->format('Y-m-d'),
        'revenue' => $revenue
      ];
    }

    // Payment method distribution (all COD for now)
    $paymentMethods = collect([
      (object)[
        'metode_pembayaran' => 'cash',
        'count' => Penyewaan::where('status', BookingStatus::COMPLETED)->count(),
        'total' => Penyewaan::where('status', BookingStatus::COMPLETED)->sum('harga')
      ]
    ]);

    return view('admin.transaksi.dashboard', compact('monthlyData', 'dailyData', 'paymentMethods'));
  }
}

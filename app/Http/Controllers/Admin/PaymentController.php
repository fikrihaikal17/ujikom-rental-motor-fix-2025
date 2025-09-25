<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Penyewaan;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
  public function index(Request $request)
  {
    // Get all bookings as payment data (since this system uses COD/Cash payments)
    $query = Penyewaan::with(['motor', 'penyewa']);

    // Filter by status
    if ($request->filled('status')) {
      if ($request->status == 'completed') {
        $query->where('status', BookingStatus::COMPLETED);
      } elseif ($request->status == 'pending') {
        // Show pending, confirmed, and active bookings as "pending" payments
        $query->whereIn('status', [BookingStatus::PENDING, BookingStatus::CONFIRMED, BookingStatus::ACTIVE]);
      } elseif ($request->status == 'failed') {
        $query->where('status', BookingStatus::CANCELLED);
      }
    }

    // Filter by payment method (all are cash/COD)
    if ($request->filled('method') && $request->method != 'cash') {
      // If filtering for non-cash methods, return empty results
      $query->whereRaw('1 = 0');
    }

    // Filter by date range
    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }

    $payments = $query->orderBy('created_at', 'desc')->paginate(10);

    // Transform penyewaan data to payment-like structure
    $payments->getCollection()->transform(function ($penyewaan) {
      $penyewaan->transaction_id = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->booking_code = 'BK-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->amount = $penyewaan->harga;
      $penyewaan->payment_method = 'cash';

      // Map booking status to payment status
      $penyewaan->payment_status = match ($penyewaan->status) {
        BookingStatus::COMPLETED => 'completed',
        BookingStatus::CANCELLED => 'failed',
        BookingStatus::PENDING, BookingStatus::CONFIRMED, BookingStatus::ACTIVE => 'pending',
        default => 'pending'
      };

      return $penyewaan;
    });

    // Statistics
    $stats = [
      'total' => Penyewaan::count(),
      'success' => Penyewaan::where('status', BookingStatus::COMPLETED)->count(),
      'pending' => Penyewaan::whereIn('status', [BookingStatus::PENDING, BookingStatus::CONFIRMED, BookingStatus::ACTIVE])->count(),
      'failed' => Penyewaan::where('status', BookingStatus::CANCELLED)->count(),
      'total_amount' => Penyewaan::where('status', BookingStatus::COMPLETED)->sum('harga'),
    ];

    return view('admin.payments.index', compact('payments', 'stats'));
  }

  public function create()
  {
    $penyewaans = Penyewaan::with(['motor', 'user'])
      ->whereDoesntHave('payments', function ($query) {
        $query->where('status', 'verified');
      })
      ->get();

    return view('admin.payments.create', compact('penyewaans'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'penyewaan_id' => 'required|exists:penyewaans,id',
      'amount' => 'required|numeric|min:0',
      'payment_method' => 'required|in:cash,transfer,ewallet',
      'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'notes' => 'nullable|string'
    ]);

    $data = $request->all();
    $data['transaction_code'] = 'PAY-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);
    $data['status'] = 'verified'; // Admin created payments are auto-verified

    if ($request->hasFile('payment_proof')) {
      $file = $request->file('payment_proof');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('storage/payment_proofs'), $filename);
      $data['payment_proof'] = 'storage/payment_proofs/' . $filename;
    }

    Payment::create($data);

    return redirect()->route('admin.payments.index')
      ->with('success', 'Pembayaran berhasil dibuat');
  }

  public function show(Payment $payment)
  {
    $payment->load(['penyewaan.motor', 'penyewaan.penyewa']);

    return view('admin.payments.show', compact('payment'));
  }

  public function edit(Payment $payment)
  {
    $penyewaans = Penyewaan::with(['motor', 'penyewa'])->get();

    return view('admin.payments.edit', compact('payment', 'penyewaans'));
  }

  public function update(Request $request, Payment $payment)
  {
    $request->validate([
      'amount' => 'required|numeric|min:0',
      'payment_method' => 'required|in:cash,transfer,ewallet',
      'notes' => 'nullable|string'
    ]);

    $payment->update($request->only(['amount', 'payment_method', 'notes']));

    return redirect()->route('admin.payments.index')
      ->with('success', 'Pembayaran berhasil diupdate');
  }

  public function destroy(Payment $payment)
  {
    if ($payment->status === 'verified') {
      return back()->with('error', 'Tidak dapat menghapus pembayaran yang sudah diverifikasi');
    }

    $payment->delete();

    return redirect()->route('admin.payments.index')
      ->with('success', 'Pembayaran berhasil dihapus');
  }

  public function verify(Payment $payment)
  {
    $payment->update([
      'status' => 'verified',
      'verified_at' => now(),
      'verified_by' => Auth::id()
    ]);

    return back()->with('success', 'Pembayaran berhasil diverifikasi');
  }

  public function exportCsv()
  {
    $payments = Payment::with(['penyewaan.motor', 'penyewaan.penyewa'])->get();

    $filename = 'payments_' . date('Y-m-d') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($payments) {
      $file = fopen('php://output', 'w');

      // Header
      fputcsv($file, [
        'Kode Transaksi',
        'Penyewa',
        'Motor',
        'Jumlah',
        'Metode Pembayaran',
        'Status',
        'Tanggal Bayar',
        'Diverifikasi'
      ]);

      // Data
      foreach ($payments as $payment) {
        fputcsv($file, [
          $payment->transaction_code,
          $payment->penyewaan->penyewa->nama,
          $payment->penyewaan->motor->nama_motor,
          $payment->amount,
          $payment->payment_method,
          $payment->status,
          $payment->created_at->format('Y-m-d H:i:s'),
          $payment->verified_at ? $payment->verified_at->format('Y-m-d H:i:s') : '-'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  public function report(Request $request)
  {
    // Date filters
    $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
    $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

    // Payment statistics from penyewaan data
    $totalPayments = Penyewaan::whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();
    $totalAmount = Penyewaan::where('status', BookingStatus::COMPLETED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->sum('harga');
    $pendingPayments = Penyewaan::where('status', BookingStatus::CANCELLED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();
    $verifiedPayments = Penyewaan::where('status', BookingStatus::COMPLETED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();

    // Get detailed payment data
    $payments = Penyewaan::with(['motor', 'penyewa'])
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->orderBy('created_at', 'desc')
      ->get();

    // Transform data
    $payments->transform(function ($penyewaan) {
      $penyewaan->transaction_id = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->amount = $penyewaan->harga;
      $penyewaan->payment_method = 'cash';
      $penyewaan->payment_status = $penyewaan->status == BookingStatus::COMPLETED ? 'completed' : 'failed';
      return $penyewaan;
    });

    // Payment method breakdown (all COD/Cash)
    $paymentMethods = collect([
      (object)[
        'payment_method' => 'cash',
        'count' => $totalPayments,
        'total' => $totalAmount
      ]
    ]);

    // Daily payment trends
    $dailyTrends = Penyewaan::select(
      DB::raw('DATE(created_at) as date'),
      DB::raw('count(*) as count'),
      DB::raw('sum(harga) as total')
    )
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    return view('admin.payments.report', compact(
      'totalPayments',
      'totalAmount',
      'pendingPayments',
      'verifiedPayments',
      'paymentMethods',
      'dailyTrends',
      'payments',
      'startDate',
      'endDate'
    ));
  }

  public function exportPdf(Request $request)
  {
    // Date filters
    $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
    $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

    // Payment statistics from penyewaan data
    $totalPayments = Penyewaan::whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();
    $totalAmount = Penyewaan::where('status', BookingStatus::COMPLETED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->sum('harga');
    $pendingPayments = Penyewaan::where('status', BookingStatus::CANCELLED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();
    $verifiedPayments = Penyewaan::where('status', BookingStatus::COMPLETED)
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();

    // Get detailed payment data
    $payments = Penyewaan::with(['motor', 'penyewa'])
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->orderBy('created_at', 'desc')
      ->get();

    // Transform data
    $payments->transform(function ($penyewaan) {
      $penyewaan->transaction_id = 'TXN-' . str_pad($penyewaan->id, 6, '0', STR_PAD_LEFT);
      $penyewaan->amount = $penyewaan->harga;
      $penyewaan->payment_method = 'cash';
      $penyewaan->payment_status = $penyewaan->status == BookingStatus::COMPLETED ? 'completed' : 'failed';
      return $penyewaan;
    });

    // Payment method breakdown (all COD/Cash)
    $paymentMethods = collect([
      (object)[
        'payment_method' => 'cash',
        'count' => $totalPayments,
        'total' => $totalAmount
      ]
    ]);

    // Daily payment trends
    $dailyTrends = Penyewaan::select(
      DB::raw('DATE(created_at) as date'),
      DB::raw('count(*) as count'),
      DB::raw('sum(harga) as total')
    )
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    // Generate PDF
    $pdf = Pdf::loadView('admin.payments.report-pdf', compact(
      'totalPayments',
      'totalAmount',
      'pendingPayments',
      'verifiedPayments',
      'paymentMethods',
      'dailyTrends',
      'payments',
      'startDate',
      'endDate'
    ));

    $pdf->setPaper('a4', 'landscape');
    $pdf->setOptions([
      'isHtml5ParserEnabled' => true,
      'isPhpEnabled' => true,
      'defaultFont' => 'Arial'
    ]);

    $filename = 'laporan-pembayaran-' . date('Y-m-d-His') . '.pdf';
    return $pdf->download($filename);
  }

  public function exportExcel(Request $request)
  {
    // This would require a library like PhpSpreadsheet
    // For now, return a simple response
    return response()->json(['message' => 'Excel export feature coming soon']);
  }
}

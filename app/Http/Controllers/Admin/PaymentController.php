<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
  public function index(Request $request)
  {
    $query = Payment::with(['penyewaan.motor', 'penyewaan.user']);

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by payment method
    if ($request->filled('payment_method')) {
      $query->where('payment_method', $request->payment_method);
    }

    // Filter by date range
    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Search by transaction code or user name
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('transaction_code', 'like', "%{$search}%")
          ->orWhereHas('penyewaan.user', function ($sq) use ($search) {
            $sq->where('name', 'like', "%{$search}%");
          });
      });
    }

    $payments = $query->orderBy('created_at', 'desc')->paginate(10);

    // Statistics
    $totalPayments = Payment::count();
    $pendingPayments = Payment::where('status', 'pending')->count();
    $verifiedPayments = Payment::where('status', 'verified')->count();
    $totalAmount = Payment::where('status', 'verified')->sum('amount');

    // Payment method breakdown
    $paymentMethods = Payment::select('payment_method', DB::raw('count(*) as count'))
      ->groupBy('payment_method')
      ->pluck('count', 'payment_method');

    return view('admin.payments.index', compact(
      'payments',
      'totalPayments',
      'pendingPayments',
      'verifiedPayments',
      'totalAmount',
      'paymentMethods'
    ));
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
    $payment->load(['penyewaan.motor', 'penyewaan.user']);

    return view('admin.payments.show', compact('payment'));
  }

  public function edit(Payment $payment)
  {
    $penyewaans = Penyewaan::with(['motor', 'user'])->get();

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
    $payments = Payment::with(['penyewaan.motor', 'penyewaan.user'])->get();

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
          $payment->penyewaan->user->name,
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

    // Payment statistics
    $totalPayments = Payment::whereBetween('created_at', [$startDate, $endDate])->count();
    $totalAmount = Payment::where('status', 'verified')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->sum('amount');
    $pendingPayments = Payment::where('status', 'pending')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();
    $verifiedPayments = Payment::where('status', 'verified')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->count();

    // Payment method breakdown
    $paymentMethods = Payment::select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupBy('payment_method')
      ->get();

    // Daily payment trends
    $dailyTrends = Payment::select(
      DB::raw('DATE(created_at) as date'),
      DB::raw('count(*) as count'),
      DB::raw('sum(amount) as total')
    )
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
      'startDate',
      'endDate'
    ));
  }

  public function exportPdf(Request $request)
  {
    // This would require a PDF library like DomPDF or TCPDF
    // For now, return a simple response
    return response()->json(['message' => 'PDF export feature coming soon']);
  }

  public function exportExcel(Request $request)
  {
    // This would require a library like PhpSpreadsheet
    // For now, return a simple response
    return response()->json(['message' => 'Excel export feature coming soon']);
  }
}

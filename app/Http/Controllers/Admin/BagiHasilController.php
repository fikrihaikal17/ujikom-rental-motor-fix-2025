<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagiHasil;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BagiHasilController extends Controller
{
  public function index(Request $request)
  {
    $query = BagiHasil::with(['penyewaan.motor.user', 'penyewaan.user']);

    // Filter by status (based on settled_at column)
    if ($request->filled('status')) {
      if ($request->status === 'pending') {
        $query->whereNull('settled_at');
      } elseif ($request->status === 'settled') {
        $query->whereNotNull('settled_at');
      }
    }

    // Filter by date range
    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Search by owner name or motor
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->whereHas('penyewaan.motor.user', function ($sq) use ($search) {
          $sq->where('name', 'like', "%{$search}%");
        })
          ->orWhereHas('penyewaan.motor', function ($sq) use ($search) {
            $sq->where('nama_motor', 'like', "%{$search}%");
          });
      });
    }

    $bagiHasils = $query->orderBy('created_at', 'desc')->paginate(10);

    // Statistics
    $totalBagiHasil = BagiHasil::count();
    $totalPendapatan = BagiHasil::sum('total_pendapatan');
    $totalBagiHasilPemilik = BagiHasil::sum('bagi_hasil_pemilik');
    $totalBagiHasilAdmin = BagiHasil::sum('bagi_hasil_admin');
    $pendingSettlement = BagiHasil::whereNull('settled_at')->count();
    $settledCount = BagiHasil::whereNotNull('settled_at')->count();

    return view('admin.bagi-hasil.index', compact(
      'bagiHasils',
      'totalBagiHasil',
      'totalPendapatan',
      'totalBagiHasilPemilik',
      'totalBagiHasilAdmin',
      'pendingSettlement',
      'settledCount'
    ));
  }

  public function show(BagiHasil $bagiHasil)
  {
    $bagiHasil->load(['penyewaan.motor.user', 'penyewaan.user', 'penyewaan.payments']);

    return view('admin.bagi-hasil.show', compact('bagiHasil'));
  }

  public function process(BagiHasil $bagiHasil)
  {
    if ($bagiHasil->settled_at !== null) {
      return back()->with('error', 'Bagi hasil sudah diproses sebelumnya');
    }

    $bagiHasil->update([
      'settled_at' => now(),
    ]);

    return back()->with('success', 'Bagi hasil berhasil diproses');
  }

  public function exportPdf()
  {
    $bagiHasils = BagiHasil::with(['penyewaan.motor.user', 'penyewaan.motor'])->get();

    $data = [
      'bagiHasils' => $bagiHasils,
      'title' => 'Laporan Bagi Hasil',
      'date' => now()->format('d F Y'),
      'totalRevenue' => $bagiHasils->sum('total_pendapatan'),
      'totalOwnerShare' => $bagiHasils->sum('bagi_hasil_pemilik'),
      'totalAdminShare' => $bagiHasils->sum('bagi_hasil_admin'),
    ];

    $pdf = app('dompdf.wrapper')->loadView('admin.bagi-hasil.pdf', $data);
    return $pdf->download('bagi_hasil_' . date('Y-m-d') . '.pdf');
  }
}

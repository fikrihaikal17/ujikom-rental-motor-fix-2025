<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagiHasil;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BagiHasilController extends Controller
{
  public function index(Request $request)
  {
    $query = BagiHasil::with(['penyewaan.motor.user', 'penyewaan.user']);

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
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
    $pendingSettlement = BagiHasil::where('status', 'pending')->count();
    $settledCount = BagiHasil::where('status', 'settled')->count();

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
    if ($bagiHasil->status === 'settled') {
      return back()->with('error', 'Bagi hasil sudah diproses sebelumnya');
    }

    $bagiHasil->update([
      'status' => 'settled',
      'settled_at' => now(),
      'processed_by' => Auth::id()
    ]);

    return back()->with('success', 'Bagi hasil berhasil diproses');
  }

  public function exportCsv()
  {
    $bagiHasils = BagiHasil::with(['penyewaan.motor.user', 'penyewaan.motor'])->get();

    $filename = 'bagi_hasil_' . date('Y-m-d') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($bagiHasils) {
      $file = fopen('php://output', 'w');

      // Header
      fputcsv($file, [
        'ID',
        'Pemilik Motor',
        'Motor',
        'Total Pendapatan',
        'Bagi Hasil Pemilik',
        'Bagi Hasil Admin',
        'Persentase Pemilik',
        'Status',
        'Tanggal Dibuat',
        'Tanggal Diselesaikan'
      ]);

      // Data
      foreach ($bagiHasils as $bagiHasil) {
        fputcsv($file, [
          $bagiHasil->id,
          $bagiHasil->penyewaan->motor->user->name,
          $bagiHasil->penyewaan->motor->nama_motor,
          $bagiHasil->total_pendapatan,
          $bagiHasil->bagi_hasil_pemilik,
          $bagiHasil->bagi_hasil_admin,
          $bagiHasil->persentase_pemilik . '%',
          $bagiHasil->status,
          $bagiHasil->created_at->format('Y-m-d H:i:s'),
          $bagiHasil->settled_at ? $bagiHasil->settled_at->format('Y-m-d H:i:s') : '-'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller
{
  public function index(Request $request)
  {
    $query = Penyewaan::with(['motor', 'user', 'transaksi']);

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by date range
    if ($request->filled('start_date')) {
      $query->whereDate('tanggal_mulai', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
      $query->whereDate('tanggal_selesai', '<=', $request->end_date);
    }

    // Search by motor or user name
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->whereHas('motor', function ($sq) use ($search) {
          $sq->where('nama_motor', 'like', "%{$search}%")
            ->orWhere('nomor_polisi', 'like', "%{$search}%");
        })
          ->orWhereHas('user', function ($sq) use ($search) {
            $sq->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
          });
      });
    }

    $penyewaans = $query->orderBy('created_at', 'desc')->paginate(10);

    // Statistics
    $totalPenyewaan = Penyewaan::count();
    $pendingPenyewaan = Penyewaan::where('status', 'pending')->count();
    $activePenyewaan = Penyewaan::where('status', 'active')->count();
    $completedPenyewaan = Penyewaan::where('status', 'completed')->count();

    return view('admin.penyewaan.index', compact(
      'penyewaans',
      'totalPenyewaan',
      'pendingPenyewaan',
      'activePenyewaan',
      'completedPenyewaan'
    ));
  }

  public function create()
  {
    $motors = Motor::where('status', 'verified')->get();
    $users = User::where('role', 'penyewa')->get();

    return view('admin.penyewaan.create', compact('motors', 'users'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'user_id' => 'required|exists:users,id',
      'motor_id' => 'required|exists:motors,id',
      'tanggal_mulai' => 'required|date|after_or_equal:today',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
      'durasi_sewa' => 'required|integer|min:1',
      'total_harga' => 'required|numeric|min:0',
    ]);

    $penyewaan = Penyewaan::create($request->all());

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil dibuat');
  }

  public function show(Penyewaan $penyewaan)
  {
    $penyewaan->load(['motor', 'user', 'transaksi', 'payments']);

    return view('admin.penyewaan.show', compact('penyewaan'));
  }

  public function edit(Penyewaan $penyewaan)
  {
    $motors = Motor::where('status', 'verified')->get();
    $users = User::where('role', 'penyewa')->get();

    return view('admin.penyewaan.edit', compact('penyewaan', 'motors', 'users'));
  }

  public function update(Request $request, Penyewaan $penyewaan)
  {
    $request->validate([
      'user_id' => 'required|exists:users,id',
      'motor_id' => 'required|exists:motors,id',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
      'durasi_sewa' => 'required|integer|min:1',
      'total_harga' => 'required|numeric|min:0',
    ]);

    $penyewaan->update($request->all());

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil diupdate');
  }

  public function destroy(Penyewaan $penyewaan)
  {
    if ($penyewaan->status === 'active') {
      return back()->with('error', 'Tidak dapat menghapus penyewaan yang sedang aktif');
    }

    $penyewaan->delete();

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil dihapus');
  }

  public function updateStatus(Request $request, Penyewaan $penyewaan)
  {
    $request->validate([
      'status' => 'required|in:pending,confirmed,active,completed,cancelled'
    ]);

    $penyewaan->update(['status' => $request->status]);

    return back()->with('success', 'Status penyewaan berhasil diupdate');
  }

  public function exportCsv()
  {
    $penyewaans = Penyewaan::with(['motor', 'user'])->get();

    $filename = 'penyewaan_' . date('Y-m-d') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($penyewaans) {
      $file = fopen('php://output', 'w');

      // Header
      fputcsv($file, [
        'ID',
        'Penyewa',
        'Motor',
        'Tanggal Mulai',
        'Tanggal Selesai',
        'Durasi (Hari)',
        'Total Harga',
        'Status',
        'Dibuat'
      ]);

      // Data
      foreach ($penyewaans as $penyewaan) {
        fputcsv($file, [
          $penyewaan->id,
          $penyewaan->user->name,
          $penyewaan->motor->nama_motor,
          $penyewaan->tanggal_mulai,
          $penyewaan->tanggal_selesai,
          $penyewaan->durasi_sewa,
          $penyewaan->total_harga,
          $penyewaan->status,
          $penyewaan->created_at->format('Y-m-d H:i:s')
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}

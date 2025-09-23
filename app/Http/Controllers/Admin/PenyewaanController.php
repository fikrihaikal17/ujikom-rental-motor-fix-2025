<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\User;
use App\Enums\MotorStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PenyewaanController extends Controller
{
  public function index(Request $request)
  {
    $query = Penyewaan::with(['motor', 'penyewa', 'transaksi']);

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
            ->orWhere('no_plat', 'like', "%{$search}%");
        })
          ->orWhereHas('penyewa', function ($sq) use ($search) {
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
    $penyewaan->load(['motor', 'penyewa', 'transaksi', 'payments']);

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

    // Get the old status before updating
    $oldStatus = $penyewaan->status;

    // Update booking status
    $penyewaan->update(['status' => $request->status]);

    // Update motor status based on booking status
    $motor = $penyewaan->motor;
    if ($motor) {
      switch ($request->status) {
        case 'confirmed':
          // When booking is confirmed, motor should still be available until active
          if ($motor->status !== \App\Enums\MotorStatus::RENTED) {
            $motor->update(['status' => \App\Enums\MotorStatus::AVAILABLE]);
          }
          break;

        case 'active':
          // When booking becomes active, motor should be marked as rented
          $motor->update(['status' => \App\Enums\MotorStatus::RENTED]);
          break;

        case 'completed':
        case 'cancelled':
          // When booking is completed or cancelled, motor becomes available again
          // Only if this motor doesn't have other active bookings
          $hasOtherActiveBookings = $motor->penyewaans()
            ->where('id', '!=', $penyewaan->id)
            ->whereIn('status', ['confirmed', 'active'])
            ->exists();

          if (!$hasOtherActiveBookings) {
            $motor->update(['status' => \App\Enums\MotorStatus::AVAILABLE]);
          }
          break;
      }
    }

    return back()->with('success', 'Status penyewaan berhasil diupdate');
  }

  public function exportPdf(Request $request)
  {
    // Build query with same filtering as index
    $query = Penyewaan::with(['motor', 'penyewa', 'transaksi']);

    // Apply status filter if provided
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Apply date range filter
    if ($request->filled('start_date')) {
      $query->whereDate('tanggal_mulai', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
      $query->whereDate('tanggal_selesai', '<=', $request->end_date);
    }

    // Apply search filter
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->whereHas('motor', function ($sq) use ($search) {
          $sq->where('nama_motor', 'like', "%{$search}%")
            ->orWhere('no_plat', 'like', "%{$search}%");
        })
          ->orWhereHas('penyewa', function ($sq) use ($search) {
            $sq->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
          });
      });
    }

    // Get all matching penyewaans (no pagination for export)
    $penyewaans = $query->orderBy('created_at', 'desc')->get();

    // Generate statistics for the current filter
    $stats = [
      'total' => $penyewaans->count(),
      'pending' => $penyewaans->where('status', 'pending')->count(),
      'confirmed' => $penyewaans->where('status', 'confirmed')->count(),
      'active' => $penyewaans->where('status', 'active')->count(),
      'completed' => $penyewaans->where('status', 'completed')->count(),
      'cancelled' => $penyewaans->where('status', 'cancelled')->count(),
      'total_revenue' => $penyewaans->whereIn('status', ['completed'])->sum('total_harga'),
    ];

    // Get filter information for display
    $filterInfo = [
      'status' => $request->status ?? 'all',
      'start_date' => $request->start_date ?? '',
      'end_date' => $request->end_date ?? '',
      'search' => $request->search ?? '',
      'date' => now()->format('d/m/Y H:i:s')
    ];

    // Generate PDF
    $pdf = Pdf::loadView('admin.penyewaan.export-pdf', compact('penyewaans', 'stats', 'filterInfo'))
      ->setPaper('a4', 'landscape');

    // Generate filename based on filter
    $filename = 'data-penyewaan';
    if ($request->filled('status')) {
      $filename .= '-' . $request->status;
    }
    if ($request->filled('start_date') || $request->filled('end_date')) {
      $filename .= '-periode';
    }
    $filename .= '-' . now()->format('Y-m-d') . '.pdf';

    return $pdf->download($filename);
  }
}

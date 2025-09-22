<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotorVerificationController extends Controller
{
  public function index()
  {
    // Get motors that need verification (pending status)
    $pendingMotors = Motor::where('status', 'pending')
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'pending');

    // Get all motors for overview
    $verifiedMotors = Motor::where('status', 'verified')
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'verified');

    $rejectedMotors = Motor::where('status', 'rejected')
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'rejected');

    // Statistics
    $stats = [
      'total' => Motor::count(),
      'pending' => Motor::where('status', 'pending')->count(),
      'verified' => Motor::where('status', 'verified')->count(),
      'rejected' => Motor::where('status', 'rejected')->count(),
    ];

    return view('admin.motors.index', compact('pendingMotors', 'verifiedMotors', 'rejectedMotors', 'stats'));
  }

  public function show(Motor $motor)
  {
    $motor->load(['owner', 'tarifRental', 'penyewaans.renter']);
    return view('admin.motors.show', compact('motor'));
  }

  public function verify(Request $request, Motor $motor)
  {
    $request->validate([
      'notes' => 'nullable|string|max:500'
    ]);

    $motor->update([
      'status' => 'verified',
      'admin_notes' => $request->notes,
      'verified_at' => now(),
      'verified_by' => Auth::id()
    ]);

    return redirect()->route('admin.motors.index')
      ->with('success', "Motor {$motor->merk} {$motor->model} berhasil diverifikasi.");
  }

  public function reject(Request $request, Motor $motor)
  {
    $request->validate([
      'notes' => 'required|string|max:500'
    ]);

    $motor->update([
      'status' => 'rejected',
      'admin_notes' => $request->notes,
      'verified_at' => null,
      'verified_by' => null
    ]);

    return redirect()->route('admin.motors.index')
      ->with('success', "Motor {$motor->merk} {$motor->model} telah ditolak.");
  }

  public function export()
  {
    $filename = 'motors_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () {
      $file = fopen('php://output', 'w');

      // Header CSV
      fputcsv($file, ['ID', 'Merk', 'Model', 'Plat Nomor', 'Pemilik', 'Email Pemilik', 'Status', 'Ketersediaan', 'Tanggal Daftar', 'Tanggal Verifikasi', 'Catatan Admin']);

      // Data
      $motors = Motor::with(['owner'])->get();
      foreach ($motors as $motor) {
        fputcsv($file, [
          $motor->id,
          $motor->merk,
          $motor->model,
          $motor->plat_nomor,
          $motor->owner->nama ?? '-',
          $motor->owner->email ?? '-',
          ucfirst($motor->status),
          ucfirst($motor->ketersediaan),
          $motor->created_at->format('Y-m-d H:i:s'),
          $motor->verified_at ? $motor->verified_at->format('Y-m-d H:i:s') : '-',
          $motor->admin_notes ?? '-'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}

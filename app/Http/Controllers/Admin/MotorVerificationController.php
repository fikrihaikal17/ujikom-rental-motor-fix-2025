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
    $pendingMotors = Motor::where('status', \App\Enums\MotorStatus::PENDING)
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'pending');

    // Get all motors for overview
    $verifiedMotors = Motor::where('status', \App\Enums\MotorStatus::VERIFIED)
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'verified');

    $rejectedMotors = Motor::where('status', \App\Enums\MotorStatus::PENDING)
      ->whereNotNull('admin_notes')
      ->with(['owner', 'tarifRental'])
      ->latest()
      ->paginate(10, ['*'], 'rejected');

    // Statistics
    $stats = [
      'total' => Motor::count(),
      'pending' => Motor::where('status', \App\Enums\MotorStatus::PENDING)->count(),
      'verified' => Motor::where('status', \App\Enums\MotorStatus::VERIFIED)->count(),
      'rejected' => Motor::where('status', \App\Enums\MotorStatus::PENDING)->whereNotNull('admin_notes')->count(),
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
      'notes' => 'nullable|string|max:500',
      'tarif_harian' => 'required|numeric|min:0',
      'tarif_mingguan' => 'required|numeric|min:0',
      'tarif_bulanan' => 'required|numeric|min:0'
    ]);

    // Update motor status
    $motor->update([
      'status' => \App\Enums\MotorStatus::VERIFIED,
      'admin_notes' => $request->notes,
      'verified_at' => now(),
      'verified_by' => Auth::id()
    ]);

    // Create or update tarif rental
    $motor->tarifRental()->updateOrCreate(
      ['motor_id' => $motor->id],
      [
        'tarif_harian' => $request->tarif_harian,
        'tarif_mingguan' => $request->tarif_mingguan,
        'tarif_bulanan' => $request->tarif_bulanan,
        'is_active' => true,
      ]
    );

    return redirect()->route('admin.motors.index')
      ->with('success', "Motor {$motor->merk} {$motor->model} berhasil diverifikasi dengan harga sewa yang telah ditetapkan.");
  }

  public function reject(Request $request, Motor $motor)
  {
    $request->validate([
      'notes' => 'required|string|max:500'
    ]);

    $motor->update([
      'status' => \App\Enums\MotorStatus::PENDING, // Keep as pending for re-review
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

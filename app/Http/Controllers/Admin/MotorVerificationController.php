<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MotorVerificationController extends Controller
{
  public function index(Request $request)
  {
    // Build base query
    $query = Motor::with(['owner', 'tarifRental']);

    // Apply status filter if provided
    if ($request->filled('status')) {
      if ($request->status === 'verified') {
        $query->where('status', \App\Enums\MotorStatus::VERIFIED);
      } elseif ($request->status === 'pending') {
        $query->where('status', \App\Enums\MotorStatus::PENDING)
          ->whereNull('admin_notes');
      } elseif ($request->status === 'rejected') {
        $query->where('status', \App\Enums\MotorStatus::PENDING)
          ->whereNotNull('admin_notes');
      }
    }

    // Apply search filter
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('merk', 'like', "%{$search}%")
          ->orWhere('model', 'like', "%{$search}%")
          ->orWhere('nama_motor', 'like', "%{$search}%")
          ->orWhere('plat_nomor', 'like', "%{$search}%")
          ->orWhere('no_plat', 'like', "%{$search}%")
          ->orWhereHas('owner', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
          });
      });
    }

    // Get paginated results
    $motors = $query->latest()->paginate(15)->withQueryString();

    // Get motors that need verification (pending status without admin notes)
    $pendingMotors = Motor::where('status', \App\Enums\MotorStatus::PENDING)
      ->whereNull('admin_notes')
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
      'pending' => Motor::where('status', \App\Enums\MotorStatus::PENDING)->whereNull('admin_notes')->count(),
      'verified' => Motor::where('status', \App\Enums\MotorStatus::VERIFIED)->count(),
      'rejected' => Motor::where('status', \App\Enums\MotorStatus::PENDING)->whereNotNull('admin_notes')->count(),
    ];

    return view('admin.motors.index', compact('motors', 'pendingMotors', 'verifiedMotors', 'rejectedMotors', 'stats'));
  }

  public function show(Motor $motor)
  {
    $motor->load(['owner', 'tarifRental', 'penyewaans.renter', 'verifiedBy']);
    return view('admin.motors.show', compact('motor'));
  }

  public function verify(Request $request, Motor $motor)
  {
    $request->validate([
      'notes' => 'nullable|string|max:500',
      'tarif_harian' => 'required|numeric|min:0',
      'tarif_mingguan' => 'required|numeric|min:0',
      'tarif_bulanan' => 'required|numeric|min:0',
      'owner_percentage' => 'required|numeric|min:50|max:90',
      'admin_percentage' => 'required|numeric|min:10|max:50',
    ]);

    // Validate that percentages add up to 100
    if ($request->owner_percentage + $request->admin_percentage != 100) {
      return back()->withErrors(['owner_percentage' => 'Persentase pemilik dan admin harus berjumlah 100%']);
    }

    // Update motor status and revenue sharing
    $motor->update([
      'status' => \App\Enums\MotorStatus::VERIFIED,
      'admin_notes' => $request->notes,
      'verified_at' => now(),
      'verified_by' => Auth::id(),
      'owner_percentage' => $request->owner_percentage,
      'admin_percentage' => $request->admin_percentage,
      'revenue_sharing_approved' => true,
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
      ->with('success', "Motor {$motor->merk} {$motor->model} berhasil diverifikasi dengan pembagian hasil {$request->owner_percentage}% untuk pemilik dan {$request->admin_percentage}% untuk platform.");
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

  public function exportPdf(Request $request)
  {
    // Build query with same filtering as index
    $query = Motor::with(['owner', 'tarifRental']);

    // Apply status filter if provided
    if ($request->filled('status')) {
      if ($request->status === 'verified') {
        $query->where('status', \App\Enums\MotorStatus::VERIFIED);
      } elseif ($request->status === 'pending') {
        $query->where('status', \App\Enums\MotorStatus::PENDING)
          ->whereNull('admin_notes');
      } elseif ($request->status === 'rejected') {
        $query->where('status', \App\Enums\MotorStatus::PENDING)
          ->whereNotNull('admin_notes');
      }
    }

    // Apply search filter
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('merk', 'like', "%{$search}%")
          ->orWhere('model', 'like', "%{$search}%")
          ->orWhere('nama_motor', 'like', "%{$search}%")
          ->orWhere('plat_nomor', 'like', "%{$search}%")
          ->orWhere('no_plat', 'like', "%{$search}%")
          ->orWhereHas('owner', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
          });
      });
    }

    // Get all matching motors (no pagination for export)
    $motors = $query->latest()->get();

    // Generate statistics for the current filter
    $stats = [
      'total' => $motors->count(),
      'pending' => $motors->where('status', \App\Enums\MotorStatus::PENDING->value)->where('admin_notes', null)->count(),
      'verified' => $motors->where('status', \App\Enums\MotorStatus::VERIFIED->value)->count(),
      'rejected' => $motors->where('status', \App\Enums\MotorStatus::PENDING->value)->whereNotNull('admin_notes')->count(),
    ];

    // Get filter information for display
    $filterInfo = [
      'status' => $request->status ?? 'all',
      'search' => $request->search ?? '',
      'date' => now()->format('d/m/Y H:i:s')
    ];

    // Generate PDF
    $pdf = Pdf::loadView('admin.motors.export-pdf', compact('motors', 'stats', 'filterInfo'))
      ->setPaper('a4', 'landscape');

    // Generate filename based on filter
    $filename = 'data-motor';
    if ($request->filled('status')) {
      $filename .= '-' . $request->status;
    }
    $filename .= '-' . now()->format('Y-m-d') . '.pdf';

    return $pdf->download($filename);
  }
}

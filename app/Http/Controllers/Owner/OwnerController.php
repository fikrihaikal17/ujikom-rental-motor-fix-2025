<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\TarifRental;
use App\Models\Transaksi;
use App\Models\BagiHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
  public function dashboard()
  {
    $owner = Auth::user();

    // Statistics for owner's motors
    $stats = [
      'total_motors' => Motor::where('user_id', $owner->id)->count(),
      'verified_motors' => Motor::where('user_id', $owner->id)->where('status', 'verified')->count(),
      'pending_motors' => Motor::where('user_id', $owner->id)->where('status', 'pending')->count(),
      'active_rentals' => Penyewaan::whereHas('motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->where('status', 'active')->count(),
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'monthly_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik')
    ];

    // Recent motors
    $recentMotors = Motor::where('user_id', $owner->id)
      ->latest()
      ->take(5)
      ->get();

    // Recent rentals
    $recentRentals = Penyewaan::whereHas('motor', function ($q) use ($owner) {
      $q->where('user_id', $owner->id);
    })->with(['motor', 'renter'])->latest()->take(5)->get();

    // Revenue trend (last 6 months)
    $revenueTrend = [];
    for ($i = 5; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $revenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('bagi_hasil_pemilik');

      $revenueTrend[] = [
        'month' => $date->format('M Y'),
        'revenue' => $revenue
      ];
    }

    return view('owner.dashboard', compact('stats', 'recentMotors', 'recentRentals', 'revenueTrend'));
  }

  public function motors()
  {
    $owner = Auth::user();
    $motors = Motor::where('user_id', $owner->id)
      ->with(['tarifRental'])
      ->withCount(['penyewaans as total_rentals'])
      ->withSum(['penyewaans as total_revenue' => function ($q) {
        $q->join('bagi_hasils', 'penyewaans.id', '=', 'bagi_hasils.penyewaan_id');
      }], 'bagi_hasils.bagi_hasil_pemilik')
      ->paginate(10);

    return view('owner.motors.index', compact('motors'));
  }

  public function createMotor()
  {
    return view('owner.motors.create');
  }

  public function storeMotor(Request $request)
  {
    $request->validate([
      'merk' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'tipe_cc' => 'required|in:100,125,150',
      'plat_nomor' => 'required|string|max:20|unique:motors',
      'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
      'dokumen_kepemilikan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
      'deskripsi' => 'nullable|string|max:1000'
    ]);

    $owner = Auth::user();

    // Upload foto
    $fotoPath = null;
    if ($request->hasFile('foto')) {
      $fotoPath = $request->file('foto')->store('motors/photos', 'public');
    }

    // Upload dokumen
    $dokumenPath = null;
    if ($request->hasFile('dokumen_kepemilikan')) {
      $dokumenPath = $request->file('dokumen_kepemilikan')->store('motors/documents', 'public');
    }

    Motor::create([
      'user_id' => $owner->id,
      'merk' => $request->merk,
      'model' => $request->model,
      'tipe_cc' => $request->tipe_cc,
      'plat_nomor' => strtoupper($request->plat_nomor),
      'foto' => $fotoPath,
      'dokumen_kepemilikan' => $dokumenPath,
      'deskripsi' => $request->deskripsi,
      'status' => 'pending',
      'ketersediaan' => 'tersedia'
    ]);

    return redirect()->route('owner.motors.index')
      ->with('success', 'Motor berhasil didaftarkan! Silakan tunggu verifikasi dari admin.');
  }

  public function showMotor(Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->user_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    $motor->load(['tarifRental', 'penyewaans.renter', 'penyewaans.bagiHasil']);

    // Calculate revenue statistics
    $totalRevenue = BagiHasil::whereHas('penyewaan', function ($q) use ($motor) {
      $q->where('motor_id', $motor->id);
    })->sum('bagi_hasil_pemilik');

    $monthlyRevenue = BagiHasil::whereHas('penyewaan', function ($q) use ($motor) {
      $q->where('motor_id', $motor->id);
    })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik');

    return view('owner.motors.show', compact('motor', 'totalRevenue', 'monthlyRevenue'));
  }

  public function editMotor(Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->user_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    return view('owner.motors.edit', compact('motor'));
  }

  public function updateMotor(Request $request, Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->user_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    $request->validate([
      'merk' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'tipe_cc' => 'required|in:100,125,150',
      'plat_nomor' => 'required|string|max:20|unique:motors,plat_nomor,' . $motor->id,
      'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'dokumen_kepemilikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
      'deskripsi' => 'nullable|string|max:1000'
    ]);

    $updateData = [
      'merk' => $request->merk,
      'model' => $request->model,
      'tipe_cc' => $request->tipe_cc,
      'plat_nomor' => strtoupper($request->plat_nomor),
      'deskripsi' => $request->deskripsi,
    ];

    // Upload new foto if provided
    if ($request->hasFile('foto')) {
      // Delete old foto
      if ($motor->foto) {
        Storage::disk('public')->delete($motor->foto);
      }
      $updateData['foto'] = $request->file('foto')->store('motors/photos', 'public');
    }

    // Upload new dokumen if provided
    if ($request->hasFile('dokumen_kepemilikan')) {
      // Delete old dokumen
      if ($motor->dokumen_kepemilikan) {
        Storage::disk('public')->delete($motor->dokumen_kepemilikan);
      }
      $updateData['dokumen_kepemilikan'] = $request->file('dokumen_kepemilikan')->store('motors/documents', 'public');
    }

    $motor->update($updateData);

    return redirect()->route('owner.motors.show', $motor)
      ->with('success', 'Data motor berhasil diperbarui!');
  }

  public function revenue()
  {
    $owner = Auth::user();

    // Get revenue data grouped by motor
    $motorRevenues = Motor::where('user_id', $owner->id)
      ->with(['bagiHasils' => function ($q) {
        $q->orderBy('created_at', 'desc');
      }])
      ->withSum('bagiHasils as total_revenue', 'bagi_hasil_pemilik')
      ->get();

    // Total statistics
    $stats = [
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'this_month' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik'),
      'pending_settlements' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->whereNull('settled_at')->count(),
      'settled_count' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->whereNotNull('settled_at')->count()
    ];

    // Recent transactions
    $recentTransactions = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('user_id', $owner->id);
    })->with(['penyewaan.motor', 'penyewaan.renter'])
      ->latest()
      ->take(10)
      ->get();

    return view('owner.revenue', compact('motorRevenues', 'stats', 'recentTransactions'));
  }

  public function exportRevenue()
  {
    $owner = Auth::user();
    $filename = 'revenue_export_' . $owner->nama . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($owner) {
      $file = fopen('php://output', 'w');

      // Header CSV
      fputcsv($file, ['Tanggal', 'Motor', 'Penyewa', 'Durasi Sewa', 'Total Sewa', 'Bagi Hasil Owner', 'Status Settlement']);

      // Data
      $revenues = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('user_id', $owner->id);
      })->with(['penyewaan.motor', 'penyewaan.renter'])->get();

      foreach ($revenues as $revenue) {
        fputcsv($file, [
          $revenue->created_at->format('Y-m-d'),
          $revenue->penyewaan->motor->merk . ' ' . $revenue->penyewaan->motor->model,
          $revenue->penyewaan->renter->nama,
          $revenue->penyewaan->tipe_durasi,
          'Rp ' . number_format($revenue->penyewaan->harga, 0, ',', '.'),
          'Rp ' . number_format($revenue->bagi_hasil_pemilik, 0, ',', '.'),
          $revenue->settled_at ? 'Settled' : 'Pending'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}

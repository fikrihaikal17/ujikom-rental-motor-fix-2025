<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\TarifRental;
use App\Models\Transaksi;
use App\Models\BagiHasil;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnerController extends Controller
{
  public function dashboard()
  {
    $owner = Auth::user();

    // Statistics for owner's motors
    $stats = [
      'total_motors' => Motor::where('pemilik_id', $owner->id)->count(),
      'verified_motors' => Motor::where('pemilik_id', $owner->id)->where('status', \App\Enums\MotorStatus::VERIFIED)->count(),
      'pending_verifications' => Motor::where('pemilik_id', $owner->id)->where('status', \App\Enums\MotorStatus::PENDING)->count(),
      'active_rentals' => Penyewaan::whereHas('motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->where('status', \App\Enums\BookingStatus::ACTIVE)->count(),
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'monthly_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik')
    ];

    // Recent motors
    $recent_motors = Motor::where('pemilik_id', $owner->id)
      ->latest()
      ->take(5)
      ->get();

    // Recent rentals
    $recentRentals = Penyewaan::whereHas('motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->with(['motor', 'penyewa'])->latest()->take(5)->get();

    // Revenue trend (last 6 months)
    $labels = [];
    $data = [];
    for ($i = 5; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $revenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('bagi_hasil_pemilik');

      $labels[] = $date->format('M Y');
      $data[] = $revenue;
    }

    $chart_data = [
      'labels' => $labels,
      'data' => $data
    ];

    return view('owner.dashboard', compact('stats', 'recent_motors', 'recentRentals', 'chart_data', 'owner'));
  }

  public function motors(Request $request)
  {
    $owner = Auth::user();

    $query = Motor::where('pemilik_id', $owner->id)
      ->with(['tarifRental'])
      ->withCount(['penyewaans as total_rentals'])
      ->withSum(['penyewaans as total_revenue' => function ($q) {
        $q->join('bagi_hasils', 'penyewaans.id', '=', 'bagi_hasils.penyewaan_id');
      }], 'bagi_hasils.bagi_hasil_pemilik');

    // Filter by search term
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('merk', 'like', "%{$search}%")
          ->orWhere('model', 'like', "%{$search}%")
          ->orWhere('no_plat', 'like', "%{$search}%");
      });
    }

    // Filter by status
    if ($request->filled('status')) {
      $status = $request->status;
      $query->where('status', $status);
    }

    $motors = $query->paginate(10)->withQueryString();

    return view('owner.motors.index', compact('motors'));
  }

  public function createMotor()
  {
    return view('owner.motors.create');
  }

  public function storeMotor(Request $request)
  {
    $request->validate([
      'nama_motor' => 'required|string|max:255',
      'merk' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'tahun' => 'required|integer|min:2010|max:' . date('Y'),
      'tipe_cc' => 'required|in:100,125,150',
      'no_plat' => 'nullable|string|max:20|unique:motors,no_plat',
      'warna' => 'nullable|string|max:50',
      'harga_per_hari' => 'required|string|max:255',
      'deskripsi' => 'required|string|max:1000',
      'foto_motor' => 'required|image|mimes:jpeg,png,jpg|max:2048',
      'dokumen_kepemilikan' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120', // 5MB max
      'requested_owner_percentage' => 'nullable|numeric|min:50|max:90',
      'revenue_sharing_notes' => 'nullable|string|max:500',
    ]);

    $owner = Auth::user();

    // Clean and convert price (remove dots and convert to integer)
    $harga = (int) str_replace(['.', ',', ' ', 'Rp'], '', $request->harga_per_hari);

    // CC langsung dari form (sudah 100, 125, atau 150)
    $tipe_cc = $request->tipe_cc;

    // Upload foto ke storage/app/public/motors
    $fotoPath = null;
    if ($request->hasFile('foto_motor')) {
      $file = $request->file('foto_motor');
      $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $fotoPath = $file->storeAs('motors', $fileName, 'public');

      // Debug logging
      Log::info('File upload debug:', [
        'has_file' => $request->hasFile('foto_motor'),
        'original_name' => $file->getClientOriginalName(),
        'size' => $file->getSize(),
        'mime_type' => $file->getMimeType(),
        'generated_filename' => $fileName,
        'storage_path' => $fotoPath,
        'full_path' => storage_path('app/public/' . $fotoPath),
        'file_exists' => file_exists(storage_path('app/public/' . $fotoPath))
      ]);
    } else {
      Log::error('No file uploaded in foto_motor field');
    }

    // Upload dokumen kepemilikan
    $dokumenPath = null;
    if ($request->hasFile('dokumen_kepemilikan')) {
      $file = $request->file('dokumen_kepemilikan');
      $fileName = 'dokumen_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $dokumenPath = $file->storeAs('motors/documents', $fileName, 'public');
    }

    $motor = Motor::create([
      'pemilik_id' => $owner->id,
      'merk' => $request->merk,
      'nama_motor' => $request->nama_motor,
      'model' => $request->model,
      'tahun' => $request->tahun,
      'tipe_cc' => $tipe_cc,
      'no_plat' => $request->no_plat ? strtoupper($request->no_plat) : null,
      'warna' => $request->warna,
      'deskripsi' => $request->deskripsi,
      'photo' => $fotoPath,
      'dokumen_kepemilikan' => $dokumenPath,
      'status' => 'pending',
      'requested_owner_percentage' => $request->requested_owner_percentage ?? 70.00,
      'revenue_sharing_notes' => $request->revenue_sharing_notes,
    ]);

    // Create tarif rental entry
    TarifRental::create([
      'motor_id' => $motor->id,
      'tarif_harian' => $harga,
      'tarif_mingguan' => $harga * 6, // 6x daily rate for weekly
      'tarif_bulanan' => $harga * 25, // 25x daily rate for monthly
      'is_active' => true,
    ]);

    return redirect()->route('owner.motors.index')
      ->with('success', 'Motor berhasil didaftarkan! Silakan tunggu verifikasi dari admin.');
  }

  public function showMotor(Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    $motor->load(['tarifRental', 'penyewaans.penyewa', 'penyewaans.bagiHasil']);

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
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    return view('owner.motors.edit', compact('motor'));
  }

  public function updateMotor(Request $request, Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    $request->validate([
      'merk' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'tipe_cc' => 'required|in:100,125,150',
      'no_plat' => 'required|string|max:20|unique:motors,no_plat,' . $motor->id,
      'warna' => 'nullable|string|max:50',
      'foto_motor' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'dokumen_kepemilikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
      'deskripsi' => 'nullable|string|max:1000'
    ]);

    $updateData = [
      'merk' => $request->merk,
      'model' => $request->model,
      'tipe_cc' => $request->tipe_cc,
      'no_plat' => strtoupper($request->no_plat),
      'warna' => $request->warna,
      'deskripsi' => $request->deskripsi,
    ];

    // Upload new foto if provided
    if ($request->hasFile('foto_motor')) {
      // Delete old photo
      if ($motor->photo) {
        Storage::disk('public')->delete($motor->photo);
      }
      $updateData['photo'] = $request->file('foto_motor')->store('motors/photos', 'public');
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

  public function destroyMotor(Motor $motor)
  {
    // Check if motor belongs to current owner
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    // Check if motor has active rentals
    $activeRentals = $motor->penyewaans()
      ->whereIn('status', ['pending', 'confirmed', 'active'])
      ->count();

    if ($activeRentals > 0) {
      return redirect()->route('owner.motors.show', $motor)
        ->with('error', 'Motor tidak dapat dihapus karena masih memiliki penyewaan aktif atau pending.');
    }

    // Delete associated files
    if ($motor->photo) {
      Storage::disk('public')->delete($motor->photo);
    }
    if ($motor->dokumen_kepemilikan) {
      Storage::disk('public')->delete($motor->dokumen_kepemilikan);
    }

    // Delete motor and related data
    $motor->delete();

    return redirect()->route('owner.motors.index')
      ->with('success', 'Motor berhasil dihapus dari sistem.');
  }

  public function revenue()
  {
    $owner = Auth::user();

    // Get revenue data grouped by motor
    $motorRevenues = Motor::where('pemilik_id', $owner->id)
      ->with(['bagiHasils' => function ($q) {
        $q->orderBy('created_at', 'desc');
      }])
      ->withSum('bagiHasils as total_revenue', 'bagi_hasil_pemilik')
      ->get();

    // Total statistics
    $stats = [
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'this_month' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik'),
      'pending_settlements' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereNull('settled_at')->count(),
      'settled_count' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereNotNull('settled_at')->count()
    ];

    // Recent transactions
    $recentTransactions = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->with(['penyewaan.motor', 'penyewaan.penyewa'])
      ->latest()
      ->take(10)
      ->get();

    return view('owner.revenue.index', compact('motorRevenues', 'stats', 'recentTransactions'));
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
      fputcsv($file, ['Tanggal', 'Motor', 'Penyewa', 'Durasi Sewa', 'Total Sewa', 'Status']);

      // Data from completed rentals
      $revenues = Penyewaan::whereHas('motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })
        ->where('status', BookingStatus::COMPLETED)
        ->with(['motor', 'penyewa'])
        ->get();

      foreach ($revenues as $revenue) {
        fputcsv($file, [
          $revenue->created_at->format('Y-m-d'),
          $revenue->motor->merk,
          $revenue->penyewa->nama,
          $revenue->tipe_durasi->getDisplayName(),
          'Rp ' . number_format($revenue->harga, 0, ',', '.'),
          $revenue->status->getDisplayName()
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  /**
   * Export revenue report to PDF
   */
  public function exportRevenuePDF()
  {
    $owner = Auth::user();

    // Get monthly revenue data
    $monthlyData = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->selectRaw('MONTH(created_at) as month, SUM(harga) as total, COUNT(*) as count')
      ->whereYear('created_at', now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    // Get top performing motors
    $topMotors = Motor::where('pemilik_id', $owner->id)
      ->withSum(['penyewaans as total_revenue' => function ($query) {
        $query->where('status', BookingStatus::COMPLETED)
          ->whereYear('created_at', now()->year);
      }], 'harga')
      ->having('total_revenue', '>', 0)
      ->orderByDesc('total_revenue')
      ->take(5)
      ->get();

    // Calculate total revenue for the year
    $totalYearRevenue = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->whereYear('created_at', now()->year)
      ->sum('harga');

    $pdf = Pdf::loadView('owner.revenue.pdf', compact(
      'owner',
      'monthlyData',
      'topMotors',
      'totalYearRevenue'
    ));

    $filename = 'laporan_pendapatan_' . $owner->nama . '_' . now()->year . '.pdf';

    return $pdf->download($filename);
  }

  /**
   * Show rentals management page
   */
  public function rentals()
  {
    $owner = Auth::user();

    $rentals = Penyewaan::whereHas('motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->with(['motor', 'penyewa', 'payments'])->latest()->paginate(15);

    return view('owner.rentals.index', compact('rentals'));
  }

  /**
   * Show specific rental details
   */
  public function showRental(Penyewaan $penyewaan)
  {
    $owner = Auth::user();

    // Check if this rental belongs to owner's motor
    if ($penyewaan->motor->pemilik_id !== $owner->id) {
      abort(403, 'Unauthorized access');
    }

    $penyewaan->load(['motor', 'penyewa', 'payments', 'bagiHasil']);

    return view('owner.rentals.show', compact('penyewaan'));
  }

  /**
   * Show profile page
   */
  public function profile()
  {
    $user = Auth::user();
    return view('owner.profile', compact('user'));
  }

  /**
   * Update profile
   */
  public function updateProfile(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
      'phone' => 'nullable|string|max:15',
      'address' => 'nullable|string',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->update($request->only(['name', 'email', 'phone', 'address']));

    return redirect()->route('owner.profile')->with('success', 'Profil berhasil diperbarui');
  }

  /**
   * Show settings page
   */
  public function settings()
  {
    $user = Auth::user();
    return view('owner.settings', compact('user'));
  }

  /**
   * Update settings
   */
  public function updateSettings(Request $request)
  {
    $request->validate([
      'password' => 'nullable|string|min:8|confirmed',
      'notification_email' => 'boolean',
      'notification_sms' => 'boolean',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($request->filled('password')) {
      $user->update(['password' => bcrypt($request->password)]);
    }

    // Update other settings if needed
    // For now just redirect back with success

    return redirect()->route('owner.settings')->with('success', 'Pengaturan berhasil diperbarui');
  }

  /**
   * Display revenue history page
   */
  public function revenueHistory()
  {
    $owner = Auth::user();

    // Get revenue history with pagination
    $revenueHistory = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })
      ->with(['penyewaan.motor', 'penyewaan.penyewa'])
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    // Get monthly revenue summary
    $monthlyRevenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })
      ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(bagi_hasil_pemilik) as total')
      ->groupBy('year', 'month')
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->take(12)
      ->get();

    // Get revenue statistics
    $stats = [
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'this_month' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik'),
      'last_month' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', now()->subMonth()->month)->sum('bagi_hasil_pemilik'),
      'this_year' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereYear('created_at', now()->year)->sum('bagi_hasil_pemilik'),
    ];

    // Add totalRevenueThisYear variable for the view
    $totalRevenueThisYear = $stats['this_year'];

    return view('owner.revenue.history', compact('revenueHistory', 'monthlyRevenue', 'stats', 'totalRevenueThisYear'));
  }

  /**
   * Get total revenue data for dashboard
   */
  public function totalRevenue()
  {
    $owner = Auth::user();

    // Get monthly revenue breakdown for charts from completed rentals
    $monthlyData = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->selectRaw('MONTH(created_at) as month, SUM(harga) as total')
      ->whereYear('created_at', now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    // Get top performing motors based on total earnings
    $topMotors = Motor::where('pemilik_id', $owner->id)
      ->withSum(['penyewaans as total_revenue' => function ($query) {
        $query->where('status', BookingStatus::COMPLETED)
          ->whereYear('created_at', now()->year);
      }], 'harga')
      ->having('total_revenue', '>', 0)
      ->orderByDesc('total_revenue')
      ->take(5)
      ->get();

    // Calculate total revenue for the year
    $totalYearRevenue = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->whereYear('created_at', now()->year)
      ->sum('harga');

    return view('owner.revenue.total', compact('monthlyData', 'topMotors', 'totalYearRevenue'));
  }

  /**
   * Display rental reports page
   */
  public function rentalsReport()
  {
    $owner = Auth::user();

    // Get rental statistics
    $totalRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })->count();

    $activeRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::ACTIVE)
      ->count();

    $completedRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->count();

    // Get recent rentals using Eloquent with proper relationship loading
    $recentRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->with(['motor:id,merk,no_plat', 'penyewa:id,nama'])
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    // Monthly rental count for chart
    $monthlyRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
      ->whereYear('created_at', now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    return view('owner.reports.rentals', compact(
      'totalRentals',
      'activeRentals',
      'completedRentals',
      'recentRentals',
      'monthlyRentals'
    ));
  }

  /**
   * Export rentals report to PDF
   */
  public function exportRentalsPDF()
  {
    $owner = Auth::user();

    // Get rental statistics
    $totalRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })->count();

    $activeRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::ACTIVE)
      ->count();

    $completedRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->where('status', BookingStatus::COMPLETED)
      ->count();

    // Get all rentals for the report
    $allRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->with(['motor:id,merk,no_plat', 'penyewa:id,nama'])
      ->orderBy('created_at', 'desc')
      ->get();

    // Monthly rental count for chart
    $monthlyRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
      $query->where('pemilik_id', $owner->id);
    })
      ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
      ->whereYear('created_at', now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    $pdf = Pdf::loadView('owner.reports.rentals-pdf', compact(
      'owner',
      'totalRentals',
      'activeRentals',
      'completedRentals',
      'allRentals',
      'monthlyRentals'
    ));

    $filename = 'laporan_penyewaan_' . $owner->nama . '_' . now()->format('Y-m-d') . '.pdf';

    return $pdf->download($filename);
  }

  /**
   * Set motor status to maintenance
   */
  public function setMaintenance(Motor $motor)
  {
    // Ensure the motor belongs to the authenticated owner
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access to motor');
    }

    // Only verified or available motors can be set to maintenance
    if (!in_array($motor->status, [\App\Enums\MotorStatus::VERIFIED, \App\Enums\MotorStatus::AVAILABLE])) {
      return redirect()->back()->with('error', 'Motor tidak dapat diset ke maintenance dari status saat ini.');
    }

    $motor->update([
      'status' => \App\Enums\MotorStatus::MAINTENANCE
    ]);

    return redirect()->back()->with('success', 'Motor berhasil diset ke mode maintenance.');
  }

  /**
   * Activate motor from maintenance
   */
  public function activateFromMaintenance(Motor $motor)
  {
    // Ensure the motor belongs to the authenticated owner
    if ($motor->pemilik_id !== Auth::id()) {
      abort(403, 'Unauthorized access to motor');
    }

    // Only maintenance motors can be activated
    if ($motor->status !== \App\Enums\MotorStatus::MAINTENANCE) {
      return redirect()->back()->with('error', 'Motor tidak dalam status maintenance.');
    }

    // Set back to available if motor has tarif, otherwise verified
    $newStatus = $motor->tarifRental ? \App\Enums\MotorStatus::AVAILABLE : \App\Enums\MotorStatus::VERIFIED;

    $motor->update([
      'status' => $newStatus
    ]);

    return redirect()->back()->with('success', 'Motor berhasil diaktifkan kembali.');
  }

  /**
   * Export revenue history to PDF
   */
  public function exportRevenueHistoryPDF()
  {
    $owner = Auth::user();

    // Get all revenue history data (without pagination for PDF)
    $revenueHistory = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })
      ->with(['penyewaan.motor', 'penyewaan.user'])
      ->orderBy('created_at', 'desc')
      ->get();

    // Get revenue statistics
    $stats = [
      'total_revenue' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->sum('bagi_hasil_pemilik'),
      'this_month' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik'),
      'this_year' => BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
        $q->where('pemilik_id', $owner->id);
      })->whereYear('created_at', now()->year)->sum('bagi_hasil_pemilik'),
      'total_transactions' => $revenueHistory->count(),
    ];

    $pdf = PDF::loadView('owner.revenue.history-pdf', compact('revenueHistory', 'stats', 'owner'));

    return $pdf->download('riwayat-pendapatan-' . now()->format('Y-m-d') . '.pdf');
  }
}

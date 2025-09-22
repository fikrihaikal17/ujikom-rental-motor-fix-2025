<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\TarifRental;
use App\Models\User;
use App\Enums\BookingStatus;
use App\Enums\DurationType;
use App\Enums\MotorStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RenterController extends Controller
{
  /**
   * Dashboard for renter
   */
  public function dashboard()
  {
    $renter = Auth::user();

    // Get active bookings
    $activeBookings = Penyewaan::where('penyewa_id', $renter->id)
      ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
      ->with(['motor', 'motor.owner'])
      ->orderBy('tanggal_mulai', 'desc')
      ->get();

    // Get recent bookings
    $recentBookings = Penyewaan::where('penyewa_id', $renter->id)
      ->with(['motor', 'motor.owner'])
      ->orderBy('created_at', 'desc')
      ->limit(5)
      ->get();

    // Statistics
    $stats = [
      'total_bookings' => Penyewaan::where('penyewa_id', $renter->id)->count(),
      'active_bookings' => $activeBookings->count(),
      'completed_bookings' => Penyewaan::where('penyewa_id', $renter->id)
        ->where('status', BookingStatus::COMPLETED)->count(),
      'total_spent' => Penyewaan::where('penyewa_id', $renter->id)
        ->where('status', BookingStatus::COMPLETED)
        ->sum('harga'),
    ];

    return view('renter.dashboard', compact('activeBookings', 'recentBookings', 'stats'));
  }

  /**
   * Show all available motors for rent
   */
  public function motors(Request $request)
  {
    $query = Motor::where('status', MotorStatus::VERIFIED)
      ->where('ketersediaan', 'tersedia')
      ->with(['owner', 'tarifRental']);

    // Search functionality
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('merk', 'like', "%{$search}%")
          ->orWhere('nama_motor', 'like', "%{$search}%")
          ->orWhere('model', 'like', "%{$search}%")
          ->orWhere('no_plat', 'like', "%{$search}%");
      });
    }

    // Filter by engine capacity
    if ($request->filled('tipe_cc')) {
      $query->where('tipe_cc', $request->tipe_cc);
    }

    // Filter by brand
    if ($request->filled('merk')) {
      $query->where('merk', 'like', "%{$request->merk}%");
    }

    // Sort by price or date
    if ($request->filled('sort')) {
      switch ($request->sort) {
        case 'price_low':
          $query->leftJoin('tarif_rentals', 'motors.id', '=', 'tarif_rentals.motor_id')
            ->orderBy('tarif_rentals.tarif_harian', 'asc');
          break;
        case 'price_high':
          $query->leftJoin('tarif_rentals', 'motors.id', '=', 'tarif_rentals.motor_id')
            ->orderBy('tarif_rentals.tarif_harian', 'desc');
          break;
        case 'newest':
          $query->orderBy('created_at', 'desc');
          break;
        default:
          $query->orderBy('created_at', 'desc');
      }
    } else {
      $query->orderBy('created_at', 'desc');
    }

    $motors = $query->paginate(12)->withQueryString();

    // Get unique brands for filter
    $brands = Motor::where('status', MotorStatus::VERIFIED)
      ->distinct()
      ->pluck('merk')
      ->sort();

    return view('renter.motors.index', compact('motors', 'brands'));
  }

  /**
   * Show motor details for booking
   */
  public function showMotor(Motor $motor)
  {
    // Check if motor is available
    if ($motor->status !== MotorStatus::VERIFIED || $motor->ketersediaan !== 'tersedia') {
      return redirect()->route('renter.motors.index')
        ->with('error', 'Motor tidak tersedia untuk disewa.');
    }

    $motor->load(['owner', 'tarifRental']);

    return view('renter.motors.show', compact('motor'));
  }

  /**
   * Show booking form
   */
  public function createBooking(Motor $motor)
  {
    // Check if motor is available
    if ($motor->status !== MotorStatus::VERIFIED || $motor->ketersediaan !== 'tersedia') {
      return redirect()->route('renter.motors.index')
        ->with('error', 'Motor tidak tersedia untuk disewa.');
    }

    $motor->load(['owner', 'tarifRental']);

    return view('renter.bookings.create', compact('motor'));
  }

  /**
   * Store new booking
   */
  public function storeBooking(Request $request)
  {
    $request->validate([
      'motor_id' => 'required|exists:motors,id',
      'tanggal_mulai' => 'required|date|after_or_equal:today',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
      'tipe_durasi' => 'required|in:harian,mingguan,bulanan',
      'catatan' => 'nullable|string|max:500',
    ]);

    $motor = Motor::findOrFail($request->motor_id);

    // Check if motor is still available
    if ($motor->status !== MotorStatus::VERIFIED) {
      return redirect()->back()
        ->with('error', 'Motor tidak tersedia untuk disewa.');
    }

    // Check for conflicting bookings
    $conflictingBookings = Penyewaan::where('motor_id', $motor->id)
      ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
      ->where(function ($query) use ($request) {
        $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
          ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
          ->orWhere(function ($q) use ($request) {
            $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
              ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
          });
      })
      ->exists();

    if ($conflictingBookings) {
      return redirect()->back()
        ->with('error', 'Motor sudah dibooking pada tanggal tersebut.')
        ->withInput();
    }

    // Calculate price
    $startDate = Carbon::parse($request->tanggal_mulai);
    $endDate = Carbon::parse($request->tanggal_selesai);
    $days = $startDate->diffInDays($endDate) + 1;

    $tarif = $motor->tarifRental;
    if (!$tarif) {
      return redirect()->back()
        ->with('error', 'Tarif rental belum ditetapkan untuk motor ini.');
    }

    $harga = 0;
    switch ($request->tipe_durasi) {
      case 'harian':
        $harga = $tarif->tarif_harian * $days;
        break;
      case 'mingguan':
        $weeks = ceil($days / 7);
        $harga = $tarif->tarif_mingguan * $weeks;
        break;
      case 'bulanan':
        $months = ceil($days / 30);
        $harga = $tarif->tarif_bulanan * $months;
        break;
    }

    // Create booking
    $booking = Penyewaan::create([
      'penyewa_id' => Auth::id(),
      'motor_id' => $motor->id,
      'tanggal_mulai' => $request->tanggal_mulai,
      'tanggal_selesai' => $request->tanggal_selesai,
      'tipe_durasi' => $request->tipe_durasi,
      'harga' => $harga,
      'status' => BookingStatus::PENDING,
      'catatan' => $request->catatan,
    ]);

    return redirect()->route('renter.bookings.show', $booking)
      ->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi dari pemilik motor.');
  }

  /**
   * Show all bookings
   */
  public function bookings(Request $request)
  {
    $query = Penyewaan::where('penyewa_id', Auth::id())
      ->with(['motor', 'penyewa']);

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Search functionality
    if ($request->filled('search')) {
      $search = $request->search;
      $query->whereHas('motor', function ($q) use ($search) {
        $q->where('merek', 'like', "%{$search}%")
          ->orWhere('nama_motor', 'like', "%{$search}%")
          ->orWhere('plat_nomor', 'like', "%{$search}%");
      });
    }

    $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    return view('renter.bookings.index', compact('bookings'));
  }

  /**
   * Show booking details
   */
  public function showBooking(Penyewaan $booking)
  {
    // Check if booking belongs to current user
    if ($booking->penyewa_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    $booking->load(['motor', 'motor.owner', 'transaksi', 'transaksi.payment']);

    return view('renter.bookings.show', compact('booking'));
  }

  /**
   * Cancel booking
   */
  public function cancelBooking(Penyewaan $booking)
  {
    // Check if booking belongs to current user
    if ($booking->penyewa_id !== Auth::id()) {
      abort(403, 'Unauthorized access');
    }

    // Check if booking can be cancelled
    if (!in_array($booking->status, [BookingStatus::PENDING, BookingStatus::CONFIRMED])) {
      return redirect()->back()
        ->with('error', 'Booking tidak dapat dibatalkan pada status saat ini.');
    }

    // Check if booking start date is still in the future (at least 24 hours)
    if ($booking->tanggal_mulai->isBefore(Carbon::now()->addDay())) {
      return redirect()->back()
        ->with('error', 'Booking hanya dapat dibatalkan minimal 24 jam sebelum tanggal mulai.');
    }

    $booking->update([
      'status' => BookingStatus::CANCELLED,
    ]);

    return redirect()->route('renter.bookings.index')
      ->with('success', 'Booking berhasil dibatalkan.');
  }

  /**
   * Show booking history
   */
  public function history(Request $request)
  {
    $query = Penyewaan::where('penyewa_id', Auth::id())
      ->with(['motor', 'motor.owner', 'transaksi'])
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED]);

    // Filter by year
    if ($request->filled('year')) {
      $query->whereYear('created_at', $request->year);
    }

    // Filter by month
    if ($request->filled('month')) {
      $query->whereMonth('created_at', $request->month);
    }

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    $history = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    // Statistics for history
    $totalBookings = Penyewaan::where('penyewa_id', Auth::id())
      ->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::CANCELLED])
      ->count();

    $completedBookings = Penyewaan::where('penyewa_id', Auth::id())
      ->where('status', BookingStatus::COMPLETED)
      ->count();

    $cancelledBookings = Penyewaan::where('penyewa_id', Auth::id())
      ->where('status', BookingStatus::CANCELLED)
      ->count();

    $totalSpent = Penyewaan::where('penyewa_id', Auth::id())
      ->where('status', BookingStatus::COMPLETED)
      ->sum('harga');

    return view('renter.history.index', compact(
      'history',
      'totalBookings',
      'completedBookings',
      'cancelledBookings',
      'totalSpent'
    ));
  }

  /**
   * Export booking history to PDF/Excel
   */
  public function exportHistory(Request $request)
  {
    // For now, return a simple success message
    // This can be extended to generate actual PDF/Excel files
    return redirect()->route('renter.history')
      ->with('info', 'Fitur export PDF akan segera tersedia.');
  }
}

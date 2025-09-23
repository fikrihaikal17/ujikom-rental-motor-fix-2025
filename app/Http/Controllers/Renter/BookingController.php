<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show booking form
     */
    public function create(Motor $motor)
    {
        if ($motor->status !== 'available') {
            return redirect()->route('renter.motors.index')
                ->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        $motor->load(['tarifRental']);

        return view('renter.bookings.create', compact('motor'));
    }

    /**
     * Store new booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'motor_id' => 'required|exists:motors,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tipe_durasi' => 'required|in:harian,mingguan,bulanan',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $motor = Motor::with('tarifRental')->findOrFail($request->motor_id);

        // Check if motor is still available
        if ($motor->status !== 'available') {
            return back()->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        // Check for conflicting bookings
        $conflictingBooking = $motor->penyewaans()
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($conflictingBooking) {
            return back()->with('error', 'Motor sudah dibooking pada tanggal tersebut.');
        }

        // Calculate total cost based on duration type
        $startDate = \Carbon\Carbon::parse($request->tanggal_mulai);
        $endDate = \Carbon\Carbon::parse($request->tanggal_selesai);
        $days = $startDate->diffInDays($endDate);
        if ($days == 0) $days = 1; // Minimum 1 day

        $totalHarga = $this->calculatePrice($motor->tarifRental, $days, $request->tipe_durasi);

        DB::transaction(function () use ($request, $motor, $totalHarga) {
            // Create booking
            Penyewaan::create([
                'penyewa_id' => Auth::id(),
                'motor_id' => $motor->id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tipe_durasi' => $request->tipe_durasi,
                'harga' => $totalHarga,
                'catatan' => $request->catatan,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('renter.bookings.index')
            ->with('success', 'Booking berhasil dibuat. Menunggu konfirmasi dari pemilik motor.');
    }

    /**
     * Calculate price based on optimal pricing combination
     */
    private function calculatePrice($tarifRental, $days, $tipeDurasi)
    {
        $totalPrice = 0;

        // Calculate optimal pricing combination
        if ($days >= 30 && $tarifRental->tarif_bulanan > 0) {
            // Calculate months + remaining days
            $months = floor($days / 30);
            $remainingDays = $days % 30;

            $totalPrice += $months * $tarifRental->tarif_bulanan;

            // Calculate weekly option for remaining days if beneficial
            if ($remainingDays >= 7 && $tarifRental->tarif_mingguan > 0) {
                $weeks = floor($remainingDays / 7);
                $finalRemainingDays = $remainingDays % 7;

                $totalPrice += $weeks * $tarifRental->tarif_mingguan;
                $totalPrice += $finalRemainingDays * $tarifRental->tarif_harian;
            } else {
                // Just add remaining days as daily rate
                $totalPrice += $remainingDays * $tarifRental->tarif_harian;
            }
        } else if ($days >= 7 && $tarifRental->tarif_mingguan > 0) {
            // Calculate weeks + remaining days
            $weeks = floor($days / 7);
            $remainingDays = $days % 7;

            $weeklyPrice = $weeks * $tarifRental->tarif_mingguan;
            $dailyPrice = $remainingDays * $tarifRental->tarif_harian;
            $totalPriceWithWeekly = $weeklyPrice + $dailyPrice;

            // Compare with pure daily pricing
            $pureDaily = $days * $tarifRental->tarif_harian;

            if ($totalPriceWithWeekly <= $pureDaily) {
                $totalPrice = $totalPriceWithWeekly;
            } else {
                $totalPrice = $pureDaily;
            }
        } else {
            // Daily pricing only
            $totalPrice = $days * $tarifRental->tarif_harian;
        }

        return $totalPrice;
    }

    /**
     * Show renter's bookings
     */
    public function index()
    {
        $bookings = Penyewaan::with(['motor', 'motor.owner'])
            ->where('penyewa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('renter.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details
     */
    public function show(Penyewaan $booking)
    {
        // Check if booking belongs to current user
        if ($booking->penyewa_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['motor', 'motor.owner', 'motor.tarifRental', 'payments']);

        return view('renter.bookings.show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function cancel(Penyewaan $booking)
    {
        // Check if booking belongs to current user
        if ($booking->penyewa_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation for pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('renter.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}

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
    public function store(Request $request, Motor $motor)
    {
        $request->validate([
            'tgl_mulai' => 'required|date|after_or_equal:today',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'keperluan' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Check if motor is still available
        if ($motor->status !== 'available') {
            return back()->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        // Check for conflicting bookings
        $conflictingBooking = $motor->penyewaans()
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tgl_mulai', [$request->tgl_mulai, $request->tgl_selesai])
                      ->orWhereBetween('tgl_selesai', [$request->tgl_mulai, $request->tgl_selesai])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('tgl_mulai', '<=', $request->tgl_mulai)
                            ->where('tgl_selesai', '>=', $request->tgl_selesai);
                      });
            })
            ->exists();

        if ($conflictingBooking) {
            return back()->with('error', 'Motor sudah dibooking pada tanggal tersebut.');
        }

        // Calculate total cost
        $startDate = \Carbon\Carbon::parse($request->tgl_mulai);
        $endDate = \Carbon\Carbon::parse($request->tgl_selesai);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalHarga = $days * $motor->tarifRental->harga_per_hari;

        DB::transaction(function () use ($request, $motor, $totalHarga) {
            // Create booking
            Penyewaan::create([
                'penyewa_id' => Auth::id(),
                'motor_id' => $motor->id,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'total_harga' => $totalHarga,
                'keperluan' => $request->keperluan,
                'catatan' => $request->catatan,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('renter.bookings.index')
            ->with('success', 'Booking berhasil dibuat. Menunggu konfirmasi dari pemilik motor.');
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
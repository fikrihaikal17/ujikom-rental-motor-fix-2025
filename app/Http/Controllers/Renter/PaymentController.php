<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show payment form
     */
    public function create(Penyewaan $booking)
    {
        // Check if booking belongs to current user
        if ($booking->penyewa_id !== Auth::id()) {
            abort(403);
        }

        // Only allow payment for confirmed bookings
        if ($booking->status !== 'confirmed') {
            return redirect()->route('renter.bookings.show', $booking)
                ->with('error', 'Booking belum dikonfirmasi atau sudah dibayar.');
        }

        // Check if payment already exists
        if ($booking->payments()->where('status', 'completed')->exists()) {
            return redirect()->route('renter.bookings.show', $booking)
                ->with('error', 'Booking sudah dibayar.');
        }

        $booking->load(['motor', 'motor.owner']);

        return view('renter.payments.create', compact('booking'));
    }

    /**
     * Store payment
     */
    public function store(Request $request, Penyewaan $booking)
    {
        // Check if booking belongs to current user
        if ($booking->penyewa_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:transfer,cash',
            'bukti_transfer' => 'required_if:payment_method,transfer|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Check if payment already exists
        if ($booking->payments()->where('status', 'completed')->exists()) {
            return back()->with('error', 'Booking sudah dibayar.');
        }

        $buktiTransferPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiTransferPath = $request->file('bukti_transfer')->store('payments', 'public');
        }

        // Create payment record
        Payment::create([
            'penyewaan_id' => $booking->id,
            'amount' => $booking->total_harga,
            'payment_method' => $request->payment_method,
            'bukti_transfer' => $buktiTransferPath,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        // Update booking status to paid (pending verification)
        $booking->update(['status' => 'paid']);

        return redirect()->route('renter.bookings.show', $booking)
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi dari admin.');
    }

    /**
     * Show payment history
     */
    public function index()
    {
        $payments = Payment::with(['penyewaan', 'penyewaan.motor'])
            ->whereHas('penyewaan', function ($query) {
                $query->where('penyewa_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('renter.payments.index', compact('payments'));
    }

    /**
     * Show payment details
     */
    public function show(Payment $payment)
    {
        // Check if payment belongs to current user
        if ($payment->penyewaan->penyewa_id !== Auth::id()) {
            abort(403);
        }

        $payment->load(['penyewaan', 'penyewaan.motor', 'penyewaan.motor.owner']);

        return view('renter.payments.show', compact('payment'));
    }

    /**
     * Download payment receipt
     */
    public function receipt(Payment $payment)
    {
        // Check if payment belongs to current user
        if ($payment->penyewaan->penyewa_id !== Auth::id()) {
            abort(403);
        }

        // Only allow download for completed payments
        if ($payment->status !== 'completed') {
            return back()->with('error', 'Pembayaran belum selesai.');
        }

        $payment->load(['penyewaan', 'penyewaan.motor', 'penyewaan.motor.owner']);

        return view('renter.payments.receipt', compact('payment'));
    }

    /**
     * Resend payment (if rejected)
     */
    public function resend(Payment $payment)
    {
        // Check if payment belongs to current user
        if ($payment->penyewaan->penyewa_id !== Auth::id()) {
            abort(403);
        }

        // Only allow resend for rejected payments
        if ($payment->status !== 'rejected') {
            return back()->with('error', 'Pembayaran tidak dapat dikirim ulang.');
        }

        return redirect()->route('renter.payments.create', $payment->penyewaan);
    }
}
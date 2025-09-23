<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;

class MotorSearchController extends Controller
{
    /**
     * Display available motors for rent
     */
    public function index(Request $request)
    {
        $query = Motor::with(['owner', 'tarifRental'])
            ->where('status', 'verified')
            ->where('ketersediaan', 'tersedia')
            ->whereDoesntHave('penyewaans', function ($query) {
                $query->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
                    ->where(function ($q) {
                        $q->where('tanggal_selesai', '>=', now())
                            ->orWhereNull('completed_at');
                    });
            });

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('no_polisi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('merk')) {
            $query->where('merk', $request->merk);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('min_price')) {
            $query->whereHas('tarifRental', function ($q) use ($request) {
                $q->where('harga_per_hari', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('tarifRental', function ($q) use ($request) {
                $q->where('harga_per_hari', '<=', $request->max_price);
            });
        }

        $motors = $query->paginate(12);

        // Get filter options
        $brands = Motor::where('status', 'verified')
            ->where('ketersediaan', 'tersedia')
            ->whereDoesntHave('penyewaans', function ($query) {
                $query->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
                    ->where(function ($q) {
                        $q->where('tanggal_selesai', '>=', now())
                            ->orWhereNull('completed_at');
                    });
            })
            ->distinct()
            ->pluck('merk')
            ->sort();

        $types = Motor::where('status', 'verified')
            ->where('ketersediaan', 'tersedia')
            ->whereDoesntHave('penyewaans', function ($query) {
                $query->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
                    ->where(function ($q) {
                        $q->where('tanggal_selesai', '>=', now())
                            ->orWhereNull('completed_at');
                    });
            })
            ->distinct()
            ->pluck('type')
            ->sort();

        return view('renter.motors.index', compact('motors', 'brands', 'types'));
    }

    /**
     * Show motor details
     */
    public function show(Motor $motor)
    {
        if ($motor->status !== 'verified' || $motor->ketersediaan !== 'tersedia') {
            return redirect()->route('renter.motors.index')
                ->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        // Check if motor is currently being rented
        $hasActiveBooking = $motor->penyewaans()
            ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
            ->where(function ($query) {
                $query->where('tanggal_selesai', '>=', now())
                    ->orWhereNull('completed_at');
            })
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->route('renter.motors.index')
                ->with('error', 'Motor sedang disewa oleh penyewa lain.');
        }

        $motor->load(['owner', 'tarifRental', 'gambarMotors']);

        return view('renter.motors.show', compact('motor'));
    }

    /**
     * Get motor availability for booking calendar
     */
    public function availability(Motor $motor, Request $request)
    {
        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addMonth()->format('Y-m-d'));

        // Get booked dates for this motor
        $bookedDates = $motor->penyewaans()
            ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })
            ->get(['tanggal_mulai', 'tanggal_selesai']);

        $unavailableDates = [];
        foreach ($bookedDates as $booking) {
            $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
            $end = \Carbon\Carbon::parse($booking->tanggal_selesai);

            while ($start <= $end) {
                $unavailableDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return response()->json([
            'unavailable_dates' => array_unique($unavailableDates)
        ]);
    }

    /**
     * API method to check motor availability
     */
    public function apiCheckAvailability(Motor $motor, Request $request)
    {
        // Check if motor is available
        if ($motor->status !== 'available') {
            return response()->json([
                'available' => false,
                'message' => 'Motor tidak tersedia untuk disewa.'
            ]);
        }

        // Check if motor is currently being rented
        $hasActiveBooking = $motor->penyewaans()
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($query) {
                $query->where('tanggal_selesai', '>=', now())
                    ->orWhereNull('completed_at');
            })
            ->exists();

        if ($hasActiveBooking) {
            return response()->json([
                'available' => false,
                'message' => 'Motor sedang disewa oleh penyewa lain.'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Motor tersedia untuk disewa.'
        ]);
    }
}

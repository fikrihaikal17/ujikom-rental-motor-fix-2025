<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorSearchController extends Controller
{
    /**
     * Display available motors for rent
     */
    public function index(Request $request)
    {
        $query = Motor::with(['owner', 'tarifRental'])
            ->where('status', 'available');

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
        $brands = Motor::where('status', 'available')
            ->distinct()
            ->pluck('merk')
            ->sort();

        $types = Motor::where('status', 'available')
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
        if ($motor->status !== 'available') {
            return redirect()->route('renter.motors.index')
                ->with('error', 'Motor tidak tersedia untuk disewa.');
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
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tgl_mulai', [$startDate, $endDate])
                      ->orWhereBetween('tgl_selesai', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('tgl_mulai', '<=', $startDate)
                            ->where('tgl_selesai', '>=', $endDate);
                      });
            })
            ->get(['tgl_mulai', 'tgl_selesai']);

        $unavailableDates = [];
        foreach ($bookedDates as $booking) {
            $start = \Carbon\Carbon::parse($booking->tgl_mulai);
            $end = \Carbon\Carbon::parse($booking->tgl_selesai);
            
            while ($start <= $end) {
                $unavailableDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return response()->json([
            'unavailable_dates' => array_unique($unavailableDates)
        ]);
    }
}
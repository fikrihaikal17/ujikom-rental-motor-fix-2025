<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use App\Models\Penyewaan;
use App\Models\User;
use App\Enums\BookingStatus;

// Test the new logic
$renter = User::find(3);
echo "Testing new statistics calculation for: " . $renter->nama . "\n";
echo "==============================================\n";

$stats = [
  'total_bookings' => Penyewaan::where('penyewa_id', $renter->id)->count(),
  'active_bookings' => Penyewaan::where('penyewa_id', $renter->id)
    ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
    ->count(),
  'completed_bookings' => Penyewaan::where('penyewa_id', $renter->id)
    ->where('status', BookingStatus::COMPLETED)->count(),
  'total_spent' => Penyewaan::where('penyewa_id', $renter->id)
    ->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE, BookingStatus::COMPLETED])
    ->sum('harga'),
];

echo "Total Bookings: " . $stats['total_bookings'] . "\n";
echo "Active Bookings: " . $stats['active_bookings'] . "\n";
echo "Completed Bookings: " . $stats['completed_bookings'] . "\n";
echo "Total Spent: Rp " . number_format($stats['total_spent'], 0, ',', '.') . "\n";

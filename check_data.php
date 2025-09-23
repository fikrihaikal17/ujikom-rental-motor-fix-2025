<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use App\Models\Penyewaan;
use App\Models\User;
use App\Enums\BookingStatus;

// Find user with ID 3
$user = User::find(3);
if (!$user) {
  echo "User with ID 3 not found\n";
  exit;
}

echo "User: " . $user->nama . " (ID: " . $user->id . ")\n";
echo "================================\n";

// Get all bookings for user
$bookings = Penyewaan::where('penyewa_id', 3)->get();
echo "Total bookings: " . $bookings->count() . "\n\n";

foreach ($bookings as $booking) {
  echo "Booking ID: " . $booking->id . "\n";
  echo "Status: " . $booking->status->name . "\n";
  echo "Harga: " . $booking->harga . "\n";
  echo "Created: " . $booking->created_at . "\n";
  echo "------------------------\n";
}

// Calculate statistics
$totalBookings = Penyewaan::where('penyewa_id', 3)->count();
$completedBookings = Penyewaan::where('penyewa_id', 3)
  ->where('status', BookingStatus::COMPLETED)
  ->get();
$totalSpent = Penyewaan::where('penyewa_id', 3)
  ->where('status', BookingStatus::COMPLETED)
  ->sum('harga');

echo "\nStatistics:\n";
echo "Total bookings: " . $totalBookings . "\n";
echo "Completed bookings: " . $completedBookings->count() . "\n";
echo "Total spent (completed only): " . $totalSpent . "\n";

// Check for any bookings regardless of status
$allSpent = Penyewaan::where('penyewa_id', 3)->sum('harga');
echo "Total spent (all bookings): " . $allSpent . "\n";

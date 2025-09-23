<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

use App\Models\Penyewaan;
use App\Models\User;

echo "=== DEBUG RENTALS DATA ===\n\n";

// Check total rentals
$totalRentals = Penyewaan::count();
echo "Total Penyewaan: " . $totalRentals . "\n\n";

// Check owner ID 2 rentals
$owner = User::find(2);
if ($owner) {
  echo "Owner: " . $owner->name . " (ID: " . $owner->id . ")\n\n";

  $ownerRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
    $query->where('pemilik_id', $owner->id);
  })->count();

  echo "Rentals for owner ID 2: " . $ownerRentals . "\n\n";

  // Get some sample data
  $sampleRentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
    $query->where('pemilik_id', $owner->id);
  })
    ->with(['motor', 'penyewa'])
    ->take(5)
    ->get();

  echo "Sample rentals:\n";
  foreach ($sampleRentals as $rental) {
    echo "ID: " . $rental->id . "\n";
    echo "  Motor: " . ($rental->motor ? $rental->motor->nama . " (" . $rental->motor->nomor_plat . ")" : 'NULL') . "\n";
    echo "  Penyewa: " . ($rental->penyewa ? $rental->penyewa->name : 'NULL') . "\n";
    echo "  Harga: Rp " . number_format($rental->harga, 0, ',', '.') . "\n";
    echo "  Status: " . $rental->status->value . "\n";
    echo "  Created: " . $rental->created_at . "\n\n";
  }
} else {
  echo "Owner ID 2 not found!\n";
}

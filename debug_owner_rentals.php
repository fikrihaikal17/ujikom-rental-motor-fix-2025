<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Penyewaan;
use App\Models\User;

echo "=== DEBUGGING RENTALS DATA ===\n\n";

try {
  // Find owner
  $owner = User::find(2);
  if (!$owner) {
    echo "Owner ID 2 not found!\n";
    exit;
  }

  echo "Owner: " . $owner->name . " (ID: " . $owner->id . ")\n\n";

  // Get rentals using Eloquent
  $rentals = Penyewaan::whereHas('motor', function ($query) use ($owner) {
    $query->where('pemilik_id', $owner->id);
  })
    ->with(['motor', 'penyewa'])
    ->take(10)
    ->get();

  echo "Found " . $rentals->count() . " rentals for owner:\n\n";

  foreach ($rentals as $rental) {
    echo "Rental ID: " . $rental->id . "\n";
    echo "  Motor ID: " . $rental->motor_id . "\n";
    echo "  Motor loaded: " . ($rental->relationLoaded('motor') ? 'YES' : 'NO') . "\n";
    echo "  Motor: " . ($rental->motor ? $rental->motor->nama : 'NULL') . "\n";
    echo "  Nomor Plat: " . ($rental->motor ? $rental->motor->nomor_plat : 'NULL') . "\n";
    echo "  Penyewa ID: " . $rental->penyewa_id . "\n";
    echo "  Penyewa loaded: " . ($rental->relationLoaded('penyewa') ? 'YES' : 'NO') . "\n";
    echo "  Penyewa: " . ($rental->penyewa ? $rental->penyewa->name : 'NULL') . "\n";
    echo "  Harga: " . $rental->harga . "\n";
    echo "  ----------\n";
  }
} catch (Exception $e) {
  echo "ERROR: " . $e->getMessage() . "\n";
  echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

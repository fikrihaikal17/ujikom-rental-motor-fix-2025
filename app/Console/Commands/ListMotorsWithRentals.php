<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;

class ListMotorsWithRentals extends Command
{
  protected $signature = 'list:motors-with-rentals';
  protected $description = 'List all motors that have rental data for testing';

  public function handle()
  {
    $this->info("🏍️  Motors with Rental Data for Testing");
    $this->info("===============================================");

    $motorsWithRentals = Motor::has('penyewaans')
      ->with(['owner', 'penyewaans'])
      ->get()
      ->sortByDesc(function ($motor) {
        return $motor->penyewaans->count();
      });

    if ($motorsWithRentals->count() > 0) {
      foreach ($motorsWithRentals as $motor) {
        $rentalCount = $motor->penyewaans->count();
        $owner = $motor->owner ? $motor->owner->nama : 'No owner';

        $this->info("📍 Motor ID: {$motor->id}");
        $this->info("   🏷️  {$motor->merk} {$motor->model} ({$motor->tahun})");
        $this->info("   👤 Owner: {$owner}");
        $this->info("   📊 Rentals: {$rentalCount}");
        $this->info("   🌐 URL: http://127.0.0.1:8000/owner/motors/{$motor->id}");

        // Show rental status breakdown
        $statusBreakdown = $motor->penyewaans->groupBy('status')->map->count();
        $statusInfo = [];
        foreach ($statusBreakdown as $status => $count) {
          $statusInfo[] = "{$status}: {$count}";
        }
        $this->info("   📈 Status: " . implode(', ', $statusInfo));
        $this->info("");
      }

      $this->info("🚀 Total motors with rentals: {$motorsWithRentals->count()}");
      $this->info("💡 You can now test these motor detail pages to see rental history!");
    } else {
      $this->error("❌ No motors with rental data found!");
    }
  }
}

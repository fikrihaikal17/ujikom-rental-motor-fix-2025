<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\Penyewaan;

class TestRentalView extends Command
{
  protected $signature = 'test:rental-view {motor_id?}';
  protected $description = 'Test rental view data mapping';

  public function handle()
  {
    $motorId = $this->argument('motor_id') ?? 3;

    $this->info("🧪 Testing rental view data for Motor ID: {$motorId}");

    // Load motor like in controller
    $motor = Motor::with(['tarifRental', 'penyewaans.penyewa', 'penyewaans.bagiHasil'])->find($motorId);

    if (!$motor) {
      $this->error("Motor with ID {$motorId} not found!");
      return;
    }

    $this->info("🏍️ Motor: {$motor->merk} {$motor->model} ({$motor->tahun})");
    $this->info("📊 Total penyewaans loaded: {$motor->penyewaans->count()}");

    if ($motor->penyewaans->count() > 0) {
      $this->info("\n📋 First rental data:");
      $rental = $motor->penyewaans->first();

      $this->info("- Rental ID: {$rental->id}");
      $this->info("- Motor ID: {$rental->motor_id}");
      $this->info("- Penyewa ID: {$rental->penyewa_id}");
      $this->info("- Penyewa Name: " . ($rental->penyewa ? $rental->penyewa->name : 'NULL'));
      $this->info("- Penyewa Email: " . ($rental->penyewa ? $rental->penyewa->email : 'NULL'));
      $this->info("- Start Date: {$rental->tanggal_mulai}");
      $this->info("- End Date: {$rental->tanggal_selesai}");
      $this->info("- Price (harga): " . number_format($rental->harga, 0, ',', '.'));
      $this->info("- Status: {$rental->status->value}");

      // Test field that might be missing
      $this->info("\n🔍 Field availability check:");
      $this->info("- Has harga field: " . ($rental->harga ? 'YES' : 'NO'));
      $this->info("- Harga value: {$rental->harga}");
      $this->info("- Has penyewa relationship: " . ($rental->penyewa ? 'YES' : 'NO'));

      if ($rental->penyewa) {
        $this->info("- Penyewa name field: " . ($rental->penyewa->name ?? 'NULL'));
        $this->info("- Penyewa email field: " . ($rental->penyewa->email ?? 'NULL'));
      }

      // Test status values
      $this->info("\n📈 Status check for all rentals:");
      $statuses = $motor->penyewaans->groupBy('status')->map->count();
      foreach ($statuses as $status => $count) {
        $this->info("- {$status}: {$count} rentals");
      }
    }

    // Test revenue calculation
    $this->info("\n💰 Revenue calculation test:");
    $totalRevenue = $motor->penyewaans->where('status', 'completed')->sum('harga');
    $this->info("- Total revenue from completed rentals: Rp " . number_format($totalRevenue, 0, ',', '.'));

    // Test active rentals
    $activeRentals = $motor->penyewaans->whereIn('status', [\App\Enums\BookingStatus::CONFIRMED, \App\Enums\BookingStatus::ACTIVE])->count();
    $this->info("- Active rentals count: {$activeRentals}");
  }
}

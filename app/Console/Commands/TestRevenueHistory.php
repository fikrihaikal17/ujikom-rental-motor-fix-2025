<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BagiHasil;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestRevenueHistory extends Command
{
  protected $signature = 'test:revenue-history {owner_id?}';
  protected $description = 'Test revenue history data and relationships';

  public function handle()
  {
    $ownerId = $this->argument('owner_id') ?? 2;

    $this->info("🧪 Testing revenue history for Owner ID: {$ownerId}");

    $owner = User::find($ownerId);
    if (!$owner) {
      $this->error("Owner with ID {$ownerId} not found!");
      return;
    }

    $this->info("👤 Owner: {$owner->nama} ({$owner->email})");

    // Get revenue history like in controller
    $revenueHistory = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })
      ->with(['penyewaan.motor', 'penyewaan.penyewa'])
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();

    $this->info("📊 Total revenue records: {$revenueHistory->count()}");

    if ($revenueHistory->count() > 0) {
      $this->info("\n📋 Sample revenue data:");

      foreach ($revenueHistory->take(3) as $index => $revenue) {
        $this->info("--- Revenue Record " . ($index + 1) . " ---");
        $this->info("- Revenue ID: {$revenue->id}");
        $this->info("- Created At: {$revenue->created_at}");
        $this->info("- Amount: Rp " . number_format($revenue->bagi_hasil_pemilik, 0, ',', '.'));

        // Test penyewaan relationship
        if ($revenue->penyewaan) {
          $this->info("- Penyewaan ID: {$revenue->penyewaan->id}");
          $this->info("- Motor: " . ($revenue->penyewaan->motor ? $revenue->penyewaan->motor->merk . ' ' . $revenue->penyewaan->motor->model : 'NULL'));
          $this->info("- Penyewa: " . ($revenue->penyewaan->penyewa ? $revenue->penyewaan->penyewa->nama : 'NULL'));
          $this->info("- Penyewa Email: " . ($revenue->penyewaan->penyewa ? $revenue->penyewaan->penyewa->email : 'NULL'));
        } else {
          $this->error("- Penyewaan relationship: NULL");
        }
        $this->info("");
      }

      // Test for any null relationships
      $nullPenyewaan = $revenueHistory->filter(function ($revenue) {
        return is_null($revenue->penyewaan);
      })->count();

      $nullPenyewa = $revenueHistory->filter(function ($revenue) {
        return $revenue->penyewaan && is_null($revenue->penyewaan->penyewa);
      })->count();

      $nullMotor = $revenueHistory->filter(function ($revenue) {
        return $revenue->penyewaan && is_null($revenue->penyewaan->motor);
      })->count();

      $this->info("🔍 Relationship Check:");
      $this->info("- Records with null penyewaan: {$nullPenyewaan}");
      $this->info("- Records with null penyewa: {$nullPenyewa}");
      $this->info("- Records with null motor: {$nullMotor}");

      if ($nullPenyewaan > 0 || $nullPenyewa > 0 || $nullMotor > 0) {
        $this->warn("⚠️  Some relationships are null - this could cause view errors!");
      } else {
        $this->info("✅ All relationships are properly loaded!");
      }
    } else {
      $this->warn("❌ No revenue history found for this owner!");
    }
  }
}

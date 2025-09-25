<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\User;

class CheckMotorStatus extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'check:motor-status {ownerId?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check motor status for owner';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $ownerId = $this->argument('ownerId') ?: 2;

    $owner = User::find($ownerId);
    if (!$owner) {
      $this->error("Owner not found!");
      return;
    }

    $this->info("🔍 Motor Status untuk: {$owner->nama}");

    $motors = Motor::where('pemilik_id', $ownerId)->get();

    if ($motors->isEmpty()) {
      $this->warn("Tidak ada motor untuk owner ini");
      return;
    }

    $this->info("\n📋 MOTOR STATUS:");
    foreach ($motors as $motor) {
      $this->info("• {$motor->merk} {$motor->model} - Status: {$motor->status->value}");
    }

    // Count by status
    $statusCounts = [];
    foreach ($motors as $motor) {
      $status = $motor->status->value;
      $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
    }

    $this->info("\n📊 STATUS SUMMARY:");
    foreach ($statusCounts as $status => $count) {
      $this->info("• {$status}: {$count} motor(s)");
    }

    // Test actual queries used in dashboard
    $this->info("\n🧪 DASHBOARD QUERIES:");
    $totalMotors = Motor::where('pemilik_id', $ownerId)->count();
    $verifiedMotors = Motor::where('pemilik_id', $ownerId)->where('status', \App\Enums\MotorStatus::VERIFIED)->count();
    $availableMotors = Motor::where('pemilik_id', $ownerId)->where('status', \App\Enums\MotorStatus::AVAILABLE)->count();

    $this->info("• Total Motors: {$totalMotors}");
    $this->info("• Verified Motors: {$verifiedMotors}");
    $this->info("• Available Motors: {$availableMotors}");
  }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\BagiHasil;

class TestOwnerData extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:owner-data {ownerId?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test owner dashboard data';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $ownerId = $this->argument('ownerId') ?: 2; // Default owner ID

    $owner = User::where('role', 'pemilik')->find($ownerId);

    if (!$owner) {
      $this->error("Owner dengan ID {$ownerId} tidak ditemukan!");

      // Show available owners
      $owners = User::where('role', 'pemilik')->take(10)->get();
      $this->info("\nOwner yang tersedia:");
      foreach ($owners as $o) {
        $this->info("ID {$o->id}: {$o->nama} ({$o->email})");
      }
      return;
    }

    $this->info("🏍️ DASHBOARD DATA UNTUK: {$owner->nama}");
    $this->info("📧 Email: {$owner->email}");

    // Statistics
    $totalMotors = Motor::where('pemilik_id', $owner->id)->count();
    $verifiedMotors = Motor::where('pemilik_id', $owner->id)
      ->where('status', \App\Enums\MotorStatus::VERIFIED)->count();
    $activeRentals = Penyewaan::whereHas('motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->where('status', \App\Enums\BookingStatus::ACTIVE)->count();

    $totalRevenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->sum('bagi_hasil_pemilik');

    $monthlyRevenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->whereMonth('created_at', now()->month)->sum('bagi_hasil_pemilik');

    $this->info("\n📊 STATISTIK:");
    $this->info("• Total Motor: {$totalMotors}");
    $this->info("• Motor Terverifikasi: {$verifiedMotors}");
    $this->info("• Rental Aktif: {$activeRentals}");
    $this->info("• Total Pendapatan: Rp " . number_format($totalRevenue, 0, ',', '.'));
    $this->info("• Pendapatan Bulan Ini: Rp " . number_format($monthlyRevenue, 0, ',', '.'));

    // Recent rentals
    $recentRentals = Penyewaan::whereHas('motor', function ($q) use ($owner) {
      $q->where('pemilik_id', $owner->id);
    })->with(['motor', 'penyewa'])->latest()->take(5)->get();

    if ($recentRentals->count() > 0) {
      $this->info("\n📅 RENTAL TERBARU:");
      $headers = ['ID', 'Motor', 'Penyewa', 'Status', 'Harga'];
      $rows = [];

      foreach ($recentRentals as $rental) {
        $rows[] = [
          $rental->id,
          $rental->motor->merk . ' ' . $rental->motor->model,
          $rental->penyewa->nama,
          $rental->status->value,
          'Rp ' . number_format($rental->harga, 0, ',', '.')
        ];
      }

      $this->table($headers, $rows);
    } else {
      $this->warn("\n⚠️ Tidak ada rental untuk motor owner ini");
    }

    // Motors owned
    $motors = Motor::where('pemilik_id', $owner->id)->get();
    if ($motors->count() > 0) {
      $this->info("\n🏍️ MOTOR YANG DIMILIKI:");
      foreach ($motors as $motor) {
        $rentals = $motor->penyewaans()->count();
        $this->info("• {$motor->merk} {$motor->model} ({$motor->tahun}) - {$rentals} rental");
      }
    }
  }
}

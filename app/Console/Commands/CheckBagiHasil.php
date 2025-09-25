<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BagiHasil;
use App\Models\User;
use Carbon\Carbon;

class CheckBagiHasil extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'check:bagi-hasil {ownerId?}';

  /**
   * The command description.
   *
   * @var string
   */
  protected $description = 'Check bagi hasil data for owner';

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

    $this->info("💰 Bagi Hasil untuk: {$owner->nama}");

    $bagiHasils = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($ownerId) {
      $q->where('pemilik_id', $ownerId);
    })->orderBy('tanggal', 'desc')->get();

    if ($bagiHasils->isEmpty()) {
      $this->warn("Tidak ada data bagi hasil untuk owner ini");
      return;
    }

    $this->info("\n📅 BAGI HASIL RECORDS ({$bagiHasils->count()} total):");

    $headers = ['Tanggal', 'Amount', 'Motor', 'Penyewa'];
    $rows = [];

    foreach ($bagiHasils->take(10) as $bg) {
      $rows[] = [
        $bg->tanggal,
        'Rp ' . number_format($bg->bagi_hasil_pemilik, 0, ',', '.'),
        $bg->penyewaan->motor->merk . ' ' . $bg->penyewaan->motor->model,
        $bg->penyewaan->penyewa->nama
      ];
    }

    $this->table($headers, $rows);

    // Test current month calculation
    $currentMonth = Carbon::now()->format('Y-m');
    $this->info("\n🗓️ CURRENT MONTH ANALYSIS:");
    $this->info("Current month: {$currentMonth}");

    $monthlyRevenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($ownerId) {
      $q->where('pemilik_id', $ownerId);
    })->where('tanggal', 'like', $currentMonth . '%')->sum('bagi_hasil_pemilik');

    $this->info("Monthly revenue (tanggal field): Rp " . number_format($monthlyRevenue, 0, ',', '.'));

    // Also try with created_at
    $monthlyRevenueCreatedAt = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($ownerId) {
      $q->where('pemilik_id', $ownerId);
    })->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->sum('bagi_hasil_pemilik');

    $this->info("Monthly revenue (created_at field): Rp " . number_format($monthlyRevenueCreatedAt, 0, ',', '.'));

    // Total revenue
    $totalRevenue = BagiHasil::whereHas('penyewaan.motor', function ($q) use ($ownerId) {
      $q->where('pemilik_id', $ownerId);
    })->sum('bagi_hasil_pemilik');

    $this->info("Total revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
  }
}

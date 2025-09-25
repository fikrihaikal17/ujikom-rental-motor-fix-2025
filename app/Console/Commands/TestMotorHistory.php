<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\Penyewaan;

class TestMotorHistory extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:motor-history {motorId?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test motor rental history with Gmail accounts';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $motorId = $this->argument('motorId') ?: $this->askForMotorId();

    $motor = Motor::with('tarifRental', 'owner')->find($motorId);

    if (!$motor) {
      $this->error("Motor dengan ID {$motorId} tidak ditemukan!");
      return;
    }

    $this->info("🏍️ MOTOR: {$motor->merk} {$motor->model} ({$motor->tahun})");
    $this->info("👤 Owner: {$motor->owner->nama}");
    $this->info("💰 Tarif: Rp " . number_format($motor->tarifRental->tarif_harian ?? 0, 0, ',', '.') . "/hari");

    // Get rental history for this motor
    $rentals = Penyewaan::where('motor_id', $motorId)
      ->with(['penyewa', 'transaksi', 'bagiHasil'])
      ->orderBy('tanggal_mulai', 'desc')
      ->get();

    if ($rentals->isEmpty()) {
      $this->warn("❌ Motor ini belum memiliki riwayat penyewaan.");
      return;
    }

    $this->info("\n📅 RIWAYAT PENYEWAAN ({$rentals->count()} rental):");

    $headers = ['ID', 'Tanggal', 'Penyewa', 'Email', 'Durasi', 'Harga', 'Status'];
    $rows = [];

    foreach ($rentals as $rental) {
      $durasi = $rental->tanggal_mulai->diffInDays($rental->tanggal_selesai);
      $rows[] = [
        $rental->id,
        $rental->tanggal_mulai->format('d/m/Y'),
        $rental->penyewa->nama,
        $rental->penyewa->email,
        $durasi . ' hari',
        'Rp ' . number_format($rental->harga, 0, ',', '.'),
        $rental->status->value
      ];
    }

    $this->table($headers, $rows);

    // Check Gmail accounts in rentals
    $gmailRentals = $rentals->filter(function ($rental) {
      return str_contains($rental->penyewa->email, '@gmail.com');
    });

    $this->info("\n📧 ANALISIS EMAIL:");
    $this->info("• Total rentals: {$rentals->count()}");
    $this->info("• Gmail rentals: {$gmailRentals->count()}");
    $this->info("• Non-Gmail rentals: " . ($rentals->count() - $gmailRentals->count()));

    if ($gmailRentals->count() === $rentals->count()) {
      $this->info("✅ SEMUA rental menggunakan akun Gmail asli!");
    } else {
      $this->warn("⚠️ Ada rental yang tidak menggunakan Gmail");
    }

    // Show revenue generated
    $totalRevenue = $rentals->sum('harga');
    $this->info("\n💰 PENDAPATAN:");
    $this->info("• Total revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
  }

  private function askForMotorId()
  {
    // Show some motors with rental history
    $motorsWithRentals = Motor::whereHas('penyewaans')
      ->withCount('penyewaans')
      ->with('tarifRental')
      ->orderBy('penyewaans_count', 'desc')
      ->take(10)
      ->get();

    $this->info("🏍️ Motors dengan riwayat penyewaan:");
    foreach ($motorsWithRentals as $motor) {
      $this->info("ID {$motor->id}: {$motor->merk} {$motor->model} ({$motor->penyewaans_count} rentals)");
    }

    return $this->ask('Masukkan Motor ID yang ingin dilihat');
  }
}

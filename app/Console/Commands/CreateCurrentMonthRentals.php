<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use App\Models\BagiHasil;
use App\Models\Payment;
use App\Enums\BookingStatus;
use App\Enums\DurationType;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreateCurrentMonthRentals extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'create:current-month-rentals {ownerId?}';

  /**
   * The command description.
   *
   * @var string
   */
  protected $description = 'Create current month rentals for owner to show dynamic data';

  public function handle()
  {
    $ownerId = $this->argument('ownerId') ?: 2; // Default owner

    $owner = User::where('role', 'pemilik')->find($ownerId);
    if (!$owner) {
      $this->error("Owner not found!");
      return;
    }

    $this->info("🏍️ Creating current month rentals for: {$owner->nama}");

    // Get owner's motors
    $motors = Motor::where('pemilik_id', $ownerId)->get();
    if ($motors->isEmpty()) {
      $this->error("Owner has no motors!");
      return;
    }

    // Get Gmail renters
    $renters = User::where('role', 'penyewa')
      ->where('email', 'like', '%@gmail.com')
      ->get();

    if ($renters->isEmpty()) {
      $this->error("No Gmail renters found!");
      return;
    }

    $this->info("Found {$motors->count()} motors and {$renters->count()} renters");

    // Create 2-3 rentals for current month
    $currentMonth = Carbon::now();
    $rentalsCreated = 0;

    for ($i = 0; $i < 3; $i++) {
      $motor = $motors->random();
      $renter = $renters->random();

      // Skip if motor doesn't have tarif
      if (!$motor->tarifRental) {
        continue;
      }

      // Create rental dates in current month
      $tanggalMulai = $currentMonth->copy()->subDays(rand(5, 20));
      $tanggalSelesai = $tanggalMulai->copy()->addDays(rand(2, 7));

      $duration = $tanggalMulai->diffInDays($tanggalSelesai);
      $harga = $motor->tarifRental->tarif_harian * max(1, $duration);

      // Create completed rental
      $penyewaan = Penyewaan::create([
        'penyewa_id' => $renter->id,
        'motor_id' => $motor->id,
        'tanggal_mulai' => $tanggalMulai,
        'tanggal_selesai' => $tanggalSelesai,
        'tipe_durasi' => DurationType::HARIAN,
        'harga' => $harga,
        'status' => BookingStatus::COMPLETED,
        'catatan' => 'Rental bulan ini untuk testing dashboard',
        'confirmed_at' => $tanggalMulai->copy()->subDays(1),
        'started_at' => $tanggalMulai,
        'completed_at' => $tanggalSelesai,
        'created_at' => $tanggalMulai->copy()->subDays(2),
        'updated_at' => $tanggalSelesai,
      ]);

      // Create transaction
      $transaksi = Transaksi::create([
        'penyewaan_id' => $penyewaan->id,
        'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
        'jumlah' => $harga,
        'metode_pembayaran' => 'transfer',
        'status' => 'paid',
        'payment_details' => [
          'bank' => 'BCA',
          'account_number' => '1234567890',
          'account_name' => 'RideNow Rentals'
        ],
        'paid_at' => $penyewaan->confirmed_at,
        'catatan' => 'Pembayaran rental motor ' . $motor->merk . ' ' . $motor->model,
        'created_at' => $penyewaan->created_at,
        'updated_at' => $penyewaan->confirmed_at,
      ]);

      // Create payment record
      Payment::create([
        'penyewaan_id' => $penyewaan->id,
        'amount' => $harga,
        'payment_method' => 'transfer',
        'status' => 'completed',
        'bukti_transfer' => 'bukti-' . Str::random(8) . '.jpg',
        'paid_at' => $transaksi->paid_at,
        'verified_at' => $transaksi->paid_at->copy()->addHours(2),
        'verified_by' => 1,
        'catatan' => 'Pembayaran transfer bank',
        'created_at' => $penyewaan->created_at,
        'updated_at' => $transaksi->paid_at,
      ]);

      // Create bagi hasil for current month
      $bagiHasilPemilik = $harga * 0.70;
      $bagiHasilAdmin = $harga * 0.30;

      BagiHasil::create([
        'penyewaan_id' => $penyewaan->id,
        'pemilik_id' => $ownerId,
        'total_pendapatan' => $harga,
        'bagi_hasil_pemilik' => $bagiHasilPemilik,
        'bagi_hasil_admin' => $bagiHasilAdmin,
        'tanggal' => $currentMonth->format('Y-m-d'), // Current month date
        'settled_at' => $tanggalSelesai->copy()->addDays(1),
        'catatan' => 'Bagi hasil rental bulan ini',
        'created_at' => $tanggalSelesai,
        'updated_at' => $tanggalSelesai->copy()->addDays(1),
      ]);

      $rentalsCreated++;

      $this->info("✅ Created rental: {$motor->merk} {$motor->model} -> {$renter->nama} (Rp " . number_format($harga, 0, ',', '.') . ")");
    }

    $this->info("\n🎉 Created {$rentalsCreated} current month rentals!");
    $this->info("Now test dashboard at: http://127.0.0.1:8000/owner/dashboard");
    $this->info("Login with: {$owner->email} / password123");
  }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use App\Models\BagiHasil;
use App\Models\Payment;
use App\Enums\BookingStatus;
use App\Enums\DurationType;
use App\Enums\MotorStatus;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GmailRentalSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $this->command->info('Creating rental data with Gmail users...');

    // Get Gmail renters ONLY (email with @gmail.com domain)
    $renters = User::where('role', 'penyewa')
      ->where('email', 'like', '%@gmail.com')
      ->get();

    $motors = Motor::where('status', MotorStatus::AVAILABLE)->with('tarifRental')->get();

    if ($renters->isEmpty()) {
      $this->command->error('No Gmail renters found! Please run GmailRenterSeeder first.');
      return;
    }

    if ($motors->isEmpty()) {
      $this->command->error('No available motors found! Please run OwnerMotorSeeder first.');
      return;
    }

    $this->command->info("Found {$renters->count()} Gmail renters and {$motors->count()} available motors");

    // Clear existing rentals to start fresh (in correct order due to foreign keys)
    $this->command->info('Clearing existing rental data...');

    // Disable foreign key checks temporarily
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    BagiHasil::truncate();
    Payment::truncate();
    Transaksi::truncate();
    Penyewaan::truncate();

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Create rental data for the past 6 months
    $startDate = Carbon::now()->subMonths(6);
    $endDate = Carbon::now();

    $totalRentals = 0;

    // Generate more rentals since we have fewer Gmail users
    for ($month = 0; $month < 6; $month++) {
      $currentMonth = $startDate->copy()->addMonths($month);
      $rentalsThisMonth = rand(20, 35); // More rentals per month to compensate

      $this->command->info("Creating {$rentalsThisMonth} rentals for {$currentMonth->format('F Y')}");

      for ($i = 0; $i < $rentalsThisMonth; $i++) {
        $renter = $renters->random();
        $motor = $motors->random();

        // Skip if motor doesn't have tarif
        if (!$motor->tarifRental) {
          continue;
        }

        // Random rental dates within the month
        $tanggalMulai = $currentMonth->copy()->addDays(rand(1, 25));
        $durationType = collect([DurationType::HARIAN, DurationType::MINGGUAN, DurationType::BULANAN])->random();

        // Calculate end date based on duration type
        $tanggalSelesai = match ($durationType) {
          DurationType::HARIAN => $tanggalMulai->copy()->addDays(rand(1, 7)),
          DurationType::MINGGUAN => $tanggalMulai->copy()->addWeeks(rand(1, 3)),
          DurationType::BULANAN => $tanggalMulai->copy()->addMonth(),
        };

        // Calculate price
        $duration = $tanggalMulai->diffInDays($tanggalSelesai);
        $harga = $motor->tarifRental->tarif_harian * max(1, $duration);

        // Random status - mostly completed for historical data
        $status = $this->getRandomStatus($currentMonth);

        // Create penyewaan
        $penyewaan = Penyewaan::create([
          'penyewa_id' => $renter->id,
          'motor_id' => $motor->id,
          'tanggal_mulai' => $tanggalMulai,
          'tanggal_selesai' => $tanggalSelesai,
          'tipe_durasi' => $durationType,
          'harga' => $harga,
          'status' => $status,
          'catatan' => $this->getRandomNote(),
          'confirmed_at' => $status !== BookingStatus::PENDING ? $tanggalMulai->copy()->subDays(rand(1, 3)) : null,
          'started_at' => in_array($status, [BookingStatus::ACTIVE, BookingStatus::COMPLETED]) ? $tanggalMulai : null,
          'completed_at' => $status === BookingStatus::COMPLETED ? $tanggalSelesai : null,
          'created_at' => $tanggalMulai->copy()->subDays(rand(1, 7)),
          'updated_at' => $tanggalMulai->copy()->subDays(rand(0, 2)),
        ]);

        // Create transaction if confirmed
        if ($status !== BookingStatus::PENDING && $status !== BookingStatus::CANCELLED) {
          $metode = $this->getRandomPaymentMethod();

          $transaksi = Transaksi::create([
            'penyewaan_id' => $penyewaan->id,
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'jumlah' => $harga,
            'metode_pembayaran' => $metode,
            'status' => 'paid',
            'payment_details' => $this->getPaymentDetails($metode),
            'paid_at' => $penyewaan->confirmed_at,
            'catatan' => 'Pembayaran rental motor ' . $motor->merk . ' ' . $motor->model,
            'created_at' => $penyewaan->created_at,
            'updated_at' => $penyewaan->confirmed_at,
          ]);

          // Create payment record (only for transfer and cash methods)
          if (in_array($metode, ['transfer', 'cash'])) {
            Payment::create([
              'penyewaan_id' => $penyewaan->id,
              'amount' => $harga,
              'payment_method' => $metode,
              'status' => 'completed',
              'bukti_transfer' => $metode === 'transfer' ? 'bukti-' . Str::random(8) . '.jpg' : null,
              'paid_at' => $transaksi->paid_at,
              'verified_at' => $transaksi->paid_at->copy()->addHours(rand(1, 12)),
              'verified_by' => 1, // Admin user ID
              'catatan' => 'Pembayaran melalui ' . ($metode === 'transfer' ? 'transfer bank' : 'tunai'),
              'created_at' => $penyewaan->created_at,
              'updated_at' => $transaksi->paid_at,
            ]);
          }
        }

        // Create bagi hasil if completed
        if ($status === BookingStatus::COMPLETED) {
          $bagiHasilPemilik = $harga * 0.70; // 70% for owner
          $bagiHasilAdmin = $harga * 0.30;   // 30% for admin

          BagiHasil::create([
            'penyewaan_id' => $penyewaan->id,
            'pemilik_id' => $motor->pemilik_id,
            'total_pendapatan' => $harga,
            'bagi_hasil_pemilik' => $bagiHasilPemilik,
            'bagi_hasil_admin' => $bagiHasilAdmin,
            'tanggal' => $penyewaan->completed_at->toDateString(),
            'settled_at' => $penyewaan->completed_at->copy()->addDays(rand(1, 7)),
            'catatan' => 'Bagi hasil rental ' . $motor->merk . ' ' . $motor->model,
            'created_at' => $penyewaan->completed_at,
            'updated_at' => $penyewaan->completed_at->copy()->addDays(rand(1, 7)),
          ]);
        }

        $totalRentals++;
      }
    }

    $this->command->info("\n✅ Gmail Rental data creation completed!");
    $this->command->info("📊 Total rentals created: {$totalRentals}");
    $this->command->info("👥 Using {$renters->count()} Gmail renters");
    $this->command->info("🏍️ Using {$motors->count()} available motors");

    // Show sample Gmail renters used
    $this->command->info("\n📧 Gmail renters being used:");
    foreach ($renters->take(10) as $renter) {
      $this->command->info("- {$renter->nama} ({$renter->email})");
    }
    if ($renters->count() > 10) {
      $this->command->info("... and " . ($renters->count() - 10) . " more Gmail renters");
    }
  }

  private function getRandomStatus(Carbon $currentMonth): BookingStatus
  {
    $now = Carbon::now();

    if ($currentMonth->isFuture()) {
      // Future bookings - pending or confirmed
      return collect([BookingStatus::PENDING, BookingStatus::CONFIRMED])->random();
    } elseif ($currentMonth->isCurrentMonth()) {
      // Current month - mixed statuses with some active
      return collect([BookingStatus::ACTIVE, BookingStatus::COMPLETED, BookingStatus::CANCELLED])
        ->random();
    } else {
      // Past months - mostly completed
      $statuses = [
        BookingStatus::COMPLETED,
        BookingStatus::COMPLETED,
        BookingStatus::COMPLETED,
        BookingStatus::COMPLETED,
        BookingStatus::COMPLETED, // 5 completed
        BookingStatus::CANCELLED, // 1 cancelled
      ];
      return collect($statuses)->random();
    }
  }

  private function getRandomNote(): string
  {
    $notes = [
      'Untuk keperluan mudik lebaran',
      'Rental harian untuk jalan-jalan',
      'Kebutuhan transport kantor',
      'Liburan bersama keluarga',
      'Keperluan bisnis',
      'Transport sehari-hari',
      'Acara keluarga',
      'Perjalanan wisata',
      'Kebutuhan mendesak',
      'Pengganti kendaraan pribadi'
    ];

    return collect($notes)->random();
  }

  private function getRandomPaymentMethod(): string
  {
    $methods = ['transfer', 'cash', 'midtrans_snap', 'qris'];
    return collect($methods)->random();
  }

  private function getPaymentDetails(string $method): array
  {
    return match ($method) {
      'transfer' => [
        'bank' => collect(['BCA', 'BNI', 'BRI', 'Mandiri'])->random(),
        'account_number' => '1234567890',
        'account_name' => 'RideNow Rentals'
      ],
      'cash' => [
        'received_by' => 'Admin RideNow',
        'location' => 'Kantor RideNow'
      ],
      'midtrans_snap' => [
        'provider' => collect(['OVO', 'DANA', 'GoPay', 'LinkAja'])->random(),
        'phone' => '081234567890',
        'transaction_id' => 'MIDTRANS' . strtoupper(Str::random(8))
      ],
      'qris' => [
        'merchant_name' => 'RideNow Rentals',
        'transaction_id' => 'QRIS' . strtoupper(Str::random(10))
      ],
      default => []
    };
  }
}

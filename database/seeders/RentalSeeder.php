<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating rental data...');

        // Get all penyewa (renters) and motors
        $renters = User::where('role', 'penyewa')->get();
        $motors = Motor::where('status', MotorStatus::AVAILABLE)->with('tarifRental')->get();

        if ($renters->isEmpty()) {
            $this->command->error('No renters found! Please run CompleteUserSeeder first.');
            return;
        }

        if ($motors->isEmpty()) {
            $this->command->error('No available motors found! Please run OwnerMotorSeeder first.');
            return;
        }

        $this->command->info("Found {$renters->count()} renters and {$motors->count()} available motors");

        // Create rental data for the past 6 months
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        $totalRentals = 0;

        // Generate rentals for each month
        for ($month = 0; $month < 6; $month++) {
            $currentMonth = $startDate->copy()->addMonths($month);
            $rentalsThisMonth = rand(15, 25); // Random rentals per month

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

        $this->command->info("✅ Successfully created {$totalRentals} rental records with complete data!");
        $this->command->info("Data includes: Penyewaan, Transaksi, Payment, and BagiHasil");

        // Show statistics
        $this->showStatistics();
    }

    /**
     * Get random status based on current month (older rentals more likely to be completed)
     */
    private function getRandomStatus(Carbon $currentMonth): BookingStatus
    {
        $monthsAgo = $currentMonth->diffInMonths(Carbon::now());

        // Older rentals more likely to be completed
        if ($monthsAgo >= 3) {
            return collect([
                BookingStatus::COMPLETED,
                BookingStatus::COMPLETED,
                BookingStatus::COMPLETED,
                BookingStatus::COMPLETED,
                BookingStatus::CANCELLED,
            ])->random();
        } elseif ($monthsAgo >= 1) {
            return collect([
                BookingStatus::COMPLETED,
                BookingStatus::COMPLETED,
                BookingStatus::COMPLETED,
                BookingStatus::ACTIVE,
                BookingStatus::CANCELLED,
            ])->random();
        } else {
            // Current month - mix of all statuses
            return collect([
                BookingStatus::PENDING,
                BookingStatus::CONFIRMED,
                BookingStatus::ACTIVE,
                BookingStatus::COMPLETED,
                BookingStatus::CANCELLED,
            ])->random();
        }
    }

    /**
     * Get random payment method
     */
    private function getRandomPaymentMethod(): string
    {
        return collect([
            'transfer',
            'cash',
            'midtrans_snap',
            'qris',
        ])->random();
    }

    /**
     * Get payment details based on method
     */
    private function getPaymentDetails(string $method): array
    {
        return match ($method) {
            'transfer' => [
                'bank' => $this->getRandomBank(),
                'account_number' => 'xxxx-xxxx-' . rand(1000, 9999),
                'account_name' => 'RideNow Official',
            ],
            'cash' => [
                'location' => 'Kantor RideNow',
                'received_by' => 'Admin ' . collect(['A', 'B', 'C'])->random(),
            ],
            'midtrans_snap' => [
                'transaction_id' => 'MT-' . strtoupper(Str::random(10)),
                'payment_type' => collect(['bank_transfer', 'echannel', 'gopay', 'shopeepay'])->random(),
            ],
            'qris' => [
                'qr_id' => 'QR-' . strtoupper(Str::random(8)),
                'bank' => $this->getRandomBank(),
            ],
        };
    }

    /**
     * Get random bank name
     */
    private function getRandomBank(): string
    {
        return collect([
            'BCA',
            'BNI',
            'BRI',
            'Mandiri',
            'CIMB Niaga',
            'Danamon',
            'Permata',
            'BTN',
        ])->random();
    }

    /**
     * Get random rental note
     */
    private function getRandomNote(): ?string
    {
        $notes = [
            'Rental untuk keperluan kerja',
            'Rental untuk liburan keluarga',
            'Rental jangka pendek',
            'Rental untuk keperluan sekolah',
            'Rental harian',
            'Motor dalam kondisi baik',
            'Penyewa sangat baik dan bertanggung jawab',
            'Rental untuk keperluan bisnis',
            null, // Some rentals don't have notes
            null,
            null,
        ];

        return collect($notes)->random();
    }

    /**
     * Show rental statistics
     */
    private function showStatistics(): void
    {
        $totalPenyewaan = Penyewaan::count();
        $totalTransaksi = Transaksi::count();
        $totalBagiHasil = BagiHasil::count();
        $totalPayment = Payment::count();

        $pendingCount = Penyewaan::where('status', BookingStatus::PENDING)->count();
        $confirmedCount = Penyewaan::where('status', BookingStatus::CONFIRMED)->count();
        $activeCount = Penyewaan::where('status', BookingStatus::ACTIVE)->count();
        $completedCount = Penyewaan::where('status', BookingStatus::COMPLETED)->count();
        $cancelledCount = Penyewaan::where('status', BookingStatus::CANCELLED)->count();

        $totalRevenue = BagiHasil::sum('total_pendapatan');
        $ownerRevenue = BagiHasil::sum('bagi_hasil_pemilik');
        $adminRevenue = BagiHasil::sum('bagi_hasil_admin');

        $this->command->info("\n📊 RENTAL STATISTICS:");
        $this->command->info("Total Penyewaan: {$totalPenyewaan}");
        $this->command->info("Total Transaksi: {$totalTransaksi}");
        $this->command->info("Total Payment: {$totalPayment}");
        $this->command->info("Total BagiHasil: {$totalBagiHasil}");

        $this->command->info("\n📈 STATUS BREAKDOWN:");
        $this->command->info("Pending: {$pendingCount}");
        $this->command->info("Confirmed: {$confirmedCount}");
        $this->command->info("Active: {$activeCount}");
        $this->command->info("Completed: {$completedCount}");
        $this->command->info("Cancelled: {$cancelledCount}");

        $this->command->info("\n💰 REVENUE BREAKDOWN:");
        $this->command->info("Total Revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $this->command->info("Owner Revenue (70%): Rp " . number_format($ownerRevenue, 0, ',', '.'));
        $this->command->info("Admin Revenue (30%): Rp " . number_format($adminRevenue, 0, ',', '.'));
    }
}

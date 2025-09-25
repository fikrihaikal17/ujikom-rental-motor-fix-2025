<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motor;
use App\Models\TarifRental;
use App\Enums\DurationType;

class TarifRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating tariff rental data...');

        // Get all motors that don't have tariff yet
        $motors = Motor::whereDoesntHave('tarifRental')->get();

        if ($motors->isEmpty()) {
            $this->command->info('All motors already have tariff data.');
            return;
        }

        $this->command->info("Found {$motors->count()} motors without tariff");

        $created = 0;

        foreach ($motors as $motor) {
            // Base price based on CC
            $basePrice = match ($motor->tipe_cc) {
                100 => rand(75000, 100000),   // 75k - 100k for 100cc
                125 => rand(85000, 120000),   // 85k - 120k for 125cc
                150 => rand(100000, 150000),  // 100k - 150k for 150cc
                default => rand(90000, 130000)
            };

            // Adjust price based on year (newer = more expensive)
            $yearFactor = ($motor->tahun - 2015) * 5000; // 5k per year from 2015
            $finalPrice = max(75000, $basePrice + $yearFactor);

            // Create tarif rental
            TarifRental::create([
                'motor_id' => $motor->id,
                'tarif_harian' => $finalPrice,
                'tarif_mingguan' => $finalPrice * 6.5, // Slight discount for weekly
                'tarif_bulanan' => $finalPrice * 25,   // Significant discount for monthly
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $created++;
        }

        $this->command->info("✅ Successfully created {$created} tariff rental records!");

        // Show statistics
        $this->showTariffStatistics();
    }

    /**
     * Get random note for tariff
     */
    private function getRandomNote(Motor $motor): ?string
    {
        $notes = [
            'Harga sudah termasuk bensin untuk jarak dekat',
            'Motor dalam kondisi prima dan terawat',
            'Termasuk helm dan jaket hujan',
            'Harga dapat berubah pada musim liburan',
            'Diskon tersedia untuk rental jangka panjang',
            'Motor cocok untuk perjalanan dalam kota',
            'Sangat ekonomis untuk penggunaan sehari-hari',
            null,
            null,
        ];

        return collect($notes)->random();
    }

    /**
     * Show tariff statistics
     */
    private function showTariffStatistics(): void
    {
        $totalTariff = TarifRental::count();
        $avgDailyPrice = TarifRental::avg('tarif_harian');
        $minPrice = TarifRental::min('tarif_harian');
        $maxPrice = TarifRental::max('tarif_harian');

        // Group by CC type
        $tariff100cc = TarifRental::whereHas('motor', function ($q) {
            $q->where('tipe_cc', 100);
        })->avg('tarif_harian');

        $tariff125cc = TarifRental::whereHas('motor', function ($q) {
            $q->where('tipe_cc', 125);
        })->avg('tarif_harian');

        $tariff150cc = TarifRental::whereHas('motor', function ($q) {
            $q->where('tipe_cc', 150);
        })->avg('tarif_harian');

        $this->command->info("\n📊 TARIFF STATISTICS:");
        $this->command->info("Total Tariff Records: {$totalTariff}");
        $this->command->info("Average Daily Price: Rp " . number_format($avgDailyPrice, 0, ',', '.'));
        $this->command->info("Minimum Price: Rp " . number_format($minPrice, 0, ',', '.'));
        $this->command->info("Maximum Price: Rp " . number_format($maxPrice, 0, ',', '.'));

        $this->command->info("\n🏍️ PRICE BY CC TYPE:");
        if ($tariff100cc) {
            $this->command->info("100cc Average: Rp " . number_format($tariff100cc, 0, ',', '.'));
        }
        if ($tariff125cc) {
            $this->command->info("125cc Average: Rp " . number_format($tariff125cc, 0, ',', '.'));
        }
        if ($tariff150cc) {
            $this->command->info("150cc Average: Rp " . number_format($tariff150cc, 0, ',', '.'));
        }
    }
}

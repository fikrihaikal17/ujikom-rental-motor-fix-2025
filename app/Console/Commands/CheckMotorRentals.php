<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\Penyewaan;

class CheckMotorRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:motor-rentals {motor_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check rental data for specific motor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $motorId = $this->argument('motor_id');

        if (!$motorId) {
            // Find motors with rentals
            $this->info("🔍 Finding motors with rentals...");
            $motorsWithRentals = Motor::has('penyewaans')->with('owner')->take(10)->get();

            if ($motorsWithRentals->count() > 0) {
                $this->info("Found {$motorsWithRentals->count()} motors with rentals:");
                foreach ($motorsWithRentals as $motor) {
                    $rentalCount = $motor->penyewaans()->count();
                    $owner = $motor->owner ? $motor->owner->name : 'No owner';
                    $this->info("- Motor ID: {$motor->id} | {$motor->merk} {$motor->model} | Owner: {$owner} | Rentals: {$rentalCount}");
                }

                $firstMotor = $motorsWithRentals->first();
                $this->info("\n📋 Checking first motor (ID: {$firstMotor->id}) in detail...");
                $motorId = $firstMotor->id;
            } else {
                $this->error("❌ No motors with rentals found!");
                return;
            }
        }

        $motor = Motor::with('owner')->find($motorId);

        if (!$motor) {
            $this->error("Motor with ID {$motorId} not found!");
            return;
        }

        $this->info("🏍️ Motor: {$motor->merk} {$motor->model} ({$motor->tahun})");
        $this->info("Owner: " . ($motor->owner ? $motor->owner->name : 'No owner found'));

        // Check rentals directly
        $rentals = Penyewaan::where('motor_id', $motorId)->with('penyewa')->get();

        $this->info("📊 Total rentals: {$rentals->count()}");

        if ($rentals->count() > 0) {
            $this->info("\n📋 Recent rentals:");
            foreach ($rentals->take(5) as $rental) {
                $renterName = $rental->penyewa ? $rental->penyewa->name : 'Unknown';
                $this->info("- ID: {$rental->id} | Renter: {$renterName} | Status: {$rental->status->value} | Price: Rp " . number_format($rental->harga, 0, ',', '.'));
            }
        } else {
            $this->warn("❌ No rentals found for this motor");
        }

        // Check relationship loading
        $motorWithRentals = Motor::with('penyewaans.penyewa')->find($motorId);
        $this->info("\n🔗 Rentals via relationship: {$motorWithRentals->penyewaans->count()}");

        // Show sample rental data structure
        if ($rentals->count() > 0) {
            $sample = $rentals->first();
            $this->info("\n📄 Sample rental data:");
            $this->info("ID: {$sample->id}");
            $this->info("Motor ID: {$sample->motor_id}");
            $this->info("Renter ID: {$sample->penyewa_id}");
            $this->info("Start: {$sample->tanggal_mulai}");
            $this->info("End: {$sample->tanggal_selesai}");
            $this->info("Price: {$sample->harga}");
            $this->info("Status: {$sample->status->value}");
        }
    }
}

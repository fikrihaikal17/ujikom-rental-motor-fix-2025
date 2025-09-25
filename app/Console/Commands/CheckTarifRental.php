<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\TarifRental;

class CheckTarifRental extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:tarif-rental';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tarif rental data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking Tarif Rental Data...');
        $this->line('');

        $totalMotors = Motor::count();
        $totalTarif = TarifRental::count();

        $this->info("Total Motors: {$totalMotors}");
        $this->info("Total Tarif Rental: {$totalTarif}");

        $motorsWithTarif = Motor::whereHas('tarifRental')->count();
        $motorsWithoutTarif = Motor::whereDoesntHave('tarifRental')->count();

        $this->line('');
        $this->info("Motors with tarif: {$motorsWithTarif}");
        $this->info("Motors without tarif: {$motorsWithoutTarif}");

        if ($motorsWithTarif > 0) {
            $this->line('');
            $this->comment('Sample motors with tarif:');
            $motorsWithPrices = Motor::with('tarifRental')->whereHas('tarifRental')->take(5)->get();
            foreach ($motorsWithPrices as $motor) {
                $tarif = $motor->tarifRental;
                $this->line("  - {$motor->merk} {$motor->model}: Harian Rp " . number_format($tarif->tarif_harian, 0, ',', '.') .
                    ($tarif->tarif_mingguan ? ', Mingguan Rp ' . number_format($tarif->tarif_mingguan, 0, ',', '.') : ''));
            }
        }

        if ($motorsWithoutTarif > 0) {
            $this->line('');
            $this->comment('Sample motors without tarif:');
            $motorsWithoutPrices = Motor::whereDoesntHave('tarifRental')->take(5)->get();
            foreach ($motorsWithoutPrices as $motor) {
                $this->line("  - {$motor->merk} {$motor->model} ({$motor->no_plat})");
            }
        }

        $this->line('');
        if ($motorsWithoutTarif > 0) {
            $this->error("Issue: {$motorsWithoutTarif} motors don't have tarif rental!");
            $this->comment('Solution: Run tarif rental seeder to add prices for all motors');
        } else {
            $this->info('✓ All motors have tarif rental data');
        }
    }
}

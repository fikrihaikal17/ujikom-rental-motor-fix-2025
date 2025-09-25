<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupRentalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:rental-data {--fresh : Drop all rental data and recreate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup complete rental data including tariffs and rentals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Setting up rental data for RideNow...');

        if ($this->option('fresh')) {
            $this->info('🗑️ Cleaning up existing rental data...');
            $this->call('db:wipe');
            $this->call('migrate');
            $this->info('✅ Database recreated');

            // Run all basic seeders first
            $this->info('📝 Running basic seeders...');
            $this->call('db:seed', ['--class' => 'CompleteUserSeeder']);
            $this->call('db:seed', ['--class' => 'OwnerMotorSeeder']);
        }

        // Check if basic data exists
        $userCount = \App\Models\User::count();
        $motorCount = \App\Models\Motor::count();

        if ($userCount === 0) {
            $this->error('❌ No users found! Please run CompleteUserSeeder first.');
            $this->info('Run: php artisan db:seed --class=CompleteUserSeeder');
            return;
        }

        if ($motorCount === 0) {
            $this->error('❌ No motors found! Please run OwnerMotorSeeder first.');
            $this->info('Run: php artisan db:seed --class=OwnerMotorSeeder');
            return;
        }

        $this->info("✅ Found {$userCount} users and {$motorCount} motors");

        // Setup tariffs
        $this->info('💰 Setting up rental tariffs...');
        $this->call('db:seed', ['--class' => 'TarifRentalSeeder']);

        // Setup Gmail renters
        $this->info('📧 Setting up Gmail renters...');
        $this->call('db:seed', ['--class' => 'GmailRenterSeeder']);

        // Setup rental data with Gmail users
        $this->info('🏍️ Setting up rental transactions with Gmail users...');
        $this->call('db:seed', ['--class' => 'GmailRentalSeeder']);

        $this->info('✅ All rental data setup completed!');
        $this->showSummary();
    }

    private function showSummary()
    {
        $this->info("\n📊 DATA SUMMARY:");

        $users = \App\Models\User::count();
        $owners = \App\Models\User::where('role', 'pemilik')->count();
        $renters = \App\Models\User::where('role', 'penyewa')->count();
        $motors = \App\Models\Motor::count();
        $tariffs = \App\Models\TarifRental::count();
        $rentals = \App\Models\Penyewaan::count();
        $transactions = \App\Models\Transaksi::count();
        $payments = \App\Models\Payment::count();
        $revenues = \App\Models\BagiHasil::count();

        $totalRevenue = \App\Models\BagiHasil::sum('total_pendapatan');
        $ownerRevenue = \App\Models\BagiHasil::sum('bagi_hasil_pemilik');

        $this->table(['Type', 'Count'], [
            ['Total Users', $users],
            ['Owners', $owners],
            ['Renters', $renters],
            ['Motors', $motors],
            ['Tariffs', $tariffs],
            ['Rentals', $rentals],
            ['Transactions', $transactions],
            ['Payments', $payments],
            ['Revenue Shares', $revenues],
        ]);

        $this->info("💰 Total Revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $this->info("👥 Owner Revenue: Rp " . number_format($ownerRevenue, 0, ',', '.'));

        // Show Gmail renter count
        $gmailRenters = \App\Models\User::where('role', 'penyewa')
            ->where('email', 'like', '%@gmail.com')->count();
        $this->info("📧 Gmail Renters: {$gmailRenters} authentic accounts");

        $this->info("\n🌐 You can now access:");
        $this->info("• Owner Rentals Report: http://127.0.0.1:8000/owner/rentals/report");
        $this->info("• Admin Dashboard: http://127.0.0.1:8000/admin/dashboard");
        $this->info("• Owner Dashboard: http://127.0.0.1:8000/owner/dashboard");
        $this->info("✨ All rental data now uses AUTHENTIC Gmail accounts!");
    }
}

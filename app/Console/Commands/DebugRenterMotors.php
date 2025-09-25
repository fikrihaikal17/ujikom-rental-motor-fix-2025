<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Motor;
use App\Models\Penyewaan;
use App\Enums\MotorStatus;
use App\Enums\BookingStatus;

class DebugRenterMotors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:renter-motors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug renter motors page - why no motors showing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Debugging Renter Motors Page...');
        $this->line('');

        // Check total motors
        $totalMotors = Motor::count();
        $this->info("Total Motors in database: {$totalMotors}");

        if ($totalMotors === 0) {
            $this->error('No motors found in database!');
            return;
        }

        // Check motor statuses
        $this->line('');
        $this->comment('Motor Status Distribution:');
        $statuses = Motor::groupBy('status')->selectRaw('status, count(*) as count')->get();
        foreach ($statuses as $status) {
            $this->line("  - {$status->status->value}: {$status->count} motors");
        }

        // Check ketersediaan
        $this->line('');
        $this->comment('Motor Availability Distribution:');
        $availability = Motor::groupBy('ketersediaan')->selectRaw('ketersediaan, count(*) as count')->get();
        foreach ($availability as $avail) {
            $this->line("  - {$avail->ketersediaan}: {$avail->count} motors");
        }

        // Check motors that should be available for rent
        $this->line('');
        $this->comment('Checking motors that should be available for rent...');

        $availableMotors = Motor::where('status', MotorStatus::VERIFIED)
            ->where('ketersediaan', 'tersedia')
            ->get();

        $this->line("Motors with VERIFIED status and 'tersedia' availability: {$availableMotors->count()}");

        // Check different status combinations
        $verifiedMotors = Motor::where('status', MotorStatus::VERIFIED)->count();
        $this->line("Motors with VERIFIED status: {$verifiedMotors}");

        $availableStatusMotors = Motor::where('status', MotorStatus::AVAILABLE)->count();
        $this->line("Motors with AVAILABLE status: {$availableStatusMotors}");

        $tersediaMotors = Motor::where('ketersediaan', 'tersedia')->count();
        $this->line("Motors with 'tersedia' ketersediaan: {$tersediaMotors}");

        // Check with exact controller query
        $this->line('');
        $this->comment('Testing exact controller query...');

        $queryResult = Motor::where('status', MotorStatus::AVAILABLE)
            ->where('ketersediaan', 'tersedia')
            ->whereDoesntHave('penyewaans', function ($query) {
                $query->whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
                    ->where(function ($q) {
                        $q->where('tanggal_selesai', '>=', now())
                            ->orWhereNull('completed_at');
                    });
            })
            ->with(['owner', 'tarifRental'])
            ->get();

        $this->line("Motors matching controller query: {$queryResult->count()}");

        if ($queryResult->count() > 0) {
            $this->line('');
            $this->comment('Sample available motors:');
            foreach ($queryResult->take(3) as $motor) {
                $this->line("  - {$motor->merk} {$motor->nama_motor} ({$motor->no_plat}) - Status: {$motor->status->value}, Ketersediaan: {$motor->ketersediaan}");
            }
        }

        // Check if there are active rentals
        $this->line('');
        $this->comment('Checking active rentals...');
        $activeRentals = Penyewaan::whereIn('status', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE])
            ->where(function ($q) {
                $q->where('tanggal_selesai', '>=', now())
                    ->orWhereNull('completed_at');
            })
            ->count();
        $this->line("Active rentals: {$activeRentals}");

        $this->line('');

        if ($queryResult->count() === 0) {
            $this->error('Issue found: No motors match the controller query criteria!');
            $this->line('');
            $this->comment('Possible solutions:');
            $this->line('1. Check if motors have VERIFIED status (not AVAILABLE)');
            $this->line('2. Check if ketersediaan field is set to "tersedia"');
            $this->line('3. Check if there are conflicting active rentals');
            $this->line('4. Run motor seeder to ensure proper data');
        } else {
            $this->info('✓ Query should work - motors are available!');
        }

        $this->line('');
        $this->info('Debug completed!');
    }
}

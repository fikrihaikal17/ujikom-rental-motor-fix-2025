<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Motor;
use App\Enums\UserRole;
use App\Enums\MotorStatus;
use App\Enums\BookingStatus;
use Illuminate\Support\Facades\Route;

class TestRenterMotorsPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:renter-motors-page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test renter motors page functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Renter Motors Page...');
        $this->line('');

        // Test routes
        $routes = [
            'renter.motors.index' => 'Motors Index Page',
            'login' => 'Login Page'
        ];

        foreach ($routes as $routeName => $description) {
            try {
                $url = route($routeName);
                $this->info("✓ {$description}: {$routeName} -> {$url}");
            } catch (\Exception $e) {
                $this->error("✗ {$description}: {$routeName} -> ERROR: " . $e->getMessage());
            }
        }

        $this->line('');

        // Test motor data that should be shown
        $availableMotors = Motor::where('status', MotorStatus::AVAILABLE)
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

        $this->info("✓ Available motors for rent: {$availableMotors->count()}");

        if ($availableMotors->count() > 0) {
            $this->line('');
            $this->comment('Sample motors that should appear:');
            foreach ($availableMotors->take(5) as $motor) {
                $harga = $motor->tarifRental ? 'Rp ' . number_format($motor->tarifRental->tarif_harian, 0, ',', '.') : 'No price';
                $owner = $motor->owner ? $motor->owner->nama : 'No owner';
                $this->line("  - {$motor->merk} {$motor->model} ({$motor->no_plat}) - {$harga}/hari - Owner: {$owner}");
            }
        }

        // Check brands
        $brands = Motor::where('status', MotorStatus::AVAILABLE)
            ->where('ketersediaan', 'tersedia')
            ->distinct()
            ->pluck('merk')
            ->sort();

        $this->line('');
        $this->info("✓ Available brands: {$brands->count()}");
        if ($brands->count() > 0) {
            $this->line('Brands: ' . $brands->take(10)->implode(', '));
        }

        // Check if there's a renter user
        $renter = User::where('role', UserRole::PENYEWA)->first();
        if ($renter) {
            $this->line('');
            $this->info("✓ Renter user found: {$renter->nama} ({$renter->email})");
        } else {
            $this->line('');
            $this->comment('Note: No renter user found. You can still access as guest.');
        }

        $this->line('');
        $this->info('Renter motors page test completed!');

        $this->line('');
        $this->comment('Access Information:');
        $this->line('URL: http://127.0.0.1:8000/renter/motors');
        if ($renter) {
            $this->line("Login as renter: {$renter->email} / password123");
        }
        $this->line('Or access as guest (if allowed)');

        $this->line('');
        $this->comment('Expected Result:');
        $this->line('- Should show ' . $availableMotors->count() . ' available motors');
        $this->line('- Should show search and filter options');
        $this->line('- Should show motor cards with details and booking buttons');
    }
}

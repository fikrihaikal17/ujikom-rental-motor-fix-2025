<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestOwnerDashboardLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:owner-dashboard-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test owner dashboard button links';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Owner Dashboard Button Links...');
        $this->line('');

        // Test routes yang digunakan di dashboard
        $routes = [
            'owner.motors.create' => 'Daftarkan Motor Baru',
            'owner.motors.index' => 'Kelola Motor',
            'owner.revenue.history' => 'Laporan Bagi Hasil'
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
        $this->info('Dashboard links test completed!');

        // Additional info
        $this->line('');
        $this->comment('Login credentials untuk testing:');
        $this->line('Email: owner@gmail.com');
        $this->line('Password: password123');
        $this->line('URL: http://127.0.0.1:8000/owner/dashboard');
    }
}

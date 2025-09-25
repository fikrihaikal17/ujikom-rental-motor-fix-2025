<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Enums\UserRole;

class TestOwnerSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:owner-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test owner settings page functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Owner Settings Page...');
        $this->line('');

        // Test routes
        $routes = [
            'owner.settings' => 'Settings Page',
            'owner.settings.update' => 'Settings Update'
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

        // Test owner user data
        $owner = User::where('role', UserRole::PEMILIK)->first();
        if ($owner) {
            $this->info('✓ Owner user found:');
            $this->line("  - Name: {$owner->nama}");
            $this->line("  - Email: {$owner->email}");
            $this->line("  - Phone: " . ($owner->no_telepon ?? 'Not set'));
            $this->line("  - Address: " . ($owner->alamat ?? 'Not set'));
            $this->line("  - Created: {$owner->created_at->format('d F Y')}");
        } else {
            $this->error('✗ No owner user found');
        }

        $this->line('');
        $this->info('Settings page test completed!');

        // Login info
        $this->line('');
        $this->comment('Login credentials untuk testing:');
        $this->line('Email: owner@gmail.com');
        $this->line('Password: password123');
        $this->line('Settings URL: http://127.0.0.1:8000/owner/settings');
    }
}

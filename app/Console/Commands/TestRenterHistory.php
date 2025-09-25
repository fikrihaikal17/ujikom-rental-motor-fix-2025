<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penyewaan;
use App\Models\User;
use App\Models\Motor;

class TestRenterHistory extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:renter-history';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test renter history page functionality';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('Testing Renter History Page...');
    $this->line('');

    // Test routes
    $routes = [
      'renter.history' => 'History Index Page',
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

    // Test booking data
    $totalBookings = Penyewaan::count();
    $this->info("✓ Total bookings in database: {$totalBookings}");

    if ($totalBookings > 0) {
      $this->line('');
      $this->comment('Sample bookings with motor photos:');
      $bookings = Penyewaan::with('motor')->take(5)->get();
      foreach ($bookings as $booking) {
        $motor = $booking->motor;
        $photoStatus = $motor->photo ? '✓ Has photo' : '✗ No photo';
        $photoPath = $motor->photo ? $motor->photo : 'N/A';
        $this->line("  - {$motor->merk} {$motor->model} ({$motor->no_plat}) - {$photoStatus}: {$photoPath}");
      }
    }

    // Check renter user
    $renter = User::where('email', 'renter@gmail.com')->first();
    if ($renter) {
      $this->line('');
      $this->info("✓ Renter user found: {$renter->nama} ({$renter->email})");

      $renterBookings = Penyewaan::where('penyewa_id', $renter->id)->count();
      $this->info("✓ Renter's booking history: {$renterBookings} bookings");
    } else {
      $this->error('✗ Renter user not found');
    }

    $this->line('');
    $this->info('Renter history page test completed!');
    $this->line('');
    $this->comment('Access Information:');
    $this->line('URL: http://127.0.0.1:8000/renter/history');
    $this->line('Login as renter: renter@gmail.com / password123');
    $this->line('');
    $this->comment('Expected Result:');
    $this->line('- Should show booking history with motor images');
    $this->line('- Should show motor details and booking information');
    $this->line('- Should have filter options and export functionality');
  }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penyewaan;
use App\Models\User;

class TestGmailRentals extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:gmail-rentals';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test Gmail rental data authenticity';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('🔍 Testing Gmail Rental Data Authenticity...');

    // Check Gmail renters
    $gmailRenters = User::where('role', 'penyewa')
      ->where('email', 'like', '%@gmail.com')
      ->count();

    $totalRenters = User::where('role', 'penyewa')->count();

    $this->info("📧 Gmail Renters: {$gmailRenters} out of {$totalRenters} total renters");

    // Check rentals using Gmail accounts
    $gmailRentals = Penyewaan::whereHas('penyewa', function ($query) {
      $query->where('email', 'like', '%@gmail.com');
    })->count();

    $totalRentals = Penyewaan::count();

    $this->info("🏍️ Gmail Rentals: {$gmailRentals} out of {$totalRentals} total rentals");

    // Show sample rental data
    $this->info("\n📋 Sample Gmail Rental Data:");
    $sampleRentals = Penyewaan::with('penyewa', 'motor')
      ->whereHas('penyewa', function ($query) {
        $query->where('email', 'like', '%@gmail.com');
      })
      ->take(10)
      ->get();

    $headers = ['ID', 'Penyewa', 'Email', 'Motor', 'Status'];
    $rows = [];

    foreach ($sampleRentals as $rental) {
      $rows[] = [
        $rental->id,
        $rental->penyewa->nama,
        $rental->penyewa->email,
        $rental->motor->merk . ' ' . $rental->motor->model,
        $rental->status->value
      ];
    }

    $this->table($headers, $rows);

    // Check for non-Gmail rentals (should be 0)
    $nonGmailRentals = Penyewaan::whereHas('penyewa', function ($query) {
      $query->where('email', 'not like', '%@gmail.com');
    })->count();

    if ($nonGmailRentals === 0) {
      $this->info("✅ ALL rentals use authentic Gmail accounts!");
    } else {
      $this->error("❌ Found {$nonGmailRentals} rentals with non-Gmail accounts");
    }

    $this->info("\n🔍 Email Domain Analysis:");
    $emailDomains = User::where('role', 'penyewa')
      ->selectRaw('SUBSTRING_INDEX(email, "@", -1) as domain, COUNT(*) as count')
      ->groupBy('domain')
      ->get();

    foreach ($emailDomains as $domain) {
      $this->info("• {$domain->domain}: {$domain->count} accounts");
    }
  }
}

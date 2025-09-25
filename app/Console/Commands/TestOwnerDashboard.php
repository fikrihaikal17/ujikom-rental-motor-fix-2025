<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Http\Controllers\Owner\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestOwnerDashboard extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:owner-dashboard {ownerId?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test owner dashboard functionality';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $ownerId = $this->argument('ownerId') ?: 14; // Agus Setiawan with more data

    $owner = User::where('role', 'pemilik')->find($ownerId);

    if (!$owner) {
      $this->error("Owner dengan ID {$ownerId} tidak ditemukan!");
      return;
    }

    $this->info("🔍 Testing dashboard untuk: {$owner->nama}");

    try {
      // Simulate authentication
      Auth::login($owner);

      // Create controller instance
      $controller = new OwnerController();

      // Call dashboard method
      $response = $controller->dashboard();

      // Check if response has view data
      if ($response instanceof \Illuminate\View\View) {
        $data = $response->getData();

        $this->info("✅ Dashboard berhasil dimuat!");
        $this->info("\n📊 DATA YANG DIKIRIM KE VIEW:");

        if (isset($data['stats'])) {
          $stats = $data['stats'];
          $this->info("Stats:");
          foreach ($stats as $key => $value) {
            if (is_numeric($value)) {
              $formatted = is_float($value) ? 'Rp ' . number_format($value, 0, ',', '.') : $value;
              $this->info("  • {$key}: {$formatted}");
            } else {
              $this->info("  • {$key}: {$value}");
            }
          }
        }

        if (isset($data['recent_motors'])) {
          $this->info("\nRecent Motors: " . $data['recent_motors']->count() . " items");
        }

        if (isset($data['recentRentals'])) {
          $this->info("Recent Rentals: " . $data['recentRentals']->count() . " items");
        }

        if (isset($data['chart_data'])) {
          $chartData = $data['chart_data'];
          $this->info("Chart Data: " . count($chartData['labels']) . " months");
        }

        $this->info("\n🎉 Dashboard dinamis berfungsi dengan sempurna!");
      } else {
        $this->error("❌ Response bukan view instance");
      }
    } catch (\Exception $e) {
      $this->error("❌ Error saat testing dashboard:");
      $this->error($e->getMessage());
      $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
    } finally {
      Auth::logout();
    }
  }
}

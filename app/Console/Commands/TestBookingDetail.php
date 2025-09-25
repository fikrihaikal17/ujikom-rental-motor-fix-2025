<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penyewaan;
use App\Models\User;

class TestBookingDetail extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:booking-detail {id=165}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test booking detail page functionality';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $bookingId = $this->argument('id');
    $this->info("Testing Booking Detail Page for ID: {$bookingId}");
    $this->line('');

    // Test routes
    try {
      $url = route('renter.bookings.show', $bookingId);
      $this->info("✓ Booking Detail URL: {$url}");
    } catch (\Exception $e) {
      $this->error("✗ Route Error: " . $e->getMessage());
      return;
    }

    // Test booking data loading
    try {
      $booking = Penyewaan::with(['motor', 'motor.owner', 'transaksi', 'payments'])->find($bookingId);

      if (!$booking) {
        $this->error("✗ Booking with ID {$bookingId} not found");
        return;
      }

      $this->info("✓ Booking found: ID {$booking->id}");
      $this->info("✓ Motor: {$booking->motor->merk} {$booking->motor->model}");
      $this->info("✓ Owner: {$booking->motor->owner->nama}");
      $this->info("✓ Status: {$booking->status->value}");
      $this->info("✓ Price: Rp " . number_format($booking->harga, 0, ',', '.'));

      $this->line('');
      if ($booking->transaksi) {
        $this->info("✓ Transaction found");
        $transaksi = $booking->transaksi;
        $this->line("  - Transaction ID: {$transaksi->kode_transaksi}");
        $this->line("  - Method: {$transaksi->metode_pembayaran}");
        $this->line("  - Status: {$transaksi->status}");
        $this->line("  - Amount: Rp " . number_format($transaksi->jumlah, 0, ',', '.'));
      } else {
        $this->warn("⚠ No transaction found for this booking");
      }

      $this->line('');
      $this->info("✓ Payments count: " . $booking->payments->count());
      if ($booking->payments->count() > 0) {
        $payment = $booking->payments->first();
        $this->line("  - Payment Method: {$payment->payment_method}");
        $this->line("  - Status: {$payment->status}");
        $this->line("  - Amount: Rp " . number_format($payment->amount, 0, ',', '.'));
        $this->line("  - Bukti Transfer: " . ($payment->bukti_transfer ?? 'N/A'));
      }
    } catch (\Exception $e) {
      $this->error("✗ Data Loading Error: " . $e->getMessage());
      return;
    }

    // Check renter user
    $renter = User::where('email', 'renter@gmail.com')->first();
    if ($renter) {
      $this->line('');
      $this->info("✓ Renter user found: {$renter->nama} ({$renter->email})");

      if ($booking->penyewa_id === $renter->id) {
        $this->info("✓ Booking belongs to renter user");
      } else {
        $this->warn("⚠ Booking belongs to different user (ID: {$booking->penyewa_id})");
      }
    }

    $this->line('');
    $this->info('Booking detail test completed!');
    $this->line('');
    $this->comment('Access Information:');
    $this->line("URL: http://127.0.0.1:8000/renter/bookings/{$bookingId}");
    $this->line('Login as renter: renter@gmail.com / password123');
    $this->line('');
    $this->comment('Expected Result:');
    $this->line('- Should show booking details with motor information');
    $this->line('- Should show transaction and payment information');
    $this->line('- Should display booking status and actions');
  }
}

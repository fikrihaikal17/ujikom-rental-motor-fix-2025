<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ShowOwnerCredentials extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'show:owner-credentials';

  /**
   * The command description.
   *
   * @var string
   */
  protected $description = 'Show owner login credentials';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info("🔑 OWNER LOGIN CREDENTIALS:");

    $owners = User::where('role', 'pemilik')
      ->select('id', 'nama', 'email')
      ->orderBy('id')
      ->take(10)
      ->get();

    $headers = ['ID', 'Nama', 'Email', 'Password'];
    $rows = [];

    foreach ($owners as $owner) {
      $rows[] = [
        $owner->id,
        $owner->nama,
        $owner->email,
        'password123'
      ];
    }

    $this->table($headers, $rows);

    $this->info("\n🌟 RECOMMENDED OWNER FOR TESTING:");
    $this->info("Email: agus.setiawan@motorku.id");
    $this->info("Password: password123");
    $this->info("Reason: Has current month revenue data");

    $this->info("\n📝 HOW TO TEST:");
    $this->info("1. Go to: http://127.0.0.1:8000/login");
    $this->info("2. Login with: agus.setiawan@motorku.id / password123");
    $this->info("3. Visit: http://127.0.0.1:8000/owner/dashboard");
    $this->info("4. Should see dynamic data with actual numbers");
  }
}

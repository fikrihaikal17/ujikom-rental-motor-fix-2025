<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class GmailRenterSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $this->command->info('Creating Gmail renter accounts...');

    // Check if Gmail renters already exist
    $existingGmailRenters = User::where('role', 'penyewa')
      ->where('email', 'like', '%@gmail.com')
      ->count();

    if ($existingGmailRenters > 0) {
      $this->command->info("Gmail renters already exist ({$existingGmailRenters} accounts). Skipping creation.");
      return;
    }

    // Password yang sama untuk semua akun
    $password = Hash::make('password123');

    // Data penyewa dengan nama asli Indonesia dan email Gmail
    $gmailRenters = [
      ['nama' => 'Andi Wijaya', 'email' => 'andi.wijaya@gmail.com'],
      ['nama' => 'Budi Santoso', 'email' => 'budi.santoso@gmail.com'],
      ['nama' => 'Citra Kirana', 'email' => 'citra.kirana@gmail.com'],
      ['nama' => 'Dewi Lestari', 'email' => 'dewi.lestari@gmail.com'],
      ['nama' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@gmail.com'],
      ['nama' => 'Fitri Handayani', 'email' => 'fitri.handayani@gmail.com'],
      ['nama' => 'Gita Savitri', 'email' => 'gita.savitri@gmail.com'],
      ['nama' => 'Haris Gunawan', 'email' => 'haris.gunawan@gmail.com'],
      ['nama' => 'Indira Putri', 'email' => 'indira.putri@gmail.com'],
      ['nama' => 'Joko Widodo', 'email' => 'joko.widodo@gmail.com'],
      ['nama' => 'Kartika Sari', 'email' => 'kartika.sari@gmail.com'],
      ['nama' => 'Luna Prasetyo', 'email' => 'luna.prasetyo@gmail.com'],
      ['nama' => 'Maya Sari', 'email' => 'maya.sari@gmail.com'],
      ['nama' => 'Nanda Wijaya', 'email' => 'nanda.wijaya@gmail.com'],
      ['nama' => 'Oscar Ramadhan', 'email' => 'oscar.ramadhan@gmail.com'],
      ['nama' => 'Prilly Wulandari', 'email' => 'prilly.wulandari@gmail.com'],
      ['nama' => 'Quincy Santoso', 'email' => 'quincy.santoso@gmail.com'],
      ['nama' => 'Raisa Andriana', 'email' => 'raisa.andriana@gmail.com'],
      ['nama' => 'Sinta Dewi', 'email' => 'sinta.dewi@gmail.com'],
      ['nama' => 'Tasya Kamila', 'email' => 'tasya.kamila@gmail.com'],
      ['nama' => 'Ussy Sulistiawaty', 'email' => 'ussy.sulistiawaty@gmail.com'],
      ['nama' => 'Vidi Aldiano', 'email' => 'vidi.aldiano@gmail.com'],
      ['nama' => 'Wulan Guritno', 'email' => 'wulan.guritno@gmail.com'],
      ['nama' => 'Yuki Rahman', 'email' => 'yuki.rahman@gmail.com'],
      ['nama' => 'Zaskia Meilani', 'email' => 'zaskia.meilani@gmail.com'],
    ];

    $users = [];
    foreach ($gmailRenters as $index => $renter) {
      $users[] = [
        'nama' => $renter['nama'],
        'email' => $renter['email'],
        'no_tlpn' => '0815' . str_pad(($index + 1), 8, '0', STR_PAD_LEFT),
        'alamat' => "Jl. Gmail Raya No. " . ($index + 1) . ", Jakarta",
        'password' => $password,
        'role' => UserRole::PENYEWA,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // Insert data
    User::insert($users);

    $this->command->info('Successfully created ' . count($gmailRenters) . ' Gmail renter accounts:');
    foreach ($gmailRenters as $renter) {
      $this->command->info('- ' . $renter['nama'] . ' (' . $renter['email'] . ')');
    }
    $this->command->info('All accounts use password: password123');
  }
}

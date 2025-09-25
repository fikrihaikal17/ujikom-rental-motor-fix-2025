<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motor;
use App\Models\User;
use App\Enums\MotorStatus;
use App\Enums\UserRole;

class OwnerMotorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Ambil semua user dengan role pemilik (owner)
    $owners = User::where('role', UserRole::PEMILIK)->get();

    if ($owners->isEmpty()) {
      $this->command->error('No owner users found!');
      return;
    }

    // Array data motor populer di Indonesia
    $motorData = [
      [
        'merk' => 'Honda Vario 150',
        'model' => 'CBS',
        'tipe_cc' => '150',
        'warna' => 'Merah',
        'deskripsi' => 'Motor matic premium dengan teknologi terdepan, cocok untuk perjalanan dalam kota maupun luar kota.'
      ],
      [
        'merk' => 'Honda Vario 125',
        'model' => 'ISS',
        'tipe_cc' => '125',
        'warna' => 'Biru',
        'deskripsi' => 'Motor matic ekonomis dengan fitur idling stop system, hemat bahan bakar.'
      ],
      [
        'merk' => 'Yamaha NMAX 155',
        'model' => 'ABS',
        'tipe_cc' => '150',
        'warna' => 'Hitam',
        'deskripsi' => 'Skutik premium dengan performa tinggi dan fitur keamanan ABS.'
      ],
      [
        'merk' => 'Honda Beat Street',
        'model' => 'FI',
        'tipe_cc' => '125',
        'warna' => 'Putih',
        'deskripsi' => 'Motor matic sporty untuk anak muda dengan desain yang keren.'
      ],
      [
        'merk' => 'Yamaha Aerox 155',
        'model' => 'R-Version',
        'tipe_cc' => '150',
        'warna' => 'Kuning',
        'deskripsi' => 'Skutik sport dengan performa racing dan handling yang responsif.'
      ],
      [
        'merk' => 'Honda PCX 150',
        'model' => 'ABS',
        'tipe_cc' => '150',
        'warna' => 'Silver',
        'deskripsi' => 'Skutik premium dengan kenyamanan berkendara terbaik di kelasnya.'
      ],
      [
        'merk' => 'Yamaha Lexi 125',
        'model' => 'S-Version',
        'tipe_cc' => '125',
        'warna' => 'Hijau',
        'deskripsi' => 'Motor matic stylish dengan teknologi Blue Core yang irit bahan bakar.'
      ],
      [
        'merk' => 'Honda Scoopy',
        'model' => 'Fashion',
        'tipe_cc' => '125',
        'warna' => 'Pink',
        'deskripsi' => 'Motor matic retro dengan desain fashionable untuk wanita modern.'
      ],
      [
        'merk' => 'Suzuki Address',
        'model' => 'FI',
        'tipe_cc' => '125',
        'warna' => 'Abu-abu',
        'deskripsi' => 'Motor matic praktis dengan bagasi luas untuk keperluan sehari-hari.'
      ],
      [
        'merk' => 'Yamaha Mio M3',
        'model' => 'Blue Core',
        'tipe_cc' => '125',
        'warna' => 'Orange',
        'deskripsi' => 'Motor matic entry level dengan teknologi canggih dan harga terjangkau.'
      ]
    ];

    // Admin yang akan melakukan verifikasi
    $admin = User::where('role', UserRole::ADMIN)->first();
    if (!$admin) {
      $this->command->error('No admin user found for verification!');
      return;
    }

    $totalMotors = 0;
    $platCounter = 1000;

    foreach ($owners as $index => $owner) {
      $this->command->info("Creating motors for owner: {$owner->nama}");

      // Buat 5 motor untuk setiap owner
      for ($i = 0; $i < 5; $i++) {
        $platCounter++;

        // Pilih data motor secara berurutan dengan variasi
        $motorIndex = ($index * 5 + $i) % count($motorData);
        $motor = $motorData[$motorIndex];

        // Variasi tahun
        $tahun = rand(2020, 2024);

        // Variasi no plat berdasarkan kota
        $platKota = ['B', 'D', 'L', 'N', 'AG']; // Jakarta, Bandung, Surabaya, Malang, Kediri
        $platPrefix = $platKota[array_rand($platKota)];
        $noPlat = $platPrefix . $platCounter . 'RNT';

        Motor::create([
          'pemilik_id' => $owner->id,
          'merk' => $motor['merk'] . ' ' . $motor['model'] . ' ' . $tahun,
          'model' => $motor['model'],
          'tahun' => $tahun,
          'tipe_cc' => $motor['tipe_cc'],
          'no_plat' => $noPlat,
          'warna' => $motor['warna'],
          'deskripsi' => $motor['deskripsi'],
          'status' => MotorStatus::AVAILABLE,
          'ketersediaan' => 'tersedia',
          'photo' => 'storage/motor.png', // Menggunakan gambar motor.png dari storage
          'dokumen_kepemilikan' => 'documents/stnk-' . $noPlat . '.pdf',
          'admin_notes' => 'Motor telah diverifikasi dan memenuhi standar keamanan rental.',
          'verified_at' => now(),
          'verified_by' => $admin->id,
          'owner_percentage' => rand(65, 80), // Variasi persentase owner 65-80%
          'admin_percentage' => rand(20, 35), // Variasi persentase admin 20-35%
          'revenue_sharing_approved' => true,
          'created_at' => now()->subDays(rand(1, 30)), // Variasi tanggal created
          'updated_at' => now(),
        ]);

        $totalMotors++;
      }
    }

    $this->command->info("Successfully created {$totalMotors} motors for " . $owners->count() . " owners");
    $this->command->info("Each owner now has 5 motors available for rent");
    $this->command->info("All motors use photo: storage/motor.png");
    $this->command->info("Motors are verified and ready for rental");
  }
}

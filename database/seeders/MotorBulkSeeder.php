<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motor;
use App\Models\User;
use App\Enums\MotorStatus;
use App\Enums\UserRole;

class MotorBulkSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Ambil semua pemilik kendaraan yang memiliki email gmail
    $pemilikList = User::where('role', UserRole::PEMILIK)
      ->where('email', 'LIKE', '%@gmail.com')
      ->take(30) // Ambil 30 pemilik pertama
      ->get();

    if ($pemilikList->isEmpty()) {
      $this->command->error('No pemilik users found!');
      return;
    }

    // Array merk motor populer di Indonesia
    $merkMotor = [
      'Honda Vario 150',
      'Honda Vario 125',
      'Honda Beat Street',
      'Honda PCX 150',
      'Honda Scoopy',
      'Honda CB150R',
      'Yamaha NMAX 155',
      'Yamaha Aerox 155',
      'Yamaha Lexi 125',
      'Yamaha Mio M3',
      'Yamaha Jupiter MX King',
      'Suzuki Address',
      'Suzuki Nex II',
      'Suzuki Satria FU',
      'Suzuki GSX-R150',
      'Kawasaki Ninja 250',
      'Kawasaki Versys-X 250',
      'TVS Apache RTR 200',
      'Benelli TNT 135',
      'KTM Duke 200'
    ];

    // Array model motor
    $modelMotor = [
      'CBS',
      'ISS',
      'ABS',
      'Sporty',
      'Deluxe',
      'Standard',
      'Premium',
      'SE',
      'FI',
      'Carb'
    ];

    // Array warna motor
    $warnaMotor = [
      'Merah',
      'Biru',
      'Hitam',
      'Putih',
      'Silver',
      'Kuning',
      'Hijau',
      'Orange',
      'Ungu',
      'Abu-abu'
    ];

    $motors = [];
    $platCounter = 1000;

    // Buat 2-3 motor untuk setiap pemilik
    foreach ($pemilikList as $pemilik) {
      $jumlahMotor = rand(1, 3); // Random 1-3 motor per pemilik

      for ($i = 0; $i < $jumlahMotor; $i++) {
        $merk = $merkMotor[array_rand($merkMotor)];
        $tipeCC = ['100', '125', '150'][array_rand(['100', '125', '150'])];
        $platCounter++;

        $motors[] = [
          'pemilik_id' => $pemilik->id,
          'merk' => $merk,
          'nama_motor' => $merk . ' ' . $modelMotor[array_rand($modelMotor)],
          'model' => $modelMotor[array_rand($modelMotor)],
          'tahun' => rand(2018, 2024),
          'tipe_cc' => $tipeCC,
          'no_plat' => 'B' . $platCounter . 'ABC',
          'warna' => $warnaMotor[array_rand($warnaMotor)],
          'deskripsi' => 'Motor dalam kondisi terawat, siap pakai untuk rental harian maupun mingguan.',
          'status' => MotorStatus::AVAILABLE,
          'ketersediaan' => 'tersedia',
          'photo' => 'motors/sample-' . strtolower(str_replace(' ', '-', $merk)) . '.jpg',
          'dokumen_kepemilikan' => 'documents/stnk-' . $platCounter . '.pdf',
          'admin_notes' => 'Motor telah diverifikasi dan siap untuk disewakan',
          'verified_at' => now(),
          'verified_by' => User::where('role', UserRole::ADMIN)->first()->id,
          'owner_percentage' => rand(60, 80),
          'admin_percentage' => rand(20, 40),
          'revenue_sharing_approved' => true,
          'created_at' => now(),
          'updated_at' => now(),
        ];
      }
    }

    // Insert data dalam batch
    $chunks = array_chunk($motors, 25);

    foreach ($chunks as $chunk) {
      Motor::insert($chunk);
    }

    $totalMotors = count($motors);
    $this->command->info("Successfully created $totalMotors motors for " . $pemilikList->count() . " owners");
    $this->command->info('All motors are verified and ready for rental');
  }
}

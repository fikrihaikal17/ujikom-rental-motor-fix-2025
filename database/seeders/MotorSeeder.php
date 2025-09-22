<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motor;
use App\Models\User;
use App\Enums\MotorStatus;

class MotorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Get the owner user
    $owner = User::where('email', 'owner@ridenow.com')->first();

    if ($owner) {
      // Create sample motors for the owner
      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Honda Vario 150',
        'tipe_cc' => '150',
        'no_plat' => 'B1234ABC',
        'status' => MotorStatus::AVAILABLE,
        'photo' => 'motors/vario-150.jpg',
        'dokumen_kepemilikan' => 'documents/vario-stnk.pdf',
      ]);

      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Yamaha NMAX 155',
        'tipe_cc' => '150',
        'no_plat' => 'B5678DEF',
        'status' => MotorStatus::AVAILABLE,
        'photo' => 'motors/nmax-155.jpg',
        'dokumen_kepemilikan' => 'documents/nmax-stnk.pdf',
      ]);

      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Honda Beat Street',
        'tipe_cc' => '125',
        'no_plat' => 'B9012GHI',
        'status' => MotorStatus::AVAILABLE,
        'photo' => 'motors/beat-street.jpg',
        'dokumen_kepemilikan' => 'documents/beat-stnk.pdf',
      ]);
    }
  }
}

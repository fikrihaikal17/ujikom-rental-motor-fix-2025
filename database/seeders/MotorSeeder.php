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
    $owner = User::where('email', 'owner@gmail.com')->first();

    if ($owner) {
      // Get admin user for verification
      $admin = User::where('email', 'admin@gmail.com')->first();

      // Create sample motors for the owner
      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Honda',
        'model' => 'Vario 150',
        'tahun' => 2023,
        'tipe_cc' => '150',
        'no_plat' => 'B1234ABC',
        'warna' => 'Merah',
        'deskripsi' => 'Motor matic Honda Vario 150 dalam kondisi prima',
        'status' => MotorStatus::VERIFIED,
        'ketersediaan' => 'tersedia',
        'photo' => 'motors/vario-150.jpg',
        'dokumen_kepemilikan' => 'documents/vario-stnk.pdf',
        'verified_at' => now(),
        'verified_by' => $admin?->id,
        'owner_percentage' => 70.00,
        'admin_percentage' => 30.00,
        'revenue_sharing_approved' => true,
      ]);

      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Yamaha',
        'model' => 'NMAX 155',
        'tahun' => 2022,
        'tipe_cc' => '150',
        'no_plat' => 'B5678DEF',
        'warna' => 'Biru',
        'deskripsi' => 'Yamaha NMAX 155 siap pakai untuk perjalanan jauh',
        'status' => MotorStatus::VERIFIED,
        'ketersediaan' => 'tersedia',
        'photo' => 'motors/nmax-155.jpg',
        'dokumen_kepemilikan' => 'documents/nmax-stnk.pdf',
        'verified_at' => now(),
        'verified_by' => $admin?->id,
        'owner_percentage' => 75.00,
        'admin_percentage' => 25.00,
        'revenue_sharing_approved' => true,
      ]);

      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Honda',
        'model' => 'Beat Street',
        'tahun' => 2021,
        'tipe_cc' => '125',
        'no_plat' => 'B9012GHI',
        'warna' => 'Hitam',
        'deskripsi' => 'Honda Beat Street cocok untuk dalam kota',
        'status' => MotorStatus::PENDING,
        'ketersediaan' => 'tersedia',
        'photo' => 'motors/beat-street.jpg',
        'dokumen_kepemilikan' => 'documents/beat-stnk.pdf',
      ]);

      // Create a rejected motor example
      Motor::create([
        'pemilik_id' => $owner->id,
        'merk' => 'Suzuki',
        'model' => 'Satria FU',
        'tahun' => 2020,
        'tipe_cc' => '150',
        'no_plat' => 'B3456JKL',
        'warna' => 'Kuning',
        'deskripsi' => 'Suzuki Satria FU modifikasi ringan',
        'status' => MotorStatus::PENDING,
        'ketersediaan' => 'tersedia',
        'photo' => 'motors/satria-fu.jpg',
        'dokumen_kepemilikan' => 'documents/satria-stnk.pdf',
        'admin_notes' => 'Dokumen kepemilikan tidak lengkap. Harap upload STNK yang masih berlaku.',
      ]);
    }
  }
}

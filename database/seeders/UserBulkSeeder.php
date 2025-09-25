<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserBulkSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Password yang sama untuk semua akun
    $password = Hash::make('password123');

    // Array nama-nama Indonesia untuk Admin
    $namaAdmin = [
      'Budi Santoso',
      'Siti Nurhaliza',
      'Ahmad Fauzi',
      'Dewi Lestari',
      'Rizki Pratama',
      'Maya Sari',
      'Andi Wijaya',
      'Fitri Handayani',
      'Doni Kurniawan',
      'Lina Marlina'
    ];

    // Array email admin dengan domain Indonesia
    $emailAdmin = [
      'budi.santoso@admin.co.id',
      'siti.nurhaliza@admin.co.id',
      'ahmad.fauzi@admin.co.id',
      'dewi.lestari@admin.co.id',
      'rizki.pratama@admin.co.id',
      'maya.sari@admin.co.id',
      'andi.wijaya@admin.co.id',
      'fitri.handayani@admin.co.id',
      'doni.kurniawan@admin.co.id',
      'lina.marlina@admin.co.id'
    ];

    // Array nama-nama Indonesia untuk Pemilik
    $namaPemilik = [
      'Agus Setiawan',
      'Ratna Sari',
      'Bambang Hermawan',
      'Sri Wahyuni',
      'Dedi Supriadi',
      'Indira Putri',
      'Hendra Gunawan',
      'Nisa Aulia',
      'Yanto Suryadi',
      'Eka Prasasti',
      'Joko Santoso',
      'Mega Indrawati',
      'Surya Dharma',
      'Rina Kartika',
      'Wahyu Hidayat',
      'Diah Pertiwi',
      'Ari Wibowo',
      'Sari Dewi',
      'Fajar Nugroho',
      'Tuti Indrawati',
      'Rudi Hartono',
      'Nina Marlina',
      'Eko Prasetyo',
      'Wulan Sari',
      'Dimas Pratama',
      'Siska Amelia',
      'Teguh Santoso',
      'Lia Agustina',
      'Bayu Firmansyah',
      'Vina Safitri',
      'Irwan Setiadi',
      'Dewi Anggraini',
      'Arif Rahman',
      'Putri Lestari',
      'Dani Kurnia',
      'Novi Rahayu',
      'Hadi Purnomo',
      'Yuni Astuti',
      'Rian Saputra',
      'Mila Yunita'
    ];

    // Array email pemilik dengan domain Indonesia
    $emailPemilik = [
      'agus.setiawan@motorku.id',
      'ratna.sari@motorku.id',
      'bambang.hermawan@motorku.id',
      'sri.wahyuni@motorku.id',
      'dedi.supriadi@motorku.id',
      'indira.putri@motorku.id',
      'hendra.gunawan@motorku.id',
      'nisa.aulia@motorku.id',
      'yanto.suryadi@motorku.id',
      'eka.prasasti@motorku.id',
      'joko.santoso@motorku.id',
      'mega.indrawati@motorku.id',
      'surya.dharma@motorku.id',
      'rina.kartika@motorku.id',
      'wahyu.hidayat@motorku.id',
      'diah.pertiwi@motorku.id',
      'ari.wibowo@motorku.id',
      'sari.dewi@motorku.id',
      'fajar.nugroho@motorku.id',
      'tuti.indrawati@motorku.id',
      'rudi.hartono@motorku.id',
      'nina.marlina@motorku.id',
      'eko.prasetyo@motorku.id',
      'wulan.sari@motorku.id',
      'dimas.pratama@motorku.id',
      'siska.amelia@motorku.id',
      'teguh.santoso@motorku.id',
      'lia.agustina@motorku.id',
      'bayu.firmansyah@motorku.id',
      'vina.safitri@motorku.id',
      'irwan.setiadi@motorku.id',
      'dewi.anggraini@motorku.id',
      'arif.rahman@motorku.id',
      'putri.lestari@motorku.id',
      'dani.kurnia@motorku.id',
      'novi.rahayu@motorku.id',
      'hadi.purnomo@motorku.id',
      'yuni.astuti@motorku.id',
      'rian.saputra@motorku.id',
      'mila.yunita@motorku.id'
    ];

    // Array nama-nama Indonesia untuk Penyewa
    $namaPenyewa = [
      'Adi Nugroho',
      'Sinta Dewi',
      'Bima Pratama',
      'Citra Kirana',
      'Dicky Chandra',
      'Elsa Permata',
      'Fandi Akbar',
      'Gita Savitri',
      'Haris Gunawan',
      'Ika Putri',
      'Jefri Saputra',
      'Kirana Larasati',
      'Lucky Hakim',
      'Maudy Sari',
      'Nanda Arsyinta',
      'Oscar Ramadhan',
      'Prilly Wulandari',
      'Quincy Santoso',
      'Raisa Andriana',
      'Stefan Widodo',
      'Tasya Kamila',
      'Ussy Sulistiawaty',
      'Vidi Aldiano',
      'Wulan Guritno',
      'Yuki Rahman',
      'Zaskia Meilani',
      'Angga Wijaya',
      'Bella Shofie',
      'Cut Tari',
      'Donita Sari',
      'Febby Rastanty',
      'Gading Marten',
      'Hamish Saputra',
      'Ivan Gunawan',
      'Jessica Mila',
      'Kevin Aprilio',
      'Luna Maya',
      'Marsha Timothy',
      'Nikita Wulan',
      'Olga Suryadi',
      'Pevita Pearce',
      'Raline Shah',
      'Shandy Aulia',
      'Titi Kamal',
      'Ussy Sulistiawaty',
      'Vanesha Prescilla',
      'Widi Mulia',
      'Yeslin Wang',
      'Zara Leola',
      'Abimana Aryasatya'
    ];

    // Array email penyewa dengan domain Indonesia
    $emailPenyewa = [
      'adi.nugroho@rentalku.co.id',
      'sinta.dewi@rentalku.co.id',
      'bima.pratama@rentalku.co.id',
      'citra.kirana@rentalku.co.id',
      'dicky.chandra@rentalku.co.id',
      'elsa.permata@rentalku.co.id',
      'fandi.akbar@rentalku.co.id',
      'gita.savitri@rentalku.co.id',
      'haris.gunawan@rentalku.co.id',
      'ika.putri@rentalku.co.id',
      'jefri.saputra@rentalku.co.id',
      'kirana.larasati@rentalku.co.id',
      'lucky.hakim@rentalku.co.id',
      'maudy.sari@rentalku.co.id',
      'nanda.arsyinta@rentalku.co.id',
      'oscar.ramadhan@rentalku.co.id',
      'prilly.wulandari@rentalku.co.id',
      'quincy.santoso@rentalku.co.id',
      'raisa.andriana@rentalku.co.id',
      'stefan.widodo@rentalku.co.id',
      'tasya.kamila@rentalku.co.id',
      'ussy.sulistiawaty@rentalku.co.id',
      'vidi.aldiano@rentalku.co.id',
      'wulan.guritno@rentalku.co.id',
      'yuki.rahman@rentalku.co.id',
      'zaskia.meilani@rentalku.co.id',
      'angga.wijaya@rentalku.co.id',
      'bella.shofie@rentalku.co.id',
      'cut.tari@rentalku.co.id',
      'donita.sari@rentalku.co.id',
      'febby.rastanty@rentalku.co.id',
      'gading.marten@rentalku.co.id',
      'hamish.saputra@rentalku.co.id',
      'ivan.gunawan@rentalku.co.id',
      'jessica.mila@rentalku.co.id',
      'kevin.aprilio@rentalku.co.id',
      'luna.maya@rentalku.co.id',
      'marsha.timothy@rentalku.co.id',
      'nikita.wulan@rentalku.co.id',
      'olga.suryadi@rentalku.co.id',
      'pevita.pearce@rentalku.co.id',
      'raline.shah@rentalku.co.id',
      'shandy.aulia@rentalku.co.id',
      'titi.kamal@rentalku.co.id',
      'ussy.sulistiawaty2@rentalku.co.id',
      'vanesha.prescilla@rentalku.co.id',
      'widi.mulia@rentalku.co.id',
      'yeslin.wang@rentalku.co.id',
      'zara.leola@rentalku.co.id',
      'abimana.aryasatya@rentalku.co.id'
    ];

    // Array untuk menyimpan data users
    $users = [];

    // 1. Buat 10 Admin
    for ($i = 0; $i < 10; $i++) {
      $users[] = [
        'nama' => $namaAdmin[$i],
        'email' => $emailAdmin[$i],
        'no_tlpn' => '0812' . str_pad(($i + 1), 8, '0', STR_PAD_LEFT),
        'alamat' => "Jl. Sudirman No. " . ($i + 1) . ", Jakarta Pusat",
        'password' => $password,
        'role' => UserRole::ADMIN,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // 2. Buat 40 Pemilik Kendaraan
    for ($i = 0; $i < 40; $i++) {
      $users[] = [
        'nama' => $namaPemilik[$i],
        'email' => $emailPemilik[$i],
        'no_tlpn' => '0813' . str_pad(($i + 1), 8, '0', STR_PAD_LEFT),
        'alamat' => "Jl. Dago No. " . ($i + 1) . ", Bandung",
        'password' => $password,
        'role' => UserRole::PEMILIK,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // 3. Buat 50 Penyewa Kendaraan
    for ($i = 0; $i < 50; $i++) {
      $users[] = [
        'nama' => $namaPenyewa[$i],
        'email' => $emailPenyewa[$i],
        'no_tlpn' => '0814' . str_pad(($i + 1), 8, '0', STR_PAD_LEFT),
        'alamat' => "Jl. Tunjungan No. " . ($i + 1) . ", Surabaya",
        'password' => $password,
        'role' => UserRole::PENYEWA,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // Insert data dalam batch untuk performa yang lebih baik
    $chunks = array_chunk($users, 50);

    foreach ($chunks as $chunk) {
      User::insert($chunk);
    }

    $this->command->info('Successfully created 100 users:');
    $this->command->info('- 10 Admin accounts');
    $this->command->info('- 40 Pemilik accounts');
    $this->command->info('- 50 Penyewa accounts');
    $this->command->info('All accounts use password: password123');
  }
}

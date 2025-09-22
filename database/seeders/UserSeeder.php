<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'nama' => 'Admin RideNow',
            'email' => 'admin@ridenow.com',
            'no_tlpn' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        // Create Owner User
        User::create([
            'nama' => 'Budi Pemilik Motor',
            'email' => 'owner@ridenow.com',
            'no_tlpn' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => UserRole::PEMILIK,
            'email_verified_at' => now(),
        ]);

        // Create Renter User
        User::create([
            'nama' => 'Sari Penyewa',
            'email' => 'renter@ridenow.com',
            'no_tlpn' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => UserRole::PENYEWA,
            'email_verified_at' => now(),
        ]);
    }
}

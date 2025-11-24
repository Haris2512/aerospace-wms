<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun ADMIN (Untuk Kamu)
        User::create([
            'name' => 'Admin Gudang',
            'email' => 'admin@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // 2. Akun WAREHOUSE MANAGER (Kepala Insinyur)
        User::create([
            'name' => 'Chief Engineer (Manager)',
            'email' => 'manager@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'status' => 'approved',
        ]);

        // 3. Akun STAFF GUDANG (Teknisi)
        User::create([
            'name' => 'Staff Teknisi',
            'email' => 'staff@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'approved',
        ]);

        // 4. Akun SUPPLIER 1 (Boeing)
        User::create([
            'name' => 'PT. Boeing Aerospace',
            'email' => 'boeing@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'status' => 'approved', // Harus approved biar muncul di dropdown
        ]);

        // 5. Akun SUPPLIER 2 (Airbus)
        User::create([
            'name' => 'Airbus Components Ltd.',
            'email' => 'airbus@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'status' => 'approved',
        ]);
    }
}
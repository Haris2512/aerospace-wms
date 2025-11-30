<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// PENTING: Import ProductAndTransactionSeeder yang baru kita buat
use Database\Seeders\ProductAndTransactionSeeder; 

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        // --- 1. MEMBUAT AKUN UTAMA (USER SEEDING) ---
        User::create([
            'name' => 'Admin Gudang',
            'email' => 'admin@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
        ]);

        User::create([
            'name' => 'Chief Engineer (Manager)',
            'email' => 'manager@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'status' => 'approved',
        ]);

        User::create([
            'name' => 'Staff Teknisi',
            'email' => 'staff@gudang.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'approved',
        ]);

        // Akun SUPPLIER (Wajib ada untuk Restock/Transaksi)
        User::create([
            'name' => 'PT. Boeing Aerospace',
            'email' => 'boeing@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'status' => 'approved', 
        ]);

        User::create([
            'name' => 'Airbus Components Ltd.',
            'email' => 'airbus@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'status' => 'approved',
        ]);


        // --- 2. MEMANGGIL SEEDER PRODUK & TRANSAKSI ---
        $this->call([
            ProductAndTransactionSeeder::class, 
        ]);
    }
}
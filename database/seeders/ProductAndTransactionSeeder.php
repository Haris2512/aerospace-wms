<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\RestockOrder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductAndTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kita menjalankan semua ini dalam satu transaksi DB yang aman
        DB::transaction(function () {
            
            // --- 1. BUAT KATEGORI & TENTUKAN PATH GAMBAR DUMMY ---
            $catEngine = Category::create(['name' => 'Engine Parts', 'description' => 'Components for propulsion systems.', 'image_path' => 'category_images/engine.png']);
            $catAvionics = Category::create(['name' => 'Avionics & Nav', 'description' => 'Electronic navigation and control units.', 'image_path' => 'category_images/avionics.png']);
            $catStructure = Category::create(['name' => 'Structural & Frame', 'description' => 'Metal components for the airframe.', 'image_path' => 'category_images/structure.png']);

            // --- 2. AMBIL USER UTAMA (Asumsi sudah dibuat di DatabaseSeeder) ---
            $manager = User::where('role', 'manager')->first();
            $staff = User::where('role', 'staff')->first();
            $supplierBoeing = User::where('name', 'PT. Boeing Aerospace')->first();

            // --- 3. BUAT PRODUK UTAMA (Menguji 3 Status Stok) ---
            
            $prodTurbine = Product::create([
                'sku' => 'TURB-V90', 'name' => 'Titanium Turbine Blade', 'category_id' => $catEngine->id,
                'description' => 'Grade 5 Titanium Blade for high thrust performance.', 'purchase_price' => 1500000.00, 'sale_price' => 2500000.00,
                'stock_current' => 2, 'stock_minimum' => 10, 'unit' => 'pcs', 'storage_location' => 'RACK-E-01',
                'image_path' => 'product_images/turbine.png' 
            ]);

            $prodChip = Product::create([
                'sku' => 'GPS-NAV-C', 'name' => 'Navigation Chipset', 'category_id' => $catAvionics->id,
                'description' => 'High precision GPS unit.', 'purchase_price' => 50000.00, 'sale_price' => 120000.00,
                'stock_current' => 80, 'stock_minimum' => 20, 'unit' => 'unit', 'storage_location' => 'CAB-A-05',
                'image_path' => 'product_images/chip.png' 
            ]);

            $prodRivet = Product::create([
                'sku' => 'RIVET-S01', 'name' => 'High Strength Rivet Pack', 'category_id' => $catStructure->id,
                'description' => 'Pack of 1000 rivets.', 'purchase_price' => 1000.00, 'sale_price' => 2000.00,
                'stock_current' => 0, 'stock_minimum' => 5, 'unit' => 'pack', 'storage_location' => 'BIN-F-12',
                'image_path' => 'product_images/Rivet.png' 
            ]);

            // --- 4. BUAT RESTOCK ORDER (PO) ---
            $po1 = RestockOrder::create([
                'po_number' => 'PO-' . Str::random(10), 'supplier_id' => $supplierBoeing->id,
                'order_date' => now()->subDays(5), 'expected_delivery_date' => now()->addDays(2),
                'status' => 'confirmed', 'created_by_user_id' => $manager->id, 'notes' => 'Urgent priority shipment.'
            ]);
            // Attach items to PO-1
            $po1->products()->attach([
                $prodTurbine->id => ['quantity' => 20],
                $prodChip->id => ['quantity' => 50],
            ]);


            // --- 5. BUAT TRANSAKSI (History) ---
            
            // TRX-1: Transaksi Masuk (APPROVED - Stock bertambah 10)
            $trx1 = Transaction::create([
                'transaction_number' => 'TRX-' . Str::random(10), 'type' => 'incoming',
                'transaction_date' => now()->subDays(3), 'status' => 'approved', 'supplier_id' => $supplierBoeing->id,
                'created_by_user_id' => $staff->id, 'approved_by_user_id' => $manager->id, 'notes' => 'Initial stock deposit.'
            ]);
            // Update stock + attach pivot
            $prodChip->increment('stock_current', 10);
            $trx1->products()->attach([$prodChip->id => ['quantity' => 10]]);


            // TRX-2: Transaksi Keluar (PENDING - Perlu Approval Manager)
            $trx2 = Transaction::create([
                'transaction_number' => 'TRX-' . Str::random(10), 'type' => 'outgoing',
                'transaction_date' => now()->subDays(1), 'status' => 'pending', 'customer_name' => 'Hangar B Maintenance',
                'created_by_user_id' => $staff->id, 'notes' => 'Parts request for daily maintenance.'
            ]);
            // Attach items to PENDING transaction
            $trx2->products()->attach([
                $prodTurbine->id => ['quantity' => 1] 
            ]);
        });
    }
}
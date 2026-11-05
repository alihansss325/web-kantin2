<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default school
        $school = DB::table('schools')->insert([
            'name' => 'SMA Negeri 1 Jakarta',
            'code' => 'SMAN1JKT' . time(),
            'address' => 'Jl. Pendidikan No. 123, Jakarta Pusat',
            'phone' => '021-1234567',
            'email' => 'info@sman1jakarta.sch.id',
            'principal_name' => 'Dr. Ahmad Wijaya, M.Pd',
            'level' => 'sma',
            'student_count' => 1200,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $schoolId = DB::getPdo()->lastInsertId();

        // Create admin user
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@kantin.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'school_id' => $schoolId,
            'saldo' => 0,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample categories
        $categories = [
            [
                'name' => 'Makanan Berat',
                'slug' => 'makanan-berat-' . time(),
                'description' => 'Makanan utama seperti nasi, lauk pauk',
                'icon' => 'utensils',
                'color' => '#ef4444',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan-' . time(),
                'description' => 'Makanan ringan seperti snack, kue',
                'icon' => 'cookie',
                'color' => '#f59e0b',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman-' . time(),
                'description' => 'Aneka minuman dingin dan panas',
                'icon' => 'coffee',
                'color' => '#3b82f6',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jajanan',
                'slug' => 'jajanan-' . time(),
                'description' => 'Aneka jajanan dan camilan',
                'icon' => 'candy',
                'color' => '#8b5cf6',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }

        // Get category IDs
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // Create sample products
        $products = [
            [
                'name' => 'Nasi Goreng Ayam',
                'slug' => 'nasi-goreng-ayam-' . time(),
                'category_id' => $categoryIds[0] ?? 1,
                'description' => 'Nasi goreng dengan ayam goreng dan sambal',
                'price' => 15000,
                'cost_price' => 10000,
                'stock' => 50,
                'min_stock' => 10,
                'unit' => 'porsi',
                'status' => 'available',
                'is_featured' => true,
                'is_taxable' => true,
                'tax_percentage' => 10,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mie Ayam',
                'slug' => 'mie-ayam-' . time(),
                'category_id' => $categoryIds[0] ?? 1,
                'description' => 'Mie ayam dengan sayuran',
                'price' => 12000,
                'cost_price' => 8000,
                'stock' => 30,
                'min_stock' => 5,
                'unit' => 'porsi',
                'status' => 'available',
                'is_featured' => false,
                'is_taxable' => true,
                'tax_percentage' => 10,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Teh Manis',
                'slug' => 'es-teh-manis-' . time(),
                'category_id' => $categoryIds[2] ?? 3,
                'description' => 'Es teh manis dingin',
                'price' => 5000,
                'cost_price' => 2000,
                'stock' => 100,
                'min_stock' => 20,
                'unit' => 'gelas',
                'status' => 'available',
                'is_featured' => false,
                'is_taxable' => false,
                'tax_percentage' => 0,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Donat',
                'slug' => 'donat-' . time(),
                'category_id' => $categoryIds[3] ?? 4,
                'description' => 'Donat manis dengan taburan gula',
                'price' => 8000,
                'cost_price' => 5000,
                'stock' => 25,
                'min_stock' => 5,
                'unit' => 'pcs',
                'status' => 'available',
                'is_featured' => true,
                'is_taxable' => true,
                'tax_percentage' => 10,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }

        // Create default settings
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Kantin Digital',
                'description' => 'Nama aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_currency',
                'value' => 'IDR',
                'description' => 'Mata uang yang digunakan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tax_percentage',
                'value' => '10',
                'description' => 'Persentase pajak default',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'min_topup',
                'value' => '10000',
                'description' => 'Minimal topup saldo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}

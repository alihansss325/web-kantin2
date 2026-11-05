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
        // Create admin user (penjual kantin)
        DB::table('users')->insert([
            'name' => 'Admin Kantin',
            'email' => 'admin@kantin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create categories
        $categories = [
            [
                'name' => 'Makanan Berat',
                'slug' => 'makanan-berat',
                'description' => 'Makanan utama seperti nasi, mie, dll',
                'icon' => 'hamburger',
                'color' => 'amber',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Aneka minuman dingin dan panas',
                'icon' => 'coffee',
                'color' => 'blue',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snack',
                'slug' => 'snack',
                'description' => 'Makanan ringan dan jajanan',
                'icon' => 'cookie',
                'color' => 'orange',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }

        // Create products
        $products = [
            // Makanan Berat
            [
                'name' => 'Nasi Goreng',
                'slug' => 'nasi-goreng',
                'category_id' => 1,
                'description' => 'Nasi goreng dengan telur dan ayam suwir',
                'price' => 13000,
                'cost_price' => 8000,
                'stock' => 50,
                'min_stock' => 10,
                'unit' => 'porsi',
                'image' => 'products/nasi-goreng.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nasi Mentai',
                'slug' => 'nasi-mentai',
                'category_id' => 1,
                'description' => 'Nasi dengan saus mentai dan salmon',
                'price' => 13000,
                'cost_price' => 8500,
                'stock' => 40,
                'min_stock' => 10,
                'unit' => 'porsi',
                'image' => 'products/nasi-mentai.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nasi Cokot',
                'slug' => 'nasi-cokot',
                'category_id' => 1,
                'description' => 'Nasi dengan lauk ayam suwir pedas khas',
                'price' => 6000,
                'cost_price' => 3500,
                'stock' => 60,
                'min_stock' => 15,
                'unit' => 'porsi',
                'image' => 'products/nasi-cokot.jpg',
                'status' => 'available',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Minuman
            [
                'name' => 'Kopi SIP',
                'slug' => 'kopi-sip',
                'category_id' => 2,
                'description' => 'Minuman kopi populer dari espresso biji kopi premium, dipadukan susu creamy dan gula aren',
                'price' => 8000,
                'cost_price' => 4000,
                'stock' => 100,
                'min_stock' => 20,
                'unit' => 'cup',
                'image' => 'products/kopi-sip.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Red Velvet',
                'slug' => 'red-velvet',
                'category_id' => 2,
                'description' => 'Minuman red velvet dengan rasa manis lembut dan creamy',
                'price' => 12000,
                'cost_price' => 6000,
                'stock' => 80,
                'min_stock' => 15,
                'unit' => 'cup',
                'image' => 'products/red-velvet.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Snack
            [
                'name' => 'Bakpao',
                'slug' => 'bakpao',
                'category_id' => 3,
                'description' => 'Bakpao lembut dengan isian daging ayam',
                'price' => 6000,
                'cost_price' => 3000,
                'stock' => 70,
                'min_stock' => 15,
                'unit' => 'pcs',
                'image' => 'products/bakpau.jpg',
                'status' => 'available',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jasuke',
                'slug' => 'jasuke',
                'category_id' => 3,
                'description' => 'Jagung manis hangat yang dipadukan susu dan keju',
                'price' => 7000,
                'cost_price' => 3500,
                'stock' => 50,
                'min_stock' => 10,
                'unit' => 'cup',
                'image' => 'products/jasuke.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brownies',
                'slug' => 'brownies',
                'category_id' => 3,
                'description' => 'Brownies coklat lembut dengan topping keju',
                'price' => 12000,
                'cost_price' => 6000,
                'stock' => 40,
                'min_stock' => 10,
                'unit' => 'slice',
                'image' => 'products/brownies.jpg',
                'status' => 'available',
                'is_featured' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tahu Walik',
                'slug' => 'tahu-walik',
                'category_id' => 3,
                'description' => 'Tahu goreng krispi dengan bumbu khas',
                'price' => 10000,
                'cost_price' => 5000,
                'stock' => 60,
                'min_stock' => 15,
                'unit' => 'porsi',
                'image' => 'products/tahu-walik.jpg',
                'status' => 'available',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batagor',
                'slug' => 'batagor',
                'category_id' => 3,
                'description' => 'Batagor goreng dengan bumbu kacang',
                'price' => 10000,
                'cost_price' => 5000,
                'stock' => 55,
                'min_stock' => 15,
                'unit' => 'porsi',
                'image' => 'products/batagor.jpg',
                'status' => 'available',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siomay',
                'slug' => 'siomay',
                'category_id' => 3,
                'description' => 'Siomay ikan dengan bumbu kacang',
                'price' => 10000,
                'cost_price' => 5000,
                'stock' => 50,
                'min_stock' => 15,
                'unit' => 'porsi',
                'image' => 'products/siomay.jpg',
                'status' => 'available',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tempura',
                'slug' => 'tempura',
                'category_id' => 3,
                'description' => 'Tempura goreng renyah dengan saus khas',
                'price' => 10000,
                'cost_price' => 5000,
                'stock' => 45,
                'min_stock' => 10,
                'unit' => 'porsi',
                'image' => 'products/tempura.jpg',
                'status' => 'available',
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}

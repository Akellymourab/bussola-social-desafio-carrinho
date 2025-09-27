<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Fone Bluetooth', 'price' => 100.00],
            ['name' => 'Mouse Gamer', 'price' => 150.00],
            ['name' => 'Teclado Mecânico', 'price' => 250.00],
            ['name' => 'Monitor 24"', 'price' => 750.00],
            ['name' => 'Webcam HD', 'price' => 120.00],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}

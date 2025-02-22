<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'category' => 'Electronics',
                'details' => 'This is a sample product.',
                'price' => 100,
                'image' => 'product1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'category' => 'Clothing',
                'details' => 'This is another sample product.',
                'price' => 50,
                'image' => 'product2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
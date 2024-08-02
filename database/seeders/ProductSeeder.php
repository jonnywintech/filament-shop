<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([

            [
                'category_id' => 1,
                'brand_id' => 2,
                'name' => 'Iphone 15',
                'slug' => 'iphone-15',
                'images' => json_encode(['products/iphone-15-1.jpg', 'products/iphone-15-2.jpg', 'products/iphone-15-3.jpg']),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'price' => 999.99,
                'is_active' => true,
                'is_featured' => false,
                'in_stock' => true,
                'on_sale' => false,
                'created_at'=> now(),
            ],
            [
                'category_id' => 1,
                'brand_id' => 4,
                'name' => 'Samsung Galaxy S21',
                'slug' => 'samsung-galaxy-s21',
                'images' => json_encode(['products/samsung-galaxy-s21-1.jpg', 'products/samsung-galaxy-s21-2.jpg', 'products/samsung-galaxy-s21-3.jpg']),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'price' => 1299.99,
                'is_active' => true,
                'is_featured' => true,
                'in_stock' => true,
                'on_sale' => true,
                'created_at'=> now(),

            ],
            [
                'category_id' => 1,
                'brand_id' => 2,
                'name' => 'Iphone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'images' => json_encode(['products/iphone-15-1.jpg', 'products/iphone-15-2.jpg', 'products/iphone-15-3.jpg']),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'price' => 1299.99,
                'is_active' => true,
                'is_featured' => false,
                'in_stock' => true,
                'on_sale' => false,
                'created_at'=> now(),

            ],

        ]);
    }
}

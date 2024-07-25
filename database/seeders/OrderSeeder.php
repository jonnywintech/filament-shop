<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('orders')->insert([
        ['user_id' => 1,
        'grand_total' => 1000,
        'payment_method' => 'PayPal',
        'payment_status' => 'Completed',
        'status' => 'shipped',
        'currency' => 'USD',
        'shipping_method' => 'ups',
        'notes' => 'some random text'
        ]
       ]);

       DB::table('order_items')->insert([
        ['order_id' => 1,
        'product_id' => 1,
        'quantity' => 1,
        'unit_amount' => 1000,
        'total_amount' => 1000]
       ]);
    }
}

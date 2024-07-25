<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Phone',
                'slug' => 'phone',
                'image' => 'https://t4.ftcdn.net/jpg/05/36/24/13/360_F_536241340_GsrsNhcWC0hyTVaJLilNafyDw6fl0cC8.jpg',
            ],
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'image' => 'https://t3.ftcdn.net/jpg/02/49/82/50/360_F_249825007_f5dzNTBuUZoV5nERUWTlPDoU3cvLIBzn.jpg',
            ],
            [
                'name' => 'Tablet',
                'slug' => 'tablet',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/006/900/746/small/tablet-screen-icon-tablet-mockup-free-vector.jpg',
            ],

        ]);
    }
}

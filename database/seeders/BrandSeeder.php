<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'image' => 'https://www.freevector.com/uploads/vector/preview/3324/FreeVector-Sony-Vector-Logo.jpg'
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'image' => 'https://1000logos.net/wp-content/uploads/2016/10/Apple-Logo.jpg'

            ],
            [
                'name' => 'Nintendo',
                'slug' => 'nintendo',
                'image' => 'https://cdn.freebiesupply.com/logos/large/2x/nintendo-2-logo-png-transparent.png'
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'image' => 'https://images.samsung.com/is/image/samsung/assets/global/about-us/brand/logo/256_144_1.png?$512_N_PNG$'
            ]
        ]);
    }
}

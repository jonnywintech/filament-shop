<?php

namespace Database\Seeders;

use App\Models\BlogTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       BlogTag::factory(10)->create();
    }
}

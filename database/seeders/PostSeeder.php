<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\BlogTag;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(10)->create()->each(function ($post) {
            // Attach 2-4 tags to each post
            $tags = BlogTag::factory(rand(2, 4))->create();
            $post->tags()->attach($tags);

            // Attach 1-2 categories to each post
            $categories = BlogCategory::factory(rand(1, 2))->create();
            $post->categories()->attach($categories);
        });
    }
}

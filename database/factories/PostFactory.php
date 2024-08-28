<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->word(1);
        $user_id = User::inRandomOrder()->first()->id;
        return [
            'user_id' => $user_id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->text,
            'published' => true,
            'cover_image' => 'https://picsum.photos/450/300',
            'created_at' => fake()->unique()->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null)
        ];
    }
}

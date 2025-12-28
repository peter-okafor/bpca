<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->realText(50),
            'subtitle' => $this->faker->realText(50),
            'content' => $this->faker->realText(1000),
            'user_id' => $this->faker->numberBetween(1, 10),
            'blog_category_id' => $this->faker->numberBetween(1, 10),
            'slug' => $this->faker->unique()->slug,
            'likes' => $this->faker->numberBetween(0, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogCommentFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => $this->faker->realText(100),
            // 'user_id' => $this->faker->numberBetween(1, 10),
            'author_name' => $this->faker->name,
            'author_email' => $this->faker->email,
            'blog_post_id' => $this->faker->numberBetween(1, 10),
            'approved' => $this->faker->boolean,
        ];
    }
}

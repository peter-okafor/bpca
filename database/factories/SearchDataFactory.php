<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SearchData>
 */
class SearchDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'postcode_id' => $this->faker->postcode,
            'service' => $this->faker->unique()->word,
            // 'premises' => $this->faker->word,
            'session_id' => $this->faker->word
        ];
    }
}

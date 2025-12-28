<?php

namespace Database\Factories;

use App\Enums\LocalityTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Locality>
 */
class LocalityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text(),
            'type' => $this->faker->randomElement(LocalityTypeEnum::asArray()),
            'stats' => json_encode($this->faker->word),
        ];
    }
}

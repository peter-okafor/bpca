<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PestSummary>
 */
class PestSummaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pest_id' => $this->faker->numberBetween(1, 10),
            'count' => $this->faker->randomNumber(),
            'date' => Carbon::today()
        ];
    }
}

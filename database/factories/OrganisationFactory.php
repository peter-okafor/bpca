<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'external_id' => $this->faker->unique()->numberBetween(1,10000),
            'name' => $this->faker->word(),
            'services' => $this->faker->word(),
            'premises_type' => $this->faker->word(),
            'logo_url' => $this->faker->word(),
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->address,
            'town' => $this->faker->city,
            'postcode' => $this->faker->word(),
            'contact_hours' => $this->faker->word(),
            'description' => $this->faker->realText(),
            'geodata' => new Point(
                $this->faker->randomFloat(1, 0, 1),
                $this->faker->randomFloat(1, 0, 1),
            ),
            'email' => $this->faker->email,
            'telephone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'features' => $this->faker->word(),
            'accreditation_year' => $this->faker->year,
        ];
    }
}

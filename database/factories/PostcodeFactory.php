<?php

namespace Database\Factories;

use App\Services\LocationService\Geocode\PolygonGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postcode>
 */
class PostcodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            // 'parent_postcode_id' => $this->faker->numberBetween(1, 10),
            'geodata' => (new PolygonGenerator(json_decode(json_encode([
                "northeast" =>  [
                    "lat" => 51.495350727393,
                    "lng" => -0.25344256726266
                ],
                "southwest" =>  [
                    "lat" => 51.49265276681,
                    "lng" => -0.25614052784566
                ],
            ]))))->generate(),
        ];
    }
}

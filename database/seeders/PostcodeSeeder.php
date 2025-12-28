<?php

namespace Database\Seeders;

use App\Models\Locality;
use App\Enums\LocalityTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('https://filebin.net/pmssrl4zxd2hj7j1/file0.json');
        $uk_postcodes = collect(json_decode($json));

        $countries = $uk_towns->pluck('Country')->unique()->sort();

        foreach ($countries as $country) {
            $country = trim($country);
            Locality::updateOrCreate([
                'name' => $country
            ], [
                'name' => $country,
                'description' => $country,
                'type' => LocalityTypeEnum::Country(),
                'has_locality_data' => false
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\Locality;
use App\Models\Postcode;
use Illuminate\Database\Seeder;
use App\Enums\LocalityTypeEnum;
use App\Http\Controllers\LocalityData;
use App\Jobs\Locality\SeedData;
use App\Services\LocationService\Geocode\ILocationGeocode;
use Illuminate\Support\Facades\File;
use MatanYadaev\EloquentSpatial\Objects\Point;

class LocalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {

        $json = file_get_contents('https://filebin.net/c2muyv0qr6vuqg0d/uk.min.json');
        $uk_towns = collect(json_decode($json));

        $countries = $uk_towns->pluck('Country')->unique()->sort();
        foreach ($countries as $country) {
            if (!Locality::where('name', $country)->exists()) {
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

        $regions = $uk_towns->pluck('Country', 'Region');
        foreach ($regions as $region => $country) {

            if ($countries->contains($region)) {
                continue;
            }

            $parent = Locality::whereName($country)->whereType(LocalityTypeEnum::Country())->get()->first();

            if (!Locality::whereName($region)->exists()) {
                Locality::updateOrCreate([
                    'name' => $region
                ], [
                    'name' => $region,
                    'description' => $region,
                    'parent_locality_id' => $parent->id ?? null,
                    'type' => LocalityTypeEnum::Region(),
                    'has_locality_data' => false
                ]);
            }
        }

        $counties = $uk_towns->pluck('Region', 'County');
        foreach ($counties as $county => $region) {
            $parent = Locality::whereName($region)->whereType(LocalityTypeEnum::Region())->get()->first();

            if (empty($parent)) {
                $parent = Locality::whereName($region)->whereType(LocalityTypeEnum::Country())->get()->first();
            }

            if (!Locality::whereName($county)->exists()) {
                Locality::updateOrCreate([
                    'name' => $county,
                    'type' => LocalityTypeEnum::County()
                ], [
                    'name' => $county,
                    'description' => $county,
                    'parent_locality_id' => $parent->id ?? null,
                    'type' => LocalityTypeEnum::County(),
                    'has_locality_data' => false
                ]);
            }
        }
        
        /**
         * Chunk and dispatch to queues
         */
        $chunkable = $uk_towns->chunk(500);

        foreach ($chunkable as $chunk) {
            SeedData::dispatch($chunk);
        }
    }
}

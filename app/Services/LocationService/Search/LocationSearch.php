<?php
namespace App\Services\LocationService\Search;

use App\Enums\LocalityTypeEnum;
use App\Models\Locality;
use App\Models\Postcode;
use App\Services\LocationService\Geocode\PointGenerator;
use App\Services\LocationService\Locator\Locator;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationSearch implements ILocationSearch
{
    public function search(string $postcode, string $pest_code): array
    {
        try {
            $search_cache = Cache::remember("$postcode - $pest_code", 86400, function () use($postcode, $pest_code) {
                //
                $distance = config('location.distance');

                $locator = new Locator($postcode);

                $geoPoint = (new PointGenerator($locator->getLocation()))->generate();
                
                // $organisations = Organisation::query()->
                // whereDistanceSphere('geodata', $geoPoint, '<=', (int) $distance)->
                // where('services', 'LIKE', "%$pest_code%")->
                // orderByDistance('geodata', $geoPoint)->get();

                $organisations = Postcode::query()->
                    whereDistance('geodata', $geoPoint, '<=', (int) $distance)->
                    orderByDistance('geodata', $geoPoint)->
                    withWhereHas('organisations', function ($query) use ($pest_code)
                    {
                        $query->withWhereHas('pests', function ($query) use ($pest_code)
                        {
                            $query->where('code', 'LIKE', "%$pest_code%");
                        });
                    })->get()->pluck('organisations')->flatten(1)->unique('id')->values()->toArray();
                
                $locality = Locality::firstOrCreate(
                    ['name' => $locator->getLocality()],
                    ['type' => LocalityTypeEnum::Town()]
                );
                
                return [
                    'organisations' => $organisations,
                    'location' => $locality,
                ];
            });

            return $search_cache;

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return [
                'organisations' => [],
                'location' => [],
            ];
        }
    }
}

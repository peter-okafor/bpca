<?php
namespace App\Services\OrdinanceSurvey;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OrdinanceSurvey
{
    private $api_key;
    private $endpoint;
    private $cacheTime = 60 * 60 * 24;

    public function __construct() {
        $this->endpoint = "https://api.ordnancesurvey.co.uk/places/v1/addresses/find";//config('ordinance.baseurl')."/places/v1/addresses/find";
        $this->api_key = "VMb6uQwO8opE9ArNorCD3lfAHYjLx2nN";//config('ordinance.api_key');
    }

    public function getGeoInformation(string $location, bool $includePolygon = true)
    {
        $params = [
            "query" => $location,
            "key" => $this->api_key,
            "dataset" => "DPA,LPI",
            "polygon" => $includePolygon ? "true" : "false"  // Include the polygon in the response
        ];

        $cachedValue = $this->getCachedValue($location);

        if ($cachedValue) {
            return $cachedValue;
        }

        $cachedResponse = Cache::remember(
            $this->getCacheKey($location),
            $this->cacheTime,
            function () use($params) {
                $response = Http::get($this->endpoint, $params);
                if ($response->successful() && !isset($response->object()->fault)) {
                    return $response->object();
                }
            }
        );

        return $cachedResponse ? $cachedResponse : null;
    }

    private function getCacheKey($location)
    {
        return `Ordinance - $location`;
    }

    private function getCachedValue($location)
    {
        return Cache::get($this->getCacheKey($location), null);
    }
}

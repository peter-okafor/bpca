<?php
namespace App\Services\OrdinanceSurvey;

use App\Services\LocationService\Geocode\ILocationGeocode;
use Exception;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class OrdinanceGeocode implements ILocationGeocode
{
    private $srid = 4326;

    public function geocodeToPoint(string $location): ?Point
    {
        try {
            $geoInformation = (new OrdinanceSurvey())->getGeoInformation($location);

            if ($geoInformation) {
                $lat = $geoInformation->results[0]->lat;
                $lng = $geoInformation->results[0]->lng;
                return new Point($lat, $lng, $this->srid);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function geocodeToPolygon(string $location): ?Polygon
    {
        try {
            $geoInformation = (new OrdinanceSurvey())->getGeoInformation($location);

            if ($geoInformation) {
                $polygon = $geoInformation->results[0]->geometry->polygon;
                $points = $this->convertPoints($polygon);
                return (new PolygonConverter($points))->generate();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    private function convertPoints(array $polygon): array
    {
        $result = [];

        foreach ($polygon as $point) {
            array_push(
                $result,
                new Point(
                    $point[0],
                    $point[1],
                    $this->srid
                )
            );
        }

        return $result;
    }
}
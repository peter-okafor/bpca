<?php
namespace App\Services\OrdinanceSurvey;

use App\Services\LocationService\Geocode\IGenerator;
use Exception;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

/**
 * Convert google maps viewport to mysql polygon
 */

class PolygonConverter implements IGenerator
{
    private $points;
    private $srid;

    public function __construct($points, $srid = 4326) {
        $this->points = $points;
        $this->srid = $srid;
    }

    public function generate()
    {
        try {
            $points = $this->points;

            if (!$points) {
                throw new Exception('Points cannot be empty');
                return;
            }

            $srid = $this->srid;

            $polygon = new Polygon([
                new LineString($points)
            ], $srid);

            return $polygon;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

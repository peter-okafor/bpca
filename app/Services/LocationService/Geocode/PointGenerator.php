<?php
namespace App\Services\LocationService\Geocode;

use Exception;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * Convert google maps location to mysql polygon
 */

class PointGenerator implements IGenerator
{
    private $location;
    private $srid;

    public function __construct($location, $srid = 4326) {
        $this->location = $location;
        $this->srid = $srid;
    }

    public function generate()
    {
        try {
            $location = $this->location;

            if (!$location) {
                throw new Exception('location cannot be null');
                return;
            }

            $srid = $this->srid;

            $polygon = new Point(
                floatval($location->lng),
                floatval($location->lat),
                $srid
            );

            return $polygon;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
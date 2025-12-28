<?php
namespace App\Services\LocationService\Geocode;

use Exception;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

/**
 * Convert google maps viewport to mysql polygon
 */

class PolygonGenerator implements IGenerator
{
    /**
     * viewport:
        * {
            * "northeast":
            *   { "lat": number, "lng": number },
            * "southwest":
            *   { "lat": number, "lng": number },
        * },
     */
    private $viewport;
    private $srid;

    public function __construct($viewport, $srid = 4326) {
        $this->viewport = $viewport;
        $this->srid = $srid;
    }

    public function generate()
    {
        try {
            $viewport = $this->viewport;

            if (!$viewport) {
                throw new Exception('viewport cannot be null');
                return;
            }

            $srid = $this->srid;

            $northeast = new Point(
                $viewport->northeast->lat,
                $viewport->northeast->lng,
                $srid
            );
            $southwest = new Point(
                $viewport->southwest->lat,
                $viewport->southwest->lng,
                $srid
            );

            $northwest = new Point(
                $viewport->northeast->lat,
                $viewport->southwest->lng,
                $srid
            );
            $southeast = new Point(
                $viewport->southwest->lat,
                $viewport->northeast->lng,
                $srid
            );

            $polygon = new Polygon([
                new LineString([
                    $northwest,
                    $northeast,
                    $southeast,
                    $southwest,
                    $northwest,
                ])
            ], $srid);

            return $polygon;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

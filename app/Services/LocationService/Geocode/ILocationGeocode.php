<?php
namespace App\Services\LocationService\Geocode;

use App\Data\GeoBound;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

interface ILocationGeocode {
	public function geocodeToPoint(string $postcode): ?Point;

	public function geocodeToPolygon(string $postcode): ?Polygon;
}

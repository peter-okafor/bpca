<?php

namespace App\Services\LocationService\Geocode;

use Exception;
use App\Data\GeoBound;
use App\Data\PlaceDetailResponse;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use App\Services\LocationService\GoogleMapsApi\GoogleMapsApi;

class LocationGeocode implements ILocationGeocode
{
    public function geocode(string $postcode): GeoBound
    {
        try {
            $detailsResponse = $this->googlePostCodeDetail($postcode);
            if (!empty($detailsResponse->result)) {
                $googleViewPort = $detailsResponse->result->geometry->viewport;

                $geoPoint = new GeoBound([
                    'north' => $googleViewPort->northeast->lat,
                    'east' => $googleViewPort->northeast->lng,
                    'south' => $googleViewPort->southwest->lat,
                    'west' => $googleViewPort->southwest->lng,
                    'location' => [
                        $detailsResponse->result->geometry->location->lat,
                        $detailsResponse->result->geometry->location->lng
                    ]
                ]);

            }

            return $geoPoint ?? new GeoBound([]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return new GeoBound([]);
    }

    public function geocodeToPoint(string $postcode): ?Point
    {
        try {
            $detailsResponse = $this->googlePostCodeDetail($postcode);

            if (!empty($detailsResponse->result)) {
                $googleLocation = $detailsResponse->result->geometry->location;

                $geoPoint = new Point(
                    floatval($googleLocation->lng),
                    floatval($googleLocation->lat),
                    4326
                );

                return $geoPoint;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return new Point(0, 0, 4326);
    }

    public function geocodeToPolygon(string $postcode): ?Polygon
    {
        try {
            $detailsResponse = $this->googlePostCodeDetail($postcode);

            if (!empty($detailsResponse->result)) {
                $viewport = $detailsResponse->result->geometry->viewport;

                $polygon = new PolygonGenerator($viewport);

                return $polygon->generate();
            }
        } catch (Exception $e) {
            Log::channel('slack')->error($e->getMessage());
        }

        /**
         * Handle "Polygon must contain a value error"
         */
        return new Polygon([]);
    }

    private function googlePostCodeDetail(string $postcode): PlaceDetailResponse
    {
        try {
            if (empty($postcode)) {
                return new PlaceDetailResponse([]);
            }

            $searchResponse = GoogleMapsApi::placeSearch($postcode);

            if (empty($searchResponse->predictions)) {
                $searchResponse = GoogleMapsApi::placeSearch($this->getOutbound($postcode));
            }

            $detailsResponse = GoogleMapsApi::placeDetail(
                $searchResponse->predictions[0]->place_id
            );

            return $detailsResponse;
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return new PlaceDetailResponse([]);
    }

    private function getOutbound(string $postcode): string
    {
        return explode(' ', $postcode) [0];
    }
    // public function eastingNorthingToPolygon($easting, $northing, $distance): Polygon
    // {
    //     $srid = 4326;
    //     // Convert easting and northing to radians
    //     $eastingRad = deg2rad($easting);
    //     $northingRad = deg2rad($northing);

    //     // Set the Earth's radius in meters
    //     $earthRadius = 6371e3;

    //     // Calculate the latitude and longitude differences in radians
    //     $latDiff = $distance / $earthRadius;
    //     $lngDiff = $distance / (cos($northingRad) * $earthRadius);

    //     // Calculate the bounding box coordinates
    //     $north = $northingRad + $latDiff;
    //     $south = $northingRad - $latDiff;
    //     $east = $eastingRad + $lngDiff;
    //     $west = $eastingRad - $lngDiff;

    //     // Convert the bounding box coordinates back to degrees
    //     $north = rad2deg($north);
    //     $south = rad2deg($south);
    //     $east = rad2deg($east);
    //     $west = rad2deg($west);

    //     // Return the polygon string
    //     return new Polygon([
    //         new LineString([
    //             new Point($west, $north, $srid),
    //             new Point($east, $north, $srid),
    //             new Point($east, $south, $srid),
    //             new Point($west, $south, $srid),
    //             new Point($west, $north, $srid),
    //         ])
    //     ], $srid);

    //     //        return $polygon;
    //     //        // Construct the polygon string
    //     //        $polygon = "POLYGON((";
    //     //        $polygon .= "$west $north, ";
    //     //        $polygon .= "$east $north, ";
    //     //        $polygon .= "$east $south, ";
    //     //        $polygon .= "$west $south, ";
    //     //        $polygon .= "$west $north))";
    // }


}

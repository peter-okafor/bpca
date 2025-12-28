<?php
namespace App\Services\LocationService\GoogleMapsApi;

use App\Data\PlaceDetailResponse;
use App\Data\PlaceSearchResponse;

interface IGoogleMapsApi {
    public static function placeSearch(string $postcode): PlaceSearchResponse;

    public static function placeDetail(string $placeId): PlaceDetailResponse;
}
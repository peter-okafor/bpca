<?php
namespace App\Services\LocationService\GoogleMapsApi;

class GoogleMapsUrls {
    private const BASE_URL = "https://maps.googleapis.com/";

    public const PLACE_SEARCH = self::BASE_URL."maps/api/place/autocomplete/json";
    public const PLACE_DETAIL = self::BASE_URL."maps/api/place/details/json";
}
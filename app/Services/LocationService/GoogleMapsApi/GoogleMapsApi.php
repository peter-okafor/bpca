<?php
namespace App\Services\LocationService\GoogleMapsApi;

use App\Data\PlaceDetailResponse;
use App\Data\PlaceSearchResponse;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleMapsApi implements IGoogleMapsApi 
{
    const cacheTime = 60 * 60 * 24;
    
    public static function placeSearch($postcode): PlaceSearchResponse
    {
        $url = GoogleMapsUrls::PLACE_SEARCH;
        
        try {
            $searchResponse = Cache::remember('Google-Search-'.$postcode, self::cacheTime, function () use ($url, $postcode) {
                $response = Http::get($url, [
                    'key' => config('googlemaps.key'),
                    'input' => ($postcode)
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $searchResponse = [];
        }

        return new PlaceSearchResponse($searchResponse);

    }

    public static function placeDetail($placeId): PlaceDetailResponse
    {
        $url = GoogleMapsUrls::PLACE_DETAIL;

        try {
            $searchDetail = Cache::remember(
                'Google-Detail-'.$placeId,
                self::cacheTime,
                function () use ($url, $placeId) {
                    $response = Http::get($url, [
                        'key' => config('googlemaps.key'),
                        'placeid' => urlencode($placeId)
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }
                }
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $searchDetail = [];
        }

        return new PlaceDetailResponse($searchDetail);
    }
}
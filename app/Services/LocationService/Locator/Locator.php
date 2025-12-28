<?php
namespace App\Services\LocationService\Locator;

use App\Data\PlaceDetailResponse;
use App\Services\Helpers\MyArr;
use App\Services\LocationService\GoogleMapsApi\GoogleMapsApi;
use Exception;
use Illuminate\Support\Facades\Log;

class Locator implements ILocator
{
    private $locationInformation;

    public function __construct($postcode) {
        $this->locationInformation = $this->googlePostCodeDetail($postcode);
    }

    public function getLocality(): string
    {
        try {
            $addressComponents = $this->locationInformation->result->address_components;

            $locality = collect($addressComponents)->filter(function ($item)
            {
                return MyArr::contains(
                    $item->types, 
                    ['locality', 'postal_town', 'neighborhood']
                );
            })->first()->long_name ?? "";

            return $locality;

        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        return "";
    }

    public function getLocation() {
        try {
            $locationInformation = $this->locationInformation;

            return !empty($locationInformation->result) ? $locationInformation->result->geometry->location : null;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        return null;
    }

    public function getViewPort()
    {
        try {
            $locationInformation = $this->locationInformation;

            return !empty($locationInformation->result) ? $locationInformation->result->geometry->viewport : null;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        return null;
    }

    private function googlePostCodeDetail(string $postcode): PlaceDetailResponse
    {
        try {
            if (empty($postcode)) {
                return new PlaceDetailResponse([]);
            }

            $searchResponse = GoogleMapsApi::placeSearch($postcode);

            if (!empty($searchResponse->predictions)) {
                $detailsResponse = GoogleMapsApi::placeDetail(
                    $searchResponse->predictions[0]->place_id
                );

                return $detailsResponse;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return new PlaceDetailResponse([]);
    }
}

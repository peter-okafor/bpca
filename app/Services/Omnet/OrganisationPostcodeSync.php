<?php

namespace App\Services\Omnet;

use Exception;
use App\Models\Postcode;
use App\Models\Organisation;
use App\Services\Helpers\MyArr;
use Illuminate\Support\Facades\Log;

/**
 * Link Organisation and Postcode
 */
class OrganisationPostcodeSync
{
    private $organisation;
    private $postcodes;
    private $searchAreas;


    public function __construct(Organisation $organisation, array $postcodes, array $searchAreas)
    {
        $this->organisation = $organisation;
        $this->postcodes = $postcodes;
        $this->searchAreas = $searchAreas;
    }

    private function getUnsetSearchAreas(array $postcodes, array $searchAreas)
    {
        return MyArr::difference($searchAreas, $postcodes);
    }

    private function geocodeSearchAreas(array $searchAreas)
    {
        try {
            $postcodeIds = collect($searchAreas)->map(function ($area) {

                if (strlen(trim($area)) > 10) {  // not a valid postcode
                    return null;
                }
                //$locationInfo = new Locator($area);

                $postcode = Postcode::firstOrCreate(['title' => $area], [
                    'title' => $area,
                    //  'geodata' => (new PolygonGenerator($locationInfo->getViewPort()))->generate()
                ]);
               // $postcode->save();

                // Need to test if this links whether or not the locality exists
                //                $postcode->localities()->firstOrCreate(
                //                    ['name' => $locationInfo->getLocality()],
                //                    ['type' => LocalityTypeEnum::Town()]
                //                );

                return $postcode->id;
            });

            return $postcodeIds->filter()->toArray();
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return [];
        }
    }

    /**
     * link organisation and search areas
     */
    public function syncSearchAreas()
    {
        //$areas = $this->getUnsetSearchAreas($this->postcodes, $this->searchAreas);

        $postcodeIds = $this->geocodeSearchAreas($this->searchAreas);

        if (!empty($postcodeIds)) {
            $this->organisation->locations()->sync($postcodeIds);
        }

        return $this->organisation;
    }
}

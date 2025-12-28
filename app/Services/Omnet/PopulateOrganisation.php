<?php
namespace App\Services\Omnet;

use App\Models\Organisation;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * Use Omnet data to create organisations
 */

class PopulateOrganisation 
{
    private $omnetData;
    private $propertyValues;

    public function __construct($omnetData) {
        $this->omnetData = collect($omnetData);
        $this->propertyValues = collect($omnetData['Properties']);
    }

    public function createOrganisation()
    {
        $omnetData = $this->omnetData;
        $propertyValues = $this->propertyValues;

        // $organisation = Organisation([
        //     'external_id' => $omnetData->get('ExternalId'),
        //     'name' => $omnetData->get('Title') ?? "",
        //     'services' => $propertyValues->get('Service') ?? "",
        //     'logo_url' => $propertyValues->get("LogoUrl") ?? "",
        //     'premises_type' => $propertyValues->get("Premises Type") ?? "",
        //     'address_1' => $propertyValues->get("Address Line 1") ?? "",
        //     'address_2' => $propertyValues->get("Address Line 2") ?? "",
        //     'town' => $propertyValues->get("Address Town") ?? "",
        //     'postcode' => $propertyValues->get("Address Postcode") ?? "",
        //     'geodata' => new Point(floatval($omnetData->get('Longitude')), floatval($omnetData->get('Latitude')), 4326),
        //     'email' => $propertyValues->get("Email") ?? "",
        //     'telephone' => $propertyValues->get("Telephone") ?? "",
        //     'mobile' => $propertyValues->get("Mobile") ?? "",
        // ]);

        $organisation = Organisation::updateOrCreate(
            [
                'external_id' => $omnetData->get('ExternalId'), // The attributes to search for
                'name' => $omnetData->get('Title') ?? "",
            ],
            [
                'services' => $propertyValues->get('Service') ?? "",
                'logo_url' => $propertyValues->get("LogoUrl") ?? "",
                'premises_type' => $propertyValues->get("Premises Type") ?? "",
                'address_1' => $propertyValues->get("Address Line 1") ?? "",
                'address_2' => $propertyValues->get("Address Line 2") ?? "",
                'town' => $propertyValues->get("Address Town") ?? "",
                'postcode' => $propertyValues->get("Address Postcode") ?? "",
                'geodata' => new Point(floatval($omnetData->get('Longitude')), floatval($omnetData->get('Latitude')), 4326),
                'email' => $propertyValues->get("Email") ?? "",
                'telephone' => $propertyValues->get("Telephone") ?? "",
                'mobile' => $propertyValues->get("Mobile") ?? "",
            ]
        );

        // $organisation->save();

        return $organisation;
    }

}

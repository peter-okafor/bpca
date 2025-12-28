<?php

namespace Tests\Unit;

use App\Models\Organisation;
use App\Services\Omnet\PopulateOrganisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Tests\TestCase;

class PopulateOrganisationTest extends TestCase
{
    use RefreshDatabase;
    private $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            "Position" => [
                "Longitude" => -0.253321181085551000,
                "Latitude" => 51.493562293138417000
            ],
            "FlexMapEntityKey" => "667191ce-f1f6-40eb-8f5f-05d5b47ef5f7",
            "FlexMapEntityId" => "667191ce-f1f6-40eb-8f5f-05d5b47ef5f7",
            "ExternalId" => "1983",
            "Latitude" => 51.493562293138417000,
            "Longitude" => -0.253321181085551000,
            "Title" => "HSQC SAFERPEST",
            "ExternalProvider" => "3SiFindPestController",
            "Properties" => [
                "Address Line 1" => "Unit 6 Turnham Green Terrace Mews",
                "Address Line 2" => "Turnham Green",
                "Address Town" => "Chiswick",
                "Address Postcode" => "W4 1QU",
                "LogoUrl" => "http://webtools.bpca.org.uk/MediaHandler.aspx?type=OD\u0026organisationid=1983\u0026infocode=WEB_DIR_SVR\u0026directorycode=4209\u0026seqno=0\u0026logo=1",
                "Telephone" => "0208 7478701",
                "Email" => "admin@hsqc.com",
                "URL" => "www.hsqc.com",
                "Features" => "2MLIABILITY|100QualStaff|EN16636",
                "Premises Type" => "Commercial",
                "Service" => "SAB|SBC|ANT|BBUG|CROACH|FLEAS|FLIES|FOX|MOTH|OTHINS|OTHMAM|SQUIR|WASP",
            ],
            "Status" => true,
            "Description" => null,
            "Featured" => null,
            "PropertyValues" => null,
            "Url" => null,
            "ApplicationId" => "1f75ff52-0d6d-4bd6-9281-5a9b92ba2403",
            "SearchAreas" => [
                "SY13",
                "W1",
                "W10",
                "W11",
                "W12",
                "W13",
                "W14",
                "W1B",
                "W1C",
                "W2",
                "W3",
                "W4",
                "W5",
                "W6",
                "W7",
                "W8",
                "W9",
                "N1",
                "N10",
                "N11",
                "N12",
                "N13",
                "N14",
                "N15",
                "N16",
                "N17",
                "N18",
                "N19",
                "N2",
                "N20",
                "N21",
                "N22",
                "N3",
                "N4",
                "N5",
                "N6",
                "N7",
                "N8",
                "N9",
                "SE1",
                "SE10",
                "SE11",
                "SE12",
                "SE13",
                "SE14",
                "SE15",
                "SE16",
                "SE17",
                "SE18",
                "SE19",
                "SE2",
                "SE20",
                "SE21",
                "SE22",
                "SE23",
                "BS1",
                "BS10",
                "BS11",
                "BS13",
                "BS14",
                "BS15",
                "BS16",
                "BS2",
                "BS20",
                "BS3",
                "BS30",
                "BS31",
                "BS32",
                "BS34",
                "BS35",
                "BS36",
                "BS37",
                "BS39",
                "BS4",
                "BS40"
            ]
        ];
    }

    /**
     * Organisation model can be created with omnet data.
     *
     * @return void
     */
    public function test_organisation_can_be_created_with_omnet_data()
    {
        $organisation = (new PopulateOrganisation($this->data))->createOrganisation();

        $this->assertNotEmpty($organisation);

        $this->assertDatabaseHas('organisations', [
            "external_id" => "1983",
            "name" => "HSQC SAFERPEST",
            "services" => "SAB|SBC|ANT|BBUG|CROACH|FLEAS|FLIES|FOX|MOTH|OTHINS|OTHMAM|SQUIR|WASP",
            "premises_type" => "Commercial",
            "logo_url" => "http://webtools.bpca.org.uk/MediaHandler.aspx?type=OD\u0026organisationid=1983\u0026infocode=WEB_DIR_SVR\u0026directorycode=4209\u0026seqno=0\u0026logo=1",
            "address_1" => "Unit 6 Turnham Green Terrace Mews",
            "address_2" => "Turnham Green",
            "town" => "Chiswick",
            "postcode" => "W4 1QU",
            "email" => "admin@hsqc.com",
            "telephone" => "0208 7478701",
            "mobile" => "",
        ]);

    }
}

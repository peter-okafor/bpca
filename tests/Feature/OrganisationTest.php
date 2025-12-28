<?php

namespace Tests\Feature;

use App\Jobs\UpdateOrganisationInformation;
use App\Models\Organisation;
use App\Services\LocationService\GoogleMapsApi\GoogleMapsUrls;
use App\Services\Omnet\OmnetUrls;
use Database\Seeders\PestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrganisationTest extends TestCase
{
    use RefreshDatabase;
    private $data;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->seed();
        $this->withoutExceptionHandling();

        $searchUrl = GoogleMapsUrls::PLACE_SEARCH;
        $detailUrl = GoogleMapsUrls::PLACE_DETAIL;
        $omnetUrl = OmnetUrls::PESTCONTROLLER_URL;

        Http::preventStrayRequests();

        Http::fake([
            "{$detailUrl}*" => Http::response([
                "html_attributions" => [],
                "result" => [
                    "address_components" =>  [
                        [
                            "long_name" => "W4 1QU",
                            "short_name" => "W4 1QU",
                            "types" =>  [
                                "postal_code"
                            ],
                        ],
                        [
                            "long_name" => "Turnham Green Terrace",
                            "short_name" => "Turnham Green Terrace",
                            "types" =>  [
                                "route"
                            ],
                        ],
                        [
                            "long_name" => "Chiswick",
                            "short_name" => "Chiswick",
                            "types" =>  [
                                "neighborhood",
                                "political"
                            ],
                        ],
                        [
                            "long_name" => "London",
                            "short_name" => "London",
                            "types" =>  [
                                "postal_town",
                            ],
                        ],
                        [
                            "long_name" => "Greater London",
                            "short_name" => "Greater London",
                            "types" =>  [
                                "administrative_area_level_2",
                                "political"
                            ],
                        ],
                        [
                            "long_name" => "England",
                            "short_name" => "England",
                            "types" =>  [
                                "administrative_area_level_1",
                                "political"
                            ],
                        ],
                        [
                            "long_name" => "United Kingdom",
                            "short_name" => "GB",
                            "types" =>  [
                                "country",
                                "political"
                            ],
                        ],
                    ],
                    "adr_address" => "<span class=\"street-address\">Turnham Green Terrace</span>, <span class=\"locality\">London</span> <span class=\"postal-code\">W4 1QU</span>, <span class=\"country-name\">UK</span>",
                    "formatted_address" => "Turnham Green Terrace, Chiswick, London W4 1QU, UK",
                    "geometry" =>  [
                        "location" =>  [
                            "lat" => 51.4939911,
                            "lng" => -0.2548208
                        ],
                        "viewport" =>  [
                            "northeast" =>  [
                                "lat" => 51.495350727393,
                                "lng" => -0.25344256726266
                            ],
                            "southwest" =>  [
                                "lat" => 51.49265276681,
                                "lng" => -0.25614052784566
                            ],
                        ],
                    ],
                    "icon" => "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png",
                    "icon_background_color" => "#7B9EB0",
                    "icon_mask_base_uri" => "https://maps.gstatic.com/mapfiles/place_api/icons/v2/generic_pinlet",
                    "name" => "W4 1QU",
                    "place_id" => "ChIJTzKcYz8OdkgRkixsNnSElew",
                    "reference" => "ChIJTzKcYz8OdkgRkixsNnSElew",
                    "types" =>  [
                        "postal_code"
                    ],
                    "url" => "https://maps.google.com/?q=W4+1QU&ftid=0x48760e3f639c324f:0xec958474366c2c92",
                    "utc_offset" => 60
                ],
                "status" => "OK"
            ]),
            "{$searchUrl}*" => Http::response([
                "predictions" => [
                    [
                        "description" => "Turnham Green Terrace, London W4 1QU, UK",
                        "matched_substrings" => [
                            [
                                "length" => 6,
                                "offset" => 30
                            ]
                        ],
                        "place_id" => "ChIJTzKcYz8OdkgRkixsNnSElew",
                        "reference" => "ChIJTzKcYz8OdkgRkixsNnSElew",
                        "structured_formatting" => [
                            "main_text" => "W4 1QU",
                            "main_text_matched_substrings" => [
                                [
                                    "length" => 6,
                                    "offset" => 0
                                ]
                            ],
                            "secondary_text" => "Turnham Green Terrace, London, UK"
                        ],
                        "terms" => [
                            [
                                "offset" => 0,
                                "value" => "Turnham Green Terrace"
                            ],
                            [
                                "offset" => 23,
                                "value" => "London"
                            ],
                            [
                                "offset" => 30,
                                "value" => "W4 1QU"
                            ],
                            [
                                "offset" => 38,
                                "value" => "UK"
                            ]
                        ],
                        "types" => [
                            "postal_code",
                            "geocode"
                        ]
                    ]
                ],
                "status" => "OK"
            ]),
        ]);

        Http::fake([
            "$omnetUrl*" => [
                "nameField" => "Falcon Environmental Ltd",
                "addressField" => [
                    "line1Field" => "Coppice Road Arnold",
                    "line2Field" => "",
                    "townField" => "Nottingham",
                    "postcodeField" => "NG5 7GS"
                ],
                "emailField" => "rayfretwell@falcenv.co.uk",
                "telephoneField" => "",
                "websiteField" => "",
                "contactHoursField" => "",
                "descriptionField" => "<?xml version=\"1.0\" encoding=\"utf-8\"?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><title>Document Title 1</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /></head><body></body></html>",
                "logoUrlField" => "http://webtools.bpca.org.uk/MediaHandler.aspx?type=OD&organisationid=5648&infocode=WEB_DIR_SVR&directorycode=3444&seqno=0",
                "featuresField" => [
                    "Minimum £2 million+ Liability Insurance",
                    "100% Qualified Staff",
                    "EN16636 Audited"
                ],
                "servicesField" => [
                    "Commercial",
                    "Residential"
                ],
                "pestsCoveredField" => [
                    "Ants",
                    "Bed Bugs",
                    "Cockroaches",
                    "Fleas",
                    "Flies",
                    "Moths",
                    "Other Insects",
                    "Wasps",
                    "Birds",
                    "Rats and Mice"
                ]
            ]
        ]);

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
                "Service" => "ANT|BBUG|CROACH|FLEAS|FLIES|MOTH|SQUIR|WASP",
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
     * Test the callback gets data saved to process table
     *
     * @return void
     */
    public function test_callback()
    {
        // given
        Bus::fake();
        $this->assertDatabaseCount('organisation_locations', 0);
        $this->assertDatabaseCount('organisation_pest', 0);
        $this->assertDatabaseCount('postcodes', 0);
        $data = $this->data;

        // when
        $response = $this->post('/api/omnet/callback', $data);

        // then
        $response->assertStatus(200);
        Bus::assertDispatched(UpdateOrganisationInformation::class);
    }

    /**
     * Test the job gets data saved to process table
     *
     * @return void
     */
    public function test_job()
    {
        // given
        $this->seed([
            PestSeeder::class
        ]);
        $services = "ANT|BBUG|CROACH|FLEAS|FLIES|MOTH|SQUIR|WASP";
        
        $this->assertDatabaseCount('organisation_locations', 0);
        $this->assertDatabaseCount('organisation_pest', 0);
        $this->assertDatabaseCount('postcodes', 0);

        // when
        $job = new UpdateOrganisationInformation($this->data);
        $job->handle();

        // then
        $this->assertDatabaseHas('organisations', [
            "external_id" => "1983",
            "name" => "HSQC SAFERPEST",
            "services" => $services,
            "premises_type" => "Commercial",
            "logo_url" => "http://webtools.bpca.org.uk/MediaHandler.aspx?type=OD\u0026organisationid=1983\u0026infocode=WEB_DIR_SVR\u0026directorycode=4209\u0026seqno=0\u0026logo=1",
            "address_1" => "Unit 6 Turnham Green Terrace Mews",
            "address_2" => "Turnham Green",
            "town" => "Chiswick",
            "postcode" => "W4 1QU",
            // "geodata" => "POINT (0.253321181085551 51.493562293138417)",
            "email" => "admin@hsqc.com",
            "telephone" => "0208 7478701",
            "mobile" => ""
        ]);

        $this->assertDatabaseCount('organisation_pest', count(explode('|', $services)));
        $this->assertDatabaseCount('organisation_locations', count($this->data['SearchAreas']));
        $this->assertDatabaseCount('postcodes', count($this->data['SearchAreas']));
    }
    // TODO: test parent postcode gets saved
}

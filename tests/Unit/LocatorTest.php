<?php

namespace Tests\Unit;

use App\Services\LocationService\GoogleMapsApi\GoogleMapsUrls;
use App\Services\LocationService\Locator\Locator;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LocatorTest extends TestCase
{
    protected $locator;

    protected function setUp(): void
    {
        parent::setUp();
        
        $searchUrl = GoogleMapsUrls::PLACE_SEARCH;
        $detailUrl = GoogleMapsUrls::PLACE_DETAIL;

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
            ])
        ]);

        $this->locator = new Locator("W4 1QU");
    }

    /**
     * Get locality
     *
     * @return void
     */
    public function test_get_locality()
    {
        $locator = $this->locator;
        $locality = $locator->getLocality();
        
        $this->assertEquals($locality, 'Chiswick');
    }

    /**
     * Get viewport
     *
     * @return void
     */
    public function test_get_viewport()
    {
        $locator = $this->locator;
        $viewport = $locator->getViewPort();
        
        $this->assertEquals($viewport, json_decode(json_encode([
            "northeast" =>  [
                "lat" => 51.495350727393,
                "lng" => -0.25344256726266
            ],
            "southwest" =>  [
                "lat" => 51.49265276681,
                "lng" => -0.25614052784566
            ],
        ])));
    }

    /**
     * Get location
     *
     * @return void
     */
    public function test_get_location()
    {
        $locator = $this->locator;
        $location = $locator->getLocation();

        $this->assertEquals($location, json_decode(json_encode([
            "lat" => 51.4939911,
            "lng" => -0.2548208
        ])));
    }
}

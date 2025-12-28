<?php

namespace Tests\Unit;

use App\Models\Locality;
use App\Models\Organisation;
use App\Models\Postcode;
use App\Services\LocationService\GoogleMapsApi\GoogleMapsUrls;
use App\Services\Omnet\OrganisationPostcodeSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrganisationPostcodeSyncTest extends TestCase
{
    use RefreshDatabase;

    protected $localities = [
        "W4 1QU",
        "NG5 5UU"
    ];
    protected $searchAreas = [
        "W4 1QU",
        "NG16 2BG"
    ];
    protected $locations = [
        "1" => 'Bolton', 
        "2" => 'Chelsea',
        "3" => 'London'
    ];
    protected $placeids = [
        '1'  => "W4 1QU",
        '2' => "NG16 2BG",
        '3' => "NG5 5UU"
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $searchUrl = GoogleMapsUrls::PLACE_SEARCH;
        $detailUrl = GoogleMapsUrls::PLACE_DETAIL;

        Http::preventStrayRequests();
        Http::fake(function (Request $request) use ($searchUrl)
        {
            if (str_contains($request->url(), $searchUrl)) {
                $urlData = $request->data();
                $postcode = $urlData['input'] ?? '';
                
                $placeId = array_search($postcode, $this->placeids);

                return Http::response([
                    "predictions" => [
                        [
                            "description" => "Turnham Green Terrace, London $postcode, UK",
                            "matched_substrings" => [
                                [
                                    "length" => 6,
                                    "offset" => 30
                                ]
                            ],
                            "place_id" => $placeId,
                            "reference" => $placeId,
                            "structured_formatting" => [
                                "main_text" => $postcode,
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
                                    "value" => $postcode
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
                ]);
            }
        });
        Http::fake(function (Request $request) use ($detailUrl)
        {
            if (str_contains($request->url(), $detailUrl)) {
                $urlData = $request->data();
                $placeId = $urlData['placeid'] ?? '';

                return Http::response([
                    "html_attributions" => [],
                    "result" => [
                        "address_components" =>  [
                            [
                                "long_name" => $this->placeids[$placeId],
                                "short_name" => $this->placeids[$placeId],
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
                                "long_name" => $this->locations[$placeId],
                                "short_name" => $this->locations[$placeId],
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
                        "name" => $this->placeids[$placeId],
                        "place_id" => $placeId,
                        "reference" => $placeId,
                        "types" =>  [
                            "postal_code"
                        ],
                        "url" => "https://maps.google.com/?q=W4+1QU&ftid=0x48760e3f639c324f:0xec958474366c2c92",
                        "utc_offset" => 60
                    ],
                    "status" => "OK"
                ]);
            }
        });
    }
    /**
     * Test sync.
     *
     * @return void
     */
    public function test_sync_search_areas()
    {
        $organisation = Organisation::factory()->create();

        $locality1 = Locality::factory()->create([
            'name' => 'London'
        ]);
        $locality2 = Locality::factory()->create([
            'name' => 'Bolton'
        ]);
        
        $postcode1 = Postcode::factory()->create([
            'title' => "NG5 5UU",
        ]);
        $postcode1->localities()->sync($locality1->id);

        $postcode2 = Postcode::factory()->create([
            'title' => "W4 1QU",
        ]);
        $postcode2->localities()->sync($locality2->id);

        $postcodes = Postcode::all('title')->pluck('title')->toArray(); //["NG5 5UU", "W4 1QU"];

        $searchAreas = $this->searchAreas;

        // when
        (new OrganisationPostcodeSync(
            Organisation::find($organisation->id),
            $postcodes,
            $searchAreas
        ))->syncSearchAreas();

        // then
        $this->assertDatabaseHas('postcodes', [
            'title' => $searchAreas[0]
        ]);
        
        $this->assertDatabaseHas('postcodes', [
            'title' => $searchAreas[1]
        ]);

        $this->assertDatabaseHas('localities', [
            'name' => $locality1->name
        ]);

        $this->assertDatabaseHas('localities', [
            'name' => $locality2->name
        ]);

        $this->assertDatabaseCount('postcodes', 3);
        $this->assertDatabaseCount('localities', 3);

        
    }

    // TODO: test that postcode is created, test that locality is created, test that they are all linked.
}

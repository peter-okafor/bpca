<?php

namespace App\Services\LocalityService;

use App\Enums\LocalityTypeEnum;
use App\Models\Locality;
use App\Models\Organisation;
use App\Models\Pest;
use App\Models\Postcode;
use App\Services\LocationService\Geocode\ILocationGeocode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use MatanYadaev\EloquentSpatial\Objects\Point;

class LocalityService
{
    private $request;
    private $postcode;
    private $pest;
    private $closestLocality;
    private $geocoder;
    private $url;
    private $organisations;
    private $locality;
    private $localityId;
    public $isClosestLocality = false;

    public function __construct(Request $request, ILocationGeocode $geocoder)
    {
        $this->request = $request;
        $this->postcode = $request->query('postcode', null);
        $this->pest = $request->query('pest', null);
        $this->geocoder = $geocoder;
    }

    public function setLocalities($country, $region, $county, $town, $localityId)
    {
        $localities = get_defined_vars();

        $localities = collect($localities);

        $this->findLocality($localities);

        return $this;
    }

    public function resolve()
    {
        $locality = null;

        if ($this->postcode) {
            $locality = $this->getLocalityFromPostcode();
            $this->closestLocality = null;
        }

        if ($this->closestLocality) {            
            $locality = $this->closestLocality;
            // $locality = Locality::firstWhere('name', $this->closestLocality);
            if (!is_null($locality)) {
                $this->closestLocality = null;
            }
        }

        if (!is_null($this->pest) && !is_null($locality)) {
            $locality = $this->getLocalityWithOrganisations(
                $locality,
                $this->pest
            );
            /**
             * TODO: Check if locality has_data before 
             * returning the closest locality
             */

            // If locality from org is null
            if (is_null($locality)) {
                $locality = $this->closestLocality;
                // $locality = $this->getLocalityFromPostcode();
                // This helps with not returning all default organisations
                $this->isClosestLocality = true;
            }
        }

        if (!is_null($locality)) {
            $this->setLocality($locality);

            $this->setLink($locality->link ?? null);

            if (is_null($this->organisations)) {
                !$this->isClosestLocality ? $this->setOrganisation($locality->organisations ?? null) : null;
            }
        }

        return $this;
    }

    public function getPest()
    {
        return Pest::firstWhere('code', $this->pest);
    }

    public function getOrganisations()
    {
        // return DB::table('organisations')->paginate(10);

        if ((int)$this->request->page) {
            $page = $this->request->page;
        } else {
            $page = 1;
        }

        $pageCount = 8;

        $start = $page ? ($page - 1) * $pageCount : null;

        $organisations = $this->organisations ? $this->organisations->toArray() : [];

        $req_data = '?' . http_build_query(['pest' => $this->pest, 'postcode' => $this->postcode]);

        return new LengthAwarePaginator(
            array_slice($organisations, $start, $pageCount),
            count($organisations),
            $pageCount,
            $page,
            [
                'path' => $this->pest && $this->postcode ? $this->getLink() . $req_data : $this->getLink()
            ]
        );
    }

    /**
     * Get closest locality with organisations that have the pest service
     */
    private function getLocalityWithOrganisations(Locality $locality, string $pestcode)
    {
        // Initialize a variable to store organisations
        $organisations = null;

        // Loop through the localities and their parent localities
        do {
            // Get all organisations within the provided (postcode) area
            $organisations = $locality->organisations;

            // Check if there are any organisations
            if ($organisations) {
                // Filter the organisations that provide services for the given pest code
                /** OLD */
                // $organisations = $organisations
                //     ->filter(fn ($o) => $o->pests->where('code', $pestcode)->count());

                /** NEW */
                // Load organizations with their related services and the services' related pests
                // $organisations = Organisation::with(['allservices.pests'])->get();

                // Filter organizations that have the specific pest code in their related services' pests
                $organisations = $organisations->filter(function ($organisation) use ($pestcode) {
                    return $organisation->allservices->filter(function ($service) use ($pestcode) {
                        return $service->pests->where('code', $pestcode)->count() > 0;
                    })->count() > 0;
                });

                // Check if there are any organisations left after filtering
                $hasOrgs = !!count($organisations->toArray());
            } else {
                $hasOrgs = false;
            }

            // If there are organisations that meet the criteria, set the current organisations and return the locality
            if ($hasOrgs) {
                $this->setOrganisation($organisations);
                return $locality;
            }

            // If there are no parent localities, set the closestLocality to the current locality
            if ($locality->parentLocality === null) {
                $this->closestLocality = $locality;
            }

            // Move to the parent locality for the next iteration
            $locality = $locality->parentLocality;
        } while ($locality);

        // If no suitable locality is found, return null
        return null;

    }

    private function setOrganisation($organisations)
    {
        $this->organisations =
        Organisation::addSlugToData($organisations);
    }

    public function getLink()
    {
        return $this->url ? url($this->url) : null;
    }

    private function setLink($url)
    {
        $this->url = $url;
    }

    public function getSubLocalities()
    {
        if ($this->locality) {
            return Cache::remember('sublocalities - ' . $this->locality->name, 86400, function () {
                $sublocalities = $this->locality->subLocalities->map(function ($country) {
                    return collect([
                        'item' => $country->name,
                        'link' => $country->link
                    ]);
                });
                return $sublocalities;
            });
        }
        return null;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    private function setLocality($locality)
    {
        $this->locality = $locality;
    }

    private function getPostcodeGeodata()
    {
        $postcode = $this->postcode;
        // TODO: We need to store place and postcode differently, or store them both?
        $postcodeGeodata = Postcode::firstWhere('title', $postcode)->geopoint ?? null;

        if (!is_null($postcodeGeodata)) {
            return $postcodeGeodata;
        }

        $geopoint = $this->geocoder->geocodeToPoint($postcode);
        $geodata = $this->geocoder->geocodeToPolygon($postcode);

        /**
         * Check that the geopoint value is valid
         */
        if ($this->checkRange($geopoint)) {
            Postcode::firstOrCreate(
                ['title' => $postcode],
                [
                    'geopoint' => $geopoint,
                    'geodata' => $geodata
                ]
            );

            return $geopoint;
        } else {
            return false;
        }
    }

    public function checkRange(Point $point): bool
    {
        return $point->latitude >= -90 && $point->latitude <= 90 && $point->longitude >= -180 && $point->longitude <= 180 ? true : false;
    }

    private function getLast($values)
    {
        return collect($values)->filter()->take(-1);
    }

    private function getLocalityType($value)
    {
        if ($value) {
            $value = ucfirst($value);
            return LocalityTypeEnum::fromKey($value);
        }
        return null;
    }


    private function getLocalityFromPostcode()
    {
        $geoPoint = $this->getPostcodeGeodata();

        $locality = Locality::query()
            ->whereIntersects('geodata', $geoPoint)
            ->orderBy('type', 'DESC')
            ->where('has_locality_data', true)
            ->first();

        return $locality;
    }

    /**
     * Check the route url from right - left, find the closest locality in the collection.
     */
    function findLocality($collection, $counter = 0)
    {
        if ($counter == $collection->count()) {
            // $this->closestLocality = null;
            return;
        }

        $counter == $collection->count();

        $lastValue = $collection->filter(function ($value) {
            return !is_null($value);
        })->last();

        if (is_numeric($lastValue)) {
            $modelValue = Locality::where('id', $lastValue)->first();
        } elseif (is_string($lastValue)) {
            $value = $this->cleanString($lastValue);
            $modelValue = Locality::where('name', $value)->first();
        } else {
            return $this->findLocality($collection, $counter + 1);
        }

        if (!is_null($modelValue)) {
            $this->closestLocality = $modelValue;
        } else {
            $collectionWithoutLastValue = $collection->slice(0, -1);
            return $this->findLocality($collectionWithoutLastValue, $counter - 1);
        }
    }

    public function cleanString($string): string
    {
        if (strpos($string, "in-") === 0) {
            return str_replace("in-", "", $string);
        } else {
            return str_replace("-", " ", $string);
        }
    }

    public function validatePostcode($postcode)
    {
        // if (!preg_match($postcodeRegex, $postcode)) {
        //     return true;
        // }

        // if (preg_match($postcodeRegex, $postcode)) {
        //     return true;
        // } else {
        //     return false;
        // }

        $postcodeRegex = '/^([A-Z]{1,2}[0-9][0-9A-Z]?|[A-Z][0-9A-Z]?[0-9])[A-Z]?(\s?[0-9][A-Z]{2})?$/i';

        if (preg_match($postcodeRegex, $postcode)) {
            // If it matches the postcode pattern, return true
            return true;
        } else {
            // If it doesn't match, it could be a place name. Check the Localities model.
            $locality = Locality::where('name', 'LIKE',
                '%' . $postcode . '%'
            )->first();

            if ($locality) {
                // If a match is found, return true
                return true;
            } else {
                // If no match is found, return false
                return false;
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\LocalityTypeEnum;
use App\Models\Locality;
use App\Services\LocalityService\LocalityService;
use App\Services\PestSearchData\SearchService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class NewLocalitiesController extends Controller
{
    public function get()
    {
        $search = request()->get('q');

        if (empty($search) || Str::length($search) < 3) {
            return response()->json([]);
        }

        $localities = Locality::select(['id', 'name'])->where('name', 'like', '%' . $search . '%')
            ->whereIn('type', [LocalityTypeEnum::Country(), LocalityTypeEnum::Region(), LocalityTypeEnum::County()])
            ->get();

        return response()->json($localities->map(function ($user) {
            return ['value' => $user->id, 'display' => $user->name];
        }));
    }

    /**
     * 
     * Process all search requests with the locality service
     */
    public function process($request, $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        $result = $service->setLocalities(
            $country,
            $region,
            $county,
            $town,
            $localityId,
        )->resolve();

        $resultUrl = $result->getLink();

        $emptyPagination = new LengthAwarePaginator([], 0, 15, 1, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        if (!$resultUrl) {
            return (object)[
                'page' => 'Frontend/Search/SearchPage',
                'paginator' => $emptyPagination,
                'pest' => $result->getPest(),
                'postcode' => $request->postcode,
                'city' => null,
                'locations' => [],
                'sublocalities' => []
            ];
        }

        if (rawurldecode($request->url()) == $resultUrl) {
            $paginate = $result->getOrganisations();
            $pest = $result->getPest();

            // Create map locations array
            if (!is_null($paginate)) {
                $locations = [];
                foreach ($paginate as $org) {
                    array_push($locations, [
                        'lat' => $org['geodata']['coordinates'][0],
                        'lng' => $org['geodata']['coordinates'][1],
                        'title' => $org['name'] ?? '',
                        'address' => $org['address_1'] ?? '' . ', ' . $org['postcode'] ?? '',
                        'phone' => $org['telephone'] ?? '',
                        'slug' => $org['slug'] ?? '',
                        'external_id' => $org['external_id'] ?? ''
                    ]);
                }
            }

            return (object)[
                'page' => 'Frontend/Search/SearchPage',
                'paginator' => $paginate ?? $emptyPagination,
                'pest' => $pest,
                'postcode' => $request->postcode,
                'city' => $result->getLocality(),
                'locations' => $locations ?? $emptyPagination,
                'sublocalities' => $result->getSubLocalities()
            ];
        } else {
            /** Queries are pest and postcode */
            $queries = $request->query();

            if ($queries) {
                $resultUrl = $resultUrl . '?' . http_build_query($queries);
            }

            return $resultUrl;
        }
    }

    /**
     * 
     * Pass, format and return seach data to view.
     */
    public function searchData(Object $data): array
    {
        return [
            'paginator' => $data->paginator,
            'pest' => $data->pest,
            'postcode' => $data->postcode,
            'city' => $data->city,
            'locations' => $data->locations,
            'sublocalities' => $data->sublocalities,
        ];
    }

    public function organisations(Request $request, SearchService $search, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {        
        if (!$service->validatePostcode($request->postcode)) {
            return redirect('/?postCodeError=1');
        }

        $data = $this->process(
            $request,
            $service,
            $country,
            $region,
            $county,
            $town,
            $localityId
        );

        $search->storeSession();

        if (is_object($data)) {
            return view('pages.search', $this->searchData($data));
        } else {
            return Redirect::away($data);
        }
    }

    public function country(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        $data = $this->process(
            $request,
            $service,
            $country,
            $region,
            $county,
            $town,
            $localityId
        );

        if (is_object($data)) {
            return view('pages.search', $this->searchData($data));
        } else {
            return Redirect::away($data);
        }
    }

    public function region(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        $data = $this->process(
            $request,
            $service,
            $country,
            $region,
            $county,
            $town,
            $localityId
        );

        if (is_object($data)) {
            return view('pages.search', $this->searchData($data));
        } else {
            return Redirect::away($data);
        }
    }

    public function county(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        $data = $this->process(
            $request,
            $service,
            $country,
            $region,
            $county,
            $town,
            $localityId
        );

        if (is_object($data)) {
            return view('pages.search', $this->searchData($data));
        } else {
            return Redirect::away($data);
        }
    }

    public function town(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        $data = $this->process(
            $request,
            $service,
            $country,
            $region,
            $county,
            $town,
            $localityId
        );

        if (is_object($data)) {
            return view('pages.search', $this->searchData($data));
        } else {
            return Redirect::away($data);
        }
    }

    /**
     * 
     * Expand search to nearest locality with data
     */
    public function expandSearch(Request $request)
    {
        // get last bit of the path
        $path_parts = explode("/", $request->path);
        $path_length = count($path_parts);

        // check if the path has less than 2 (may mean /pest-controllers)
        if ($path_length <= 2) return Redirect::away('/');

        // end is numeric, may mean locality id is in the path
        if (is_numeric(end($path_parts))) {
            array_splice($path_parts, -2);

            $path = implode('/', $path_parts);

            // Add the search params
            if ($request->pest && $request->postcode) {
                $params = [
                    'pest' => $request->pest,
                    'postcode' => $request->postcode
                ];

                $path_with_params = url($path) . '?' . http_build_query($params);

                return Redirect::away($path_with_params);
            }

            // Redirect without search params
            return Redirect::away($path);
        } else {
            array_pop($path_parts);
            $path = implode('/', $path_parts);
            return Redirect::away($path);
        }
    }
}

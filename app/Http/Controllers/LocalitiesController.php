<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Support\Str;
use App\Enums\LocalityTypeEnum;
use App\Exceptions\BlogException;
use App\Services\LocalityService\LocalityService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LocalitiesController extends Controller
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

        if (!$resultUrl) {
            return (object)[
                'page' => 'Frontend/Search/SearchPage',
                'paginator' => [],
                'pest' => $result->getPest(),
                'postcode' => $request->postcode,
                'city' => null,
                'sublocalities' => []
            ];

            // return Inertia::render('Frontend/Search/SearchPage', [
            //     'paginator' => [],
            //     'pest' => $result->getPest(),
            //     'postcode' => $request->postcode,
            //     'city' => null,
            //     'sublocalities' => []
            // ]);
        }

        if (rawurldecode($request->url()) == $resultUrl) {
            $paginate = $result->getOrganisations();
            $pest = $result->getPest();

            return (object)[
                'page' => 'Frontend/Search/SearchPage',
                'paginator' => $paginate->toArray(),
                'pest' => $pest,
                'postcode' => $request->postcode,
                'city' => $result->getLocality(),
                'sublocalities' => $result->getSubLocalities()
            ];

            // return Inertia::render('Frontend/Search/SearchPage', [
            //     'paginator' => $paginate->toArray(),
            //     'pest' => $pest,
            //     'postcode' => $request->postcode,
            //     'city' => $result->getLocality(),
            //     'sublocalities' => $result->getSubLocalities()
            // ]);
        } else {
            /** Queries are pest and postcode */
            $queries = $request->query();

            if ($queries) {
                $resultUrl = $resultUrl . '?' . http_build_query($queries);
            }

            // return Redirect::away($resultUrl);
            return $resultUrl;
        }
    }

    public function organisations(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
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
            return Inertia::render($data->page, [
                'paginator' => $data->paginator,
                'pest' => $data->pest,
                'postcode' => $data->postcode,
                'city' => $data->city,
                'sublocalities' => $data->sublocalities
            ]);
        } else {
            return Redirect::away($data);
        }

        // $request->validate([
        //     "page" => 'int|gte:0',
        //     'pest' => ['string', 'exists:pests,code'],
        //     'postcode' => ['string']
        // ]);

        // $result = $service->setLocalities(
        //     $country,
        //     $region,
        //     $county,
        //     $town,
        //     $localityId,
        // )->resolve();

        // $resultUrl = $result->getLink();

        // if (!$resultUrl) {
        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => [],
        //         'pest' => $result->getPest(),
        //         'postcode' => $request->postcode,
        //         'city' => null,
        //         'sublocalities' => []
        //     ]);
        // }

        // if (rawurldecode($request->url()) == $resultUrl) {
        //     $paginate = $result->getOrganisations();
        //     $pest = $result->getPest();

        //     ray($paginate->toArray());

        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => $paginate->toArray(),
        //         'pest' => $pest,
        //         'postcode' => $request->postcode,
        //         'city' => $result->getLocality(),
        //         'sublocalities' => $result->getSubLocalities()
        //     ]);

        // } else {
        //     /** Queries are pest and postcode */
        //     $queries = $request->query();

        //     if ($queries) {
        //         $resultUrl = $resultUrl.'?'.http_build_query($queries);
        //     }

        //     return Redirect::away($resultUrl);
        // }
    }

    public function country(Request $request, LocalityService $service, $country = null, $region = null, $county = null, $town = null, $localityId = null)
    {
        // $request->validate([
        //     "page" => 'int|gte:0',
        //     'pest' => ['string', 'exists:pests,code'],
        //     'postcode' => ['string']
        // ]);

        // $result = $service->setLocalities(
        //     $country,
        //     $region,
        //     $county,
        //     $town,
        //     $localityId,
        // )->resolve();

        // $resultUrl = $result->getLink();

        // if (rawurldecode($request->url()) == $resultUrl) {
        //     $paginate = $result->getOrganisations();
        //     $pest = $result->getPest();

        //     ray($paginate->toArray());

        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => $paginate->toArray(),
        //         'pest' => $pest,
        //         'postcode' => $request->postcode,
        //         'city' => $result->getLocality(),
        //         'sublocalities' => $result->getSubLocalities()
        //     ]);
        // } else {
        //     /** Queries are pest and postcode */
        //     $queries = $request->query();

        //     if ($queries) {
        //         $resultUrl = $resultUrl . '?' . http_build_query($queries);
        //     }

        //     return Redirect::away($resultUrl);
        // }
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
            return Inertia::render($data->page, [
                'paginator' => $data->paginator,
                'pest' => $data->pest,
                'postcode' => $data->postcode,
                'city' => $data->city,
                'sublocalities' => $data->sublocalities
            ]);
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
            return Inertia::render($data->page, [
                'paginator' => $data->paginator,
                'pest' => $data->pest,
                'postcode' => $data->postcode,
                'city' => $data->city,
                'sublocalities' => $data->sublocalities
            ]);
        } else {
            return Redirect::away($data);
        }

        // $request->validate([
        //     "page" => 'int|gte:0',
        //     'pest' => ['string', 'exists:pests,code'],
        //     'postcode' => ['string']
        // ]);

        // $result = $service->setLocalities(
        //     $country,
        //     $region,
        //     $county,
        //     $town,
        //     $localityId,
        // )->resolve();

        // $resultUrl = $result->getLink();

        // if (rawurldecode($request->url()) == $resultUrl) {
        //     $paginate = $result->getOrganisations();
        //     $pest = $result->getPest();

        //     ray($paginate->toArray());

        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => $paginate->toArray(),
        //         'pest' => $pest,
        //         'postcode' => $request->postcode,
        //         'city' => $result->getLocality(),
        //         'sublocalities' => $result->getSubLocalities()
        //     ]);
        // } else {
        //     /** Queries are pest and postcode */
        //     $queries = $request->query();

        //     if ($queries) {
        //         $resultUrl = $resultUrl . '?' . http_build_query($queries);
        //     }

        //     return Redirect::away($resultUrl);
        // }
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
            return Inertia::render($data->page, [
                'paginator' => $data->paginator,
                'pest' => $data->pest,
                'postcode' => $data->postcode,
                'city' => $data->city,
                'sublocalities' => $data->sublocalities
            ]);
        } else {
            return Redirect::away($data);
        }

        // $request->validate([
        //     "page" => 'int|gte:0',
        //     'pest' => ['string', 'exists:pests,code'],
        //     'postcode' => ['string']
        // ]);

        // $result = $service->setLocalities(
        //     $country,
        //     $region,
        //     $county,
        //     $town,
        //     $localityId,
        // )->resolve();

        // $resultUrl = $result->getLink();

        // if (rawurldecode($request->url()) == $resultUrl) {
        //     $paginate = $result->getOrganisations();
        //     $pest = $result->getPest();

        //     ray($paginate->toArray());

        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => $paginate->toArray(),
        //         'pest' => $pest,
        //         'postcode' => $request->postcode,
        //         'city' => $result->getLocality(),
        //         'sublocalities' => $result->getSubLocalities()
        //     ]);
        // } else {
        //     /** Queries are pest and postcode */
        //     $queries = $request->query();

        //     if ($queries) {
        //         $resultUrl = $resultUrl . '?' . http_build_query($queries);
        //     }

        //     return Redirect::away($resultUrl);
        // }
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
            return Inertia::render($data->page, [
                'paginator' => $data->paginator,
                'pest' => $data->pest,
                'postcode' => $data->postcode,
                'city' => $data->city,
                'sublocalities' => $data->sublocalities
            ]);
        } else {
            return Redirect::away($data);
        }

        // $request->validate([
        //     "page" => 'int|gte:0',
        //     'pest' => ['string', 'exists:pests,code'],
        //     'postcode' => ['string']
        // ]);

        // $result = $service->setLocalities(
        //     $country,
        //     $region,
        //     $county,
        //     $town,
        //     $localityId,
        // )->resolve();

        // $resultUrl = $result->getLink();

        // if (rawurldecode($request->url()) == $resultUrl) {
        //     $paginate = $result->getOrganisations();
        //     $pest = $result->getPest();

        //     ray($paginate->toArray());

        //     return Inertia::render('Frontend/Search/SearchPage', [
        //         'paginator' => $paginate->toArray(),
        //         'pest' => $pest,
        //         'postcode' => $request->postcode,
        //         'city' => $result->getLocality(),
        //         'sublocalities' => $result->getSubLocalities()
        //     ]);
        // } else {
        //     /** Queries are pest and postcode */
        //     $queries = $request->query();

        //     if ($queries) {
        //         $resultUrl = $resultUrl . '?' . http_build_query($queries);
        //     }

        //     return Redirect::away($resultUrl);
        // }
    }

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

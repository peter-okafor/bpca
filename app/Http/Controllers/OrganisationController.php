<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateOrganisationInformation;
use App\Models\Organisation;
use App\Models\Pest;
use App\Services\AnalyticsService\Analytics;
use App\Services\LocationService\Search\ILocationSearch;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrganisationController extends Controller
{
    const PAGE_COUNT = 8;

    public function create(Request $request)
    {
        $request->validate([
            "FlexMapEntityKey" => "string",
            "ExternalId" => "required|string",
            "Latitude" => "required|numeric",
            "Longitude" => "required|numeric",
            "Title" => "required|string",
            "ExternalProvider" => "required|string",
            "Properties" => "required|array",
            "SearchAreas" => "required|array"
        ]);

        dispatch(new UpdateOrganisationInformation($request->all()));

        return response()->json([
            'data' => [],
            'message' => 'Organisation created',
            'success' => true
        ]);
    }

    public function find(Request $request)
    {
        $request->validate([
            "page" => "int|gte:0"
        ]);

        // if  session does not exist, create session and log this search
        if (session()->missing('user_id')) {
            session()->put('user_id', uniqid());
        }

        $search_id = Analytics::logSearch(
            session('user_id'),
            $request->pestcode,
            $request->postcode
        );

        $validator = Validator::make([
            "postcode" => $request->postcode,
            "pestcode" => $request->pestcode,
        ], [
            "postcode" => "required|string",
            "pestcode" => "required|exists:pests,code",
        ]);
        $validated = $validator->validated();

        $postcode = $validated['postcode'];
        $pestcode = $validated['pestcode'];
        $page = $request->page;

        $start = $page ? ($page - 1) * self::PAGE_COUNT : null;

        $search = (app()->make(ILocationSearch::class))->search($postcode, $pestcode);

        $providers = $search['organisations'];
        $location = $search['location'];

        Inertia::share('providerList', $providers);

        if ($search_id) {
            Analytics::logView($search_id, $providers);
        }

        $paginate = new LengthAwarePaginator(
            array_slice($providers, $start, self::PAGE_COUNT),
            count($providers),
            self::PAGE_COUNT,
            $page,
            [
                'path' => ''
            ]
        );

        $pest = Pest::where('code', $pestcode)->first();

        return Inertia::render('Frontend/Search/SearchPage', [
            'paginator' => $paginate->toArray(),
            'pest' => $pest,
            'postcode' => $postcode,
            'city' => $location
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(string $organisation, string $external_id)
    {        
        //TODO: Parse organisation name
        $organisation = Cache::remember("provider - $organisation", 86400, function () use ($external_id) {
            return Organisation::where('external_id', $external_id)->first();
        });
        
        // return Inertia::render('Frontend/Details/DetailsPage', [
        //     'provider' => $organisation->load('pests')
        // ]);

        return view('pages.details', ['provider' => $organisation->load('pests'), 'pest' => []]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\BlogException;
use App\Models\ComponentContent;
use App\Models\Pest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pests = Cache::remember('pests', 86400, function () {
            return Pest::all();
        });

        return response()->json([
            'pests' => $pests
        ]);
    }

    public function webIndex()
    {
        $pests = Cache::remember('pests', 86400, function () {
            return Pest::all();
        });

        $groupPests = $pests->groupBy(function ($item) {
            return $item->name[0];
        });

        $description = Cache::remember('description', 86400, function () {
            return ComponentContent::where('component', 'AtoZDescription')->first();
        });

        return Inertia::render('Frontend/AtoZ/AtoZPage', [
            'pests' => $groupPests,
            'description' => $description,
            'imageUrl' => asset('/')
        ]);
    }

    /**
     * Filter the pests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $request->validate([
            'keyword' => 'string',
            'firstAlphabet' => 'alpha|max:1',
            'pest' => 'string',
            'environment' => 'string',
        ]);

        $keyword = $request->keyword;
        $firstAlphabet = $request->firstAlphabet;
        $pest = $request->pest;
        $environment = $request->environment;

        $pestQuery = Pest::select("*");

        if ($keyword) {
            $pestQuery = $pestQuery->where('name', 'LIKE', "%$keyword%");
        }

        if ($firstAlphabet) {
            $pestQuery = $pestQuery->where('name', 'LIKE', "$firstAlphabet%");
        }

        if ($pest) {
            $pestQuery = $pestQuery->where('name', '=', $pest);
        }

        // if ($environment) {
        //     // $pestQuery = $pestQuery->with(['atoz' => function ($query) use ($environment) {
        //     //     $query->with(['pestEnvironment' => function ($query) use ($environment) {
        //     //         $query->where('environment', $environment)->get();
        //     //     }]);
        //     // }]);
        // }

        $groupPests = $pestQuery->get()->groupBy(function ($item) {
            return $item->name[0];
        });

        return response()->json([
            'pests' => $groupPests
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $pest)
    {
        try {
            // TODO: change pest name to code
            $validator = Validator::make(
                [
                    'pest' => $request->route('pest')
                ],
                [
                    'pest' => "required|string|exists:pests,name"
                ]
            )->validate();

            $pest = Pest::where('code', Str::slug($validator['pest']))->first();

            $orgCount = DB::table('organisation_pest')->where('pest_id', $pest->id)->count();

            if ($orgCount) {
                $pestControllers = $pest->organisations->random(3)->all();
            } else {
                $pestControllers = [];
            }

            // TODO: atoz not present in $pest data
            // $atoz = $pest->atoz ?? '';
            $atoz = '';

            // TODO: atoz pest content
            // $content = $atoz->content ?? '';
            $content = '';

            // TODO: atoz pest image
            // $pestImage = $atoz->pest_image ?? '';
            $pestImage = '';

            // TODO: provide pest image, a to z pest content and top searched areas for that bug
            $topSearched = ['london', 'birmingham', 'nottingham', 'liverpool', 'manchester'];

            return Inertia::render('Frontend/AtoZ/PestPage', [
                'pest' => $pest,
                'pestControllers' => $pestControllers,
                'topSearchedAreas' => $topSearched,
                'fallbackLogo' => asset('/images/BPCA-member-logo-400-400.png'),
                'content' => $content,
                'pestImage' => $pestImage,
                'imageUrl' => asset('/')
            ]);
        } catch (Exception $e) {
            return (new BlogException(
                (int) $e->getCode(),
                $e->getMessage()
            ))->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

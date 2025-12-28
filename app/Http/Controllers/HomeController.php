<?php

namespace App\Http\Controllers;

use App\Enums\SearchSummaryEnum;
use App\Models\ComponentContent;
use App\Models\Organisation;
use App\Models\Pest;
use App\Models\ReviewComponentContent;
use App\Models\SearchSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Cache::remember('reviews', now()->addDay(), function ()
        {
            return ReviewComponentContent::all();
        });

        $benefits = Cache::remember('benefits', now()->addDay(), function ()
        {
            return ComponentContent::where('component', 'Benefits')->first();
        });

        $organisationCount = Cache::remember('organisation - count', 86400, function ()
        {
            return Organisation::count();
        });

        $pestCount = Cache::remember('pest - count', now()->addDay(), function ()
        {
            return Pest::count();
        });

        $searchAverage = Cache::remember('search - average', now()->addDay(), function ()
        {
            $avg = SearchSummary::where('key', SearchSummaryEnum::SearchCount)->average('stat');
            return (int) round($avg);
        });

        return Inertia::render('Frontend/Home/HomePage', [
            'benefits' => $benefits,
            'reviews' => $reviews,
            'organisationCount' => $organisationCount,
            'pestCount' => $pestCount,
            'searchAverage' => $searchAverage,
            'postCodeError' => $request->input('postCodeError') ?? false,
            'imageUrl' => asset('/') 
        ]);
    }

    public function about()
    {
        $about = Cache::remember('about', 86400, function ()
        {
            return ComponentContent::where('component', 'About')->first();
        });

        return Inertia::render('Frontend/About/AboutPage', [
            'about' => $about,
            'imageUrl' => asset('/') 
        ]);
    }
}

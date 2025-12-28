<?php

namespace App\Services\AnalyticsService;

use App\Jobs\AnalyticsView;
use App\Models\Postcode;
use App\Models\SearchData;

class Analytics implements IAnalytics
{
    public static function logSearch($user_id, $pest, $postcode): int
    {
        $postcode_id = Postcode::where('title', $postcode)->first()->id ?? null;

        if ($postcode_id) {
            $search_data = SearchData::create([
                'postcode_id' => $postcode_id,
                'service' => $pest,
                'session_id' => $user_id
            ]);
    
            return $search_data->id;
        }

        return 0;
    }

    public static function logView($search_id, $providers): void
    {
        dispatch(new AnalyticsView([
            'search_id' => $search_id,
            'providers' => $providers
        ]));
    }
}

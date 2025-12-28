<?php

namespace App\Jobs;

use App\Enums\SearchSummaryEnum;
use App\Models\SearchData;
use App\Models\SearchSummary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDailySearchDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uniqueSessionsCount = SearchData::whereDate('created_at', now())
        ->distinct('session_id')
        ->count('session_id');

        if ($searchSummary = SearchSummary::whereDate('created_at', now())->first()) {
            $searchSummary->update([
                'stat' => $uniqueSessionsCount
            ]);
        } else {
            SearchSummary::create([
                'date' => now(),
                'key'  => SearchSummaryEnum::SearchCount,
                'stat' => $uniqueSessionsCount
            ]);
        }
    }
}
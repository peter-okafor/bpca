<?php

namespace App\Jobs;

use App\Enums\SearchSummaryEnum;
use App\Models\Pest;
use App\Models\PestSummary;
use App\Models\SearchData;
use App\Models\SearchSummary;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SummarizeAnalyticsJob implements ShouldQueue
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
        try {
            // count the number of data searches for the day and save to summary table
            $searchCount = SearchData::whereDate('created_at', Carbon::today())->count();

            $summary = new SearchSummary([
                'date' => Carbon::today(),
                'key' => SearchSummaryEnum::SearchCount,
                'stat' => $searchCount
            ]);

            $summary->save();

            // get the services searched today
            $serviceSummary = SearchData::whereDate(
                'created_at',
                Carbon::today()
            )->select(
                'service',
                DB::raw('count(*) as total')
            )->groupBy('service')->pluck('total', 'service');
            
            // save the number of searches per service
            $serviceSummary->map(fn($total, $service) => (new PestSummary([
                'date' => Carbon::today(),
                'pest_id' => Pest::where('name', $service)->first()->id ?? null,
                'count' => $total
            ]))->save() );

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}

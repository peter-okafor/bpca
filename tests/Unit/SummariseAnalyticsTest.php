<?php

namespace Tests\Unit;

use App\Enums\SearchSummaryEnum;
use App\Jobs\SummarizeAnalyticsJob;
use App\Models\Pest;
use App\Models\Postcode;
use App\Models\SearchData;
use Carbon\Carbon;
use Database\Seeders\PestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SummariseAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the handle function of the Summary Analytics job
     *
     * @return void
     */
    public function test_summarise_analytics_job_handle_function()
    {
        // given
        $searchDataCount = 10;
        $this->seed(PestSeeder::class);

        $searchData = SearchData::factory($searchDataCount)->create([
            'postcode_id' => Postcode::factory()->create()->id,
            'service' => fake()->unique()->randomElement(Pest::all('name')->pluck('name')->toArray())
        ]);

        // when
        (new SummarizeAnalyticsJob())->handle();

        // then: the search count matches
        $this->assertDatabaseHas('search_summaries', [
            'date' => Carbon::today(),
            'key' => SearchSummaryEnum::SearchCount,
            'stat' => $searchDataCount,
        ]);

        // then: search summary contains the services searched
        $this->assertDatabaseHas('pest_summaries', [
            'date' => Carbon::today(),
            'pest_id' => Pest::where('name', $searchData->first()->service)->first()->id,
            'count' => 10
        ]);
    }
}

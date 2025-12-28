<?php

namespace App\Console\Commands;

use App\Http\Controllers\SearchDataController;
use Illuminate\Console\Command;

class PopularSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'searches:popular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get popular searches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $popularSearches = SearchDataController::popularSearches();

        // Log the result or output it in the console, for example:
        $this->info($popularSearches);

        return 0; // Successful command execution status
    }
}

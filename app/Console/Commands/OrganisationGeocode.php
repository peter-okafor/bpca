<?php

namespace App\Console\Commands;

use App\Jobs\GeocodeOrganisationJob;
use App\Models\Organisation;
use Exception;
use Illuminate\Console\Command;

class OrganisationGeocode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode:organisation {--all} {--start=1} {--end=} {--count=} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode Organisations Table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $id = $this->option('id');
            $count = $this->option('count');
            $start = $this->option('start') ?? 1;
            $end = $this->option('end');
            $end = $count ? ($start + $count - 1) : $end;
            $all = $this->option('all');

            if ($id) {
                $organisations = Organisation::where('id', $id)->get();
            } else if ($all) {
                $organisations = Organisation::all();
            } else if ($start && $end) {
                $organisations = Organisation::query()->whereBetween('id', [$start, $end])->get();
            } else {
                $this->error('You must provide an end value if count and all are not included');
                return Command::FAILURE;
            }

            $organisations->each(function ($organisation) {
                GeocodeOrganisationJob::dispatch($organisation);
            });
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

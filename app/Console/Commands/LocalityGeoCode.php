<?php

namespace App\Console\Commands;

use App\Jobs\CalculateGeoAreaJob;
use App\Models\Locality;
use App\Services\LocationService\Geocode\ILocationGeocode;
use Exception;
use Illuminate\Console\Command;

class LocalityGeoCode extends Command
{
    /**
     * Google places API allows us to make 100k free calls
     * to seed locality data every month.
     * 
     * What we have updated is, we're adding a command to
     * check how many localities have been geocoded.
     * 
     * Then update this command to take --all and --count, --start and
     * --end may be a bit complicated to use, if you're seeding data this 
     * way it may be hard to be consistent.
     * 
     * Since data is seeded sequentially, we can get the localities, that have
     * been geocoded and start geocoding the rest from the next object and not 
     * have to explicitly indicate a --start or an --end.
     */


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'geocode:locality {--seeded} {--count=}';
    protected $signature = 'geocode:locality {--seeded} {--last} {--all} {--start=1} {--end=} {--count=} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode Localites Table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('seeded')) {
            $count = Locality::where('geodata', '!=', '')->count();
            $this->info('Seeded locality geodata: '. $count);
        }

        if ($this->option('last')) {
            $lastItem = Locality::where('geodata', '!=', '')->orderBy('id', 'desc')->first();
            $this->info('Last seeded locality id: ' . $lastItem->id);
        }

        // if ($this->option('count')) {
        //     $seeded = Locality::where('geodata', '!=', '')->count();

        //     // Get collection offset and dispatch to queue
        //     $localities = Locality::offset($seeded)->limit($this->option('count') - $seeded + 1)->get();

        //     $localities->each(
        //         function ($locality) {
        //         CalculateGeoAreaJob::dispatch($locality);
        //     });

        //     $this->info('Locality geocode seeding jobs dispatched, check to ensure your queue workers are running.');
        // }

        try {
            $id = $this->option('id');
            $count = $this->option('count');
            $start = $this->option('start') ?? 1;
            $end = $this->option('end');
            $end = $count ? ($start + $count - 1) : $end;
            $all = $this->option('all');

            if ($id) {
                $localities = Locality::where('id', $id)->get();
            } else if ($all) {
                $localities = Locality::all();
            } else if ($start && $end) {
                $localities = Locality::query()->whereBetween('id', [$start, $end])->get();
            } else {
                // $this->error('You must provide an end value if count and all are not included');
                return Command::FAILURE;
            }

            $localities->each(function ($locality) {
                CalculateGeoAreaJob::dispatch($locality);
            });

            $this->info('Locality geocode seeding jobs dispatched, check to ensure your queue workers are running.');
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

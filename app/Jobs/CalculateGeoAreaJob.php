<?php

namespace App\Jobs;

use App\Models\Locality;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\LocationService\Geocode\ILocationGeocode;

class CalculateGeoAreaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Locality $locality;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(Locality $locality)
    {
        $this->locality = $locality;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle(ILocationGeocode $geocoder)
    {
        if (empty($this->locality->name)) {
            return;
        }

        $geoArea = $geocoder->geocodeToPolygon($this->locality->name);
        $this->locality->geodata = $geoArea;
        $this->locality->has_locality_data = true;
        $this->locality->save();
    }
}

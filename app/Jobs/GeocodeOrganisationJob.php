<?php

namespace App\Jobs;

use App\Models\Organisation;
use App\Services\LocationService\Geocode\ILocationGeocode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeocodeOrganisationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Organisation $organisation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ILocationGeocode $geocoder)
    {
        if (empty($this->organisation->postcode)) {
            return;
        }
        
        $geocode = $geocoder->geocodeToPoint($this->organisation->postcode);
        $this->organisation->geodata = $geocode;
        $this->organisation->save();
    }
}

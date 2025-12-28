<?php

namespace App\Services\Omnet;

use App\Models\Organisation;
use App\Models\Service;

class OrganisationServiceSync
{

    public $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    public function syncServices()
    {
        // Get all services
        $services = Service::all();

        // Explode the services string into an array
        $serviceCodes = explode(',', $this->organisation->services);

        // Find the corresponding service records in the services table
        $services = Service::whereIn('code', $serviceCodes)->get();

        // Sync the found services to the organization using the pivot table
        $this->organisation->allservices()->sync($services->pluck('id')->toArray());
    }
}

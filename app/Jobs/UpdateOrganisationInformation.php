<?php

namespace App\Jobs;

use App\Models\Organisation;
use App\Models\Pest;
use App\Models\Postcode;
use App\Services\Omnet\OmnetApi;
use App\Services\Omnet\OrganisationPestSync;
use App\Services\Omnet\OrganisationPostcodeSync;
use App\Services\Omnet\OrganisationServiceSync;
use App\Services\Omnet\PopulateOrganisation;
use App\Services\Omnet\UpdateOrganisation;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrganisationInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // populate organisation
        $organisation = (new PopulateOrganisation($this->data))->createOrganisation();

        // organisation pest sync
        $pests = Pest::all();
        $organisation = (new OrganisationPestSync($organisation, $pests))->sync();

        // organisation postcode sync
        $searchAreas = $this->data['SearchAreas'] ?? [];
        //$postcodes = Postcode::all(['title'])->pluck('title')->toArray();

        $organisation = (new OrganisationPostcodeSync($organisation, [], $searchAreas))->syncSearchAreas();

        // organisation services sync
        $services = (new OrganisationServiceSync($organisation))->syncServices();

        // get bpca info
        //$bpcaInfo = OmnetApi::getControllerInfo($organisation->external_id);

//        $features = [
//            'features' => $bpcaInfo['featuresField'] ?? null,
//            'description' => $bpcaInfo['descriptionField'] ?? null,
//            'contact_hours' => $bpcaInfo['contactHoursField'] ?? null
//        ];

        // update organisation with bpca info
        //(new UpdateOrganisation($organisation))->populate($features);

    }
}

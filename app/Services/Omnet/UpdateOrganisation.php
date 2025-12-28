<?php

namespace App\Services\Omnet;

use App\Models\Organisation;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Use bpca url to update organisation
 */

class UpdateOrganisation
{
    protected $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Populate with features
     */
    public function populate(array $features)
    {
        try {
            foreach ($features as $key => $feature) {
                $this->organisation->{$key} = $feature;
            }

            $this->organisation->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}

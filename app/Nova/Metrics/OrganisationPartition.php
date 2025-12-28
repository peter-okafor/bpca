<?php

namespace App\Nova\Metrics;

use App\Models\Organisation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class OrganisationPartition extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Organisation::class, 'premises_type')->label(fn ($value) => match ($value) {
            'Residential,Commercial' => 'Residential',
            'Commercial,Residential' => 'Commercial',
            'Residential,Commercial,Commercial,Residential' => 'Both',
            null => 'None',
            default => ucfirst($value)
        });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'organisation-partition';
    }

    public function name()
    {
        return 'Organisations';
    }
}

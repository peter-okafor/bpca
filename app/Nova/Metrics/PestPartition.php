<?php

namespace App\Nova\Metrics;

use App\Models\Pest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class PestPartition extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Pest::class, 'pest_environment')->label(fn ($value) => match ($value) {
            1 => 'Inside',
            2 => 'Inside/Outside',
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
        return 'pest-partition';
    }

    public function name()
    {
        return 'Pests';
    }
}

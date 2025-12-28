<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use App\Jobs\CalculateGeoAreaJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class CalculateGeodata extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     *
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        foreach ($models as $locality){
            CalculateGeoAreaJob::dispatch($locality);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}

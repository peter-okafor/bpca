<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Alexwenzel\AjaxSelect\AjaxSelect;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sloveniangooner\SearchableSelect\SearchableSelect;

class MoveLocalities extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->parent_locality_id = $fields->locality;
            $model->save();
//            ray($model);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Search', 'q'),
            AjaxSelect::make('Locality')
                ->get('/api/localities?q={q}')
                ->parent('q')
        ];
    }
}

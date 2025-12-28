<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;

class Service extends Resource
{
    /**
     * The group the resource belongs to.
     * @var string
     */
    public static $group = 'Pests';

    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Service::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'name', 'code'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->hide(),
            Text::make('Name')->sortable(),
            Text::make('Code')
        ];
    }

    public function fieldsForCreate(NovaRequest $request): array
    {
        return [
            Text::make('Name'),
            Text::make('Code')
        ];
    }

    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Text::make('Code')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }

}

<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class PestType extends Resource
{
    /**
     * The group the resource belongs to.
     *
     * @var string
     */
    public static $group = 'Pests';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PestType::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'slug',
        'type'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->hide(),
            Text::make('Type')->sortable(),
            Text::make('Slug'),
            Number::make('Pest Count', 'count')
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Type'),
            Text::make('Slug'),
            HasMany::make('Pests')
        ];
    }

    public function fieldsForCreate(NovaRequest $request): array
    {
        return [
            Text::make('Type'),
            Slug::make('Slug')->from('Type')->separator('_')
        ];
    }

    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            Text::make('Type'),
            Slug::make('Slug')->from('Type')->separator('_')
        ];
    }
    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

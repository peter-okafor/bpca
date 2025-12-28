<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaMapField\Fields\MapPolygonField;

class Postcode extends Resource
{
    /**
     * The group the resource belongs to.
     *
     * @var string
     */
    public static $group = 'Location Data';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Postcode::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
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
            ID::make()->sortable(),
            Text::make('Postcode', 'title'),
            MapPolygonField::make('geodata'),
        ];
    }


    public function fieldsForIndex(NovaRequest $request): array
    {
        return [
            ID::make()->hide(),
            Text::make('Postcode', 'title')->sortable()
        ];
    }

    public function fieldsForCreate(NovaRequest $request): array
    {
        return [
            Text::make('Postcode', 'title')
        ];
    }

    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Postcode', 'title'),
            MapPolygonField::make('geodata'),
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make(),
            Text::make('Postcode', 'title'),
            MapPolygonField::make('geodata'),
            // HasMany::make('Localities', Locality::class)
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

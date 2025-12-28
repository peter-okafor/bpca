<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Pest extends Resource
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
    public static $model = \App\Models\Pest::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'code'
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

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:pests,name')
                ->updateRules('unique:pests,name,{{resourceId}}'),

            Text::make('Code')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:pests,code')
                ->updateRules('unique:pests,code,{{resourceId}}'),

            Trix::make('Description')
                ->alwaysShow()
                ->rules('required'),

            Text::make('Services', function () {
                return $this->services->pluck('name')->join(', ');
            })->sortable(),

            //BelongsTo::make('Pest Type', PestType::class),
            Select::make('Pest Environment'),

            BelongsToMany::make('Services'),
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

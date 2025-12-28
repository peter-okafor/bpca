<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Http\Requests\NovaRequest;

class Organisation extends Resource
{
    /**
     * The group the resource belongs to.
     *
     * @var string
     */
    public static $group = 'Admin';
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Organisation::class;

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
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:organisations,name')
                ->updateRules('unique:organisations,name,{{resourceId}}'),

            Text::make('Premises Type')
                ->sortable()
                ->rules('required', 'max:255'),

            Image::make('Logo URL', 'logo_url'),

            Text::make('Address 1', 'address_1')
                ->sortable(),

            Text::make('Address 2', 'address_2')
                ->sortable(),

            Text::make('Town')
                ->sortable(),

            Email::make('Email')
                ->sortable(),

            Text::make('Telephone')
                ->sortable(),

            Text::make('Mobile')
                ->sortable(),
            
            Text::make('Accreditation Year')
                ->sortable(),

            Text::make('Services', function () {
                return $this->allservices->pluck('name')->join(', ');
            })->sortable(),

            BelongsToMany::make('Services', 'allservices', Service::class),
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

    /**
     * Get the menu that should represent the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\Menu\MenuItem
     */
    public function menu(Request $request)
    {
        return parent::menu($request)
            ->name('Members');
    }
}

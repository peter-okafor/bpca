<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use App\Enums\LocalityTypeEnum;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaMapField\Fields\MapPointField;
use Mostafaznv\NovaMapField\Fields\MapPolygonField;

class Town extends LocalityBase
{
    public static $displayInNavigation = true;

    public function fieldsForIndex(NovaRequest $request): array
    {
        return [
            Text::make('Name')->sortable(),
            BelongsTo::make('County', 'parentLocality', County::class),
            Boolean::make('Has Data', 'has_locality_data'),
            Text::make('Coords', 'latlng'),
            BelongsTo::make('Parent Locality', 'parentLocality', LocalityBase::class)
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Trix::make('Description'),
            Boolean::make('Has Data', 'has_locality_data'),
            Text::make('Coords', 'latlng'),
            MapPointField::make('latlng'),
            MapPolygonField::make('geodata'),

            HasMany::make('Postcodes', 'postcodes', Postcode::class)
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

    /**
     * Build an "index" query for the given resource.
     *
     * @param  NovaRequest  $request
     * @param  Builder  $query
     *
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query->whereType(LocalityTypeEnum::Town())->orderBy('name', 'asc');
    }

}

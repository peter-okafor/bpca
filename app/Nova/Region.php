<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use App\Enums\LocalityTypeEnum;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Actions\MoveLocalities;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use YieldStudio\NovaGooglePolygon\GooglePolygon;
use Mostafaznv\NovaMapField\Fields\MapPointField;
use Mostafaznv\NovaMapField\Fields\MapPolygonField;

class Region extends LocalityBase
{
    public static $displayInNavigation = true;

    public function fieldsForIndex(NovaRequest $request): array
    {
        return [
            Text::make('Name')->sortable(),
            BelongsTo::make('Country', 'parentLocality', Country::class),
            Boolean::make('Has Data', 'has_locality_data'),
            Text::make('Coords', 'latlng')
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Text::make('Description'),
            BelongsTo::make('Country', 'parentLocality', Country::class),
            Boolean::make('Has Data', 'has_locality_data'),
            Text::make('Coords', 'latlng'),
            MapPointField::make('latlng'),
            MapPolygonField::make('geodata'),

            HasMany::make('Counties', 'subLocalities', County::class),
        ];
    }

    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Trix::make('Description'),
            MapPointField::make('latlng'),
            MapPolygonField::make('geodata'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function cards(NovaRequest $request)
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
    public function filters(NovaRequest $request)
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
    public function lenses(NovaRequest $request)
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
        return [
            MoveLocalities::make()
        ];
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
        return $query->whereType(LocalityTypeEnum::Region())->orderByDesc('name');
    }

}

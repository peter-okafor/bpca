<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use App\Enums\LocalityTypeEnum;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Actions\MoveLocalities;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaMapField\Fields\MapPointField;
use Mostafaznv\NovaMapField\Fields\MapPolygonField;

class Country extends LocalityBase
{
    public static $displayInNavigation = true;

    public function fieldsForIndex(NovaRequest $request): array
    {
        return [
            Text::make('Name')->sortable(),
            Boolean::make('Has Geodata', 'has_locality_data'),
            MapPointField::make('Location', 'latlng'),
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make(),
            Text::make('Name'),
            Trix::make('Description'),
            Boolean::make('Has Geodata', 'has_locality_data'),
            // Text::make('Postcodes', function () {
            //     return implode(',', $this->all_postcodes->pluck('title')->all());
            // }),
            MapPointField::make('Location', 'latlng')->hideDetailButton(false),
            MapPolygonField::make('Area', 'geodata')->readonly(true)->hideDetailButton(false),
            HasMany::make('Regions', 'subLocalities', Region::class),
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
        return $query->whereType(LocalityTypeEnum::Country())->orderByDesc('name');
    }

}

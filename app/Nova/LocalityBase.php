<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use App\Enums\LocalityTypeEnum;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaMapField\Fields\MapPointField;
use Mostafaznv\NovaMapField\Fields\MapPolygonField;
use InteractionDesignFoundation\NovaHtmlCodeField\HtmlCode;

class LocalityBase extends Resource
{
    public static $displayInNavigation = false;
    /**
     * The group the resource belongs to.
     * @var string
     */
    public static $group = 'Location Data';

    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Locality::class;

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
        'name',
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
            Text::make('Name'),
            Trix::make('Description'),
            //BelongsTo::make('Parent', 'parentLocality', LocalityBase::class),
            Select::make('Type', 'type')->options(LocalityTypeEnum::asSelectArray()),
            Boolean::make('Has Geodata', 'has_locality_data'),
            MapPointField::make('Location', 'latlng'),
            MapPolygonField::make('Area', 'geodata')->readonly(true)
        ];
    }

    public function fieldsForIndex(NovaRequest $request): array
    {
        return [
            Text::make('Name')->sortable(),
            Boolean::make('Has Geodata', 'has_locality_data'),

            MapPointField::make('Location', 'latlng'),
            MapPolygonField::make('Area', 'geodata')->readonly(true),
            BelongsTo::make('Parent Locality', 'parentLocality', LocalityBase::class)
        ];
    }

    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Trix::make('Description'),
            Boolean::make('Has Geodata', 'has_locality_data'),

            MapPointField::make('Location', 'latlng')
                ->hideDetailButton(false)
                ->markerIcon(3),
            MapPolygonField::make('Area', 'geodata')->readonly(true)->hideDetailButton(false),
            // BelongsTo::make('Parent', 'parent_locality_id', )
            // BelongsTo::make('Parent Locality', 'parent_locality_id', Locality::class),
            HasMany::make('Sub Localities', 'subLocalities', LocalityBase::class),
            HasMany::make('Postcodes', 'postcodes', Postcode::class)
        ];
    }

}

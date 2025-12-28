<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use InteractionDesignFoundation\NovaHtmlCodeField\HtmlCode;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Trix;


class BlogPost extends Resource
{
    /**
     * The group the resource belongs to.
     *
     * @var string
     */
    public static $group = 'Blog';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BlogPost::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'slug',
        'title',
        'subtitle',
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
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:blog_posts,title'),

            Text::make('Subtitle')
                ->rules('required', 'max:255'),

            Slug::make('Slug')->from('Title')->creationRules('unique:blog_posts,slug')->rules('required'),

            BelongsTo::make('Blog Category', 'category'),

            BelongsTo::make('Author', 'user', User::class),

            BelongsToMany::make('Blog Image', 'images')->display(function ($blogImage) {
                return $blogImage->alt;
            }),

            // HtmlCode::make('Content')
            //     ->rules('required'),

            Trix::make('Content')->rules('required'),
            HasMany::make('Blog Comments')
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

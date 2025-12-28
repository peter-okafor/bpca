<?php

namespace App\Providers;

use App\Nova\Town;
use App\Nova\Pest;
use App\Nova\User;
use App\Nova\Region;
use App\Nova\County;
use App\Nova\Country;
use App\Nova\Service;
use Laravel\Nova\Nova;
use App\Nova\PestType;
use App\Nova\Postcode;
use App\Nova\BlogPost;
use App\Nova\BlogImage;
use App\Nova\Organisation;
use App\Nova\BlogCategory;
use Illuminate\Http\Request;
use App\Nova\Dashboards\Main;
use App\Nova\ComponentContent;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use App\Nova\FooterComponentContent;
use App\Nova\ReviewComponentContent;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Nova::withoutThemeSwitcher();

        Nova::remoteStyle('custom', public_path('css/custom.css'));

        Nova::withoutNotificationCenter();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Localities', [
                    MenuItem::resource(Country::class),
                    MenuItem::resource(Region::class),
                    MenuItem::resource(County::class),
                    MenuItem::resource(Town::class),
                    MenuItem::resource(Postcode::class),
                    MenuItem::resource(Organisation::class),
                ])->icon('map'),

                MenuSection::make('Pests', [
                    MenuItem::resource(Pest::class),
                    MenuItem::resource(Service::class),
                    MenuItem::resource(PestType::class),
                ])->icon('shield-exclamation'),

                MenuSection::make('Content', [
                    MenuItem::resource(ComponentContent::class),
                    MenuItem::resource(FooterComponentContent::class),
                    MenuItem::resource(ReviewComponentContent::class),
                    MenuItem::resource(BlogPost::class),
                    MenuItem::resource(BlogCategory::class),
                    MenuItem::resource(BlogImage::class),
                ])->icon('document-text')->collapsable(),

                MenuSection::make('Admin', [
                    MenuItem::resource(User::class),
                ])->icon('document-text')->collapsable(),
            ];
        });

        Nova::footer(function() {
            return 'BPCA - pests.org';
        });
    }

    /**
     * Register the Nova routes.
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     * This gate determines who can access Nova in non-local environments.
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            // return in_array($user->email, [
            //     'admin@pests.org'
            // ]);
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }
}

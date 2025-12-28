<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Localities;
use App\Nova\Metrics\OrganisationPartition;
use App\Nova\Metrics\PestPartition;
use App\Nova\Metrics\PostcodePartition;
use App\Nova\Metrics\SearchCountPartition;
use App\Nova\Metrics\TopPestSearches;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            SearchCountPartition::make(),
            TopPestSearches::make(),
            Localities::make(),
            OrganisationPartition::make(),
            PestPartition::make(),
            PostcodePartition::make(),
        ];
    }

    public function name()
    {
        return 'Dashboard';
    }
}

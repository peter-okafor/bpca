<?php
namespace App\Services\AnalyticsService;

use Illuminate\Support\Collection;

interface IAnalytics
{
    public static function logSearch($user_id, $pest, $postcode): int;

    public static function logView(int $user_id, Collection $providers): void;
}
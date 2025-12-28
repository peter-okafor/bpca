<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class VaporUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->gate();
    }

    /**
     * Register the Vapor UI gate.
     *
     * This gate determines who can access Vapor UI in non-local environments.
     */
    protected function gate(): void
    {
        // Gate::define('viewVaporUI', function (User $user = null) {
        //     return in_array(optional($user)->email, [
        //         // 
        //     ]);
        // });

        Gate::define('viewVaporUI', function ($user = null) {
            return Str::contains(request()->url(), 'precious');
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}

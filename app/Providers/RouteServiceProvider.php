<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}

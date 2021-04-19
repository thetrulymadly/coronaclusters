<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        if (config('app.admin') === false) {
            foreach (config('corona.locales') as $locale) {
                $this->registerCoronaRoutes($locale);
            }
            $this->registerCoronaRoutes();
        }
//        elseif (config('app.name') === 'CoronaClusters - Admin') {
//            Route::middleware(['web'])
//                ->namespace('App\Admin\Http\Controllers')
//                ->prefix('')
//                ->group(base_path('routes/admin.php'));
//        }
    }

    /**
     * @param string $prefix
     */
    private function registerCoronaRoutes($prefix = '')
    {
        Route::middleware(['web', 'cache.headers:public;max_age=1800;etag'])
            ->namespace($this->namespace)
            ->prefix($prefix)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('Api\Http\Controllers')
            ->group(base_path('routes/api.php'));
    }
}

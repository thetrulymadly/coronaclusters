<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace App\Providers;

use Api\Services\CovidDataService;
use Api\Services\CovidDataServiceImpl;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(CovidDataService::class, CovidDataServiceImpl::class);
    }
}

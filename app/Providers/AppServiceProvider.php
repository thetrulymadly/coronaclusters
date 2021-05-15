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
use Api\Services\Otp\OtpVerificationService;
use Api\Services\Otp\V1\OtpVerificationServiceImpl;
use App\Services\Plasma\PlasmaService;
use App\Services\Plasma\PlasmaServiceImpl;
use Illuminate\Http\Resources\Json\JsonResource;
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
        JsonResource::withoutWrapping();
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
        $this->app->singleton(OtpVerificationService::class, OtpVerificationServiceImpl::class);
        $this->app->singleton(PlasmaService::class, PlasmaServiceImpl::class);
    }
}

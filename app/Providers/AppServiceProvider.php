<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // config(['app.locale' => 'ms']);
        Carbon::setLocale('ms');
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }
}

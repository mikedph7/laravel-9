<?php

namespace App\Providers;

use App\Helpers\RedisHelper;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RedisHelperInterface::class, RedisHelper::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

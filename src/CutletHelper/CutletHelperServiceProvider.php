<?php

namespace Va\CutletHelper;

use Illuminate\Support\ServiceProvider;
use Va\CutletHelper\Facades\CutletHelper;
use Va\CutletHelper\Helpers\Helper;

class CutletHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        CutletHelper::shouldProxyTo(Helper::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace Va\CutletHelper;

use Illuminate\Support\ServiceProvider;
use Va\CutletHelper\Facades\CategoryHelperFacade;
use Va\CutletHelper\Facades\CutletHelper;
use Va\CutletHelper\Helpers\CategoryHelper;
use Va\CutletHelper\Helpers\Helper;
use Va\CutletHelper\View\Components\CategoryCheckboxes;
use Va\CutletHelper\View\Components\CategoryOptions;
use Va\CutletHelper\View\Components\CategorySelect;

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
        CategoryHelperFacade::shouldProxyTo(CategoryHelper::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require_once(__DIR__ . '/Validations/helperValidation.php');
        $this->loadViewsFrom(__DIR__ . '/views','cutlet_helper');
        $this->loadViewComponentsAs('', [
            CategoryCheckboxes::class,
            CategoryOptions::class
        ]);
        $this->publishes([
            __DIR__ . '/../config/cutlet-helper.php' => config_path('cutlet-helper.php'),
        ], 'cutlet-helper');
    }
}

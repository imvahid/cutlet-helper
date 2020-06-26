<?php

namespace Va\CutletHelper;

use Illuminate\Support\ServiceProvider;
use Va\CutletHelper\Facades\CutletHelper;
use Va\CutletHelper\Helpers\Helper;
use Va\CutletHelper\Validations\HelperValidation;

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
        $this->app['validator']->resolver(function($translator, $data, $rules) {
            return new HelperValidation($translator, $data, $rules, $this->messages());
        });

        $this->publishes([
            __DIR__ . '/../config/cutlet-helper.php' => config_path('cutlet-helper.php'),
        ], 'cutlet-helper');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function messages()
    {
        return [
            'national_code' => config('cutlet-helper.national_code'),
            'iban' => config('cutlet-helper.iban'),
            'debit_card' => config('cutlet-helper.debit_card'),
            'postal_code' => config('cutlet-helper.postal_code'),
            'shenase_meli' => config('cutlet-helper.shenase_meli'),
        ];
    }
}

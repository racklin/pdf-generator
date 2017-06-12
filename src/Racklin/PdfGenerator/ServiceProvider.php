<?php

namespace Racklin\PdfGenerator;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class PdfGeneratorServiceProvider
 *
 * @package Racklin\PdfGenerator
 */
class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pdfgen', function () {
            return new PdfGenerator();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

<?php

namespace NodonHq\FilamentArgentina;

use Illuminate\Support\ServiceProvider;

class FilamentArgentinaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-argentina');

        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/filament-argentina'),
        ], 'filament-argentina-translations');
    }
}

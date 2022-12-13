<?php

namespace OnkaarGujarr\Library;

use Illuminate\Support\ServiceProvider;
use OnkaarGujarr\Library\Repository\Library\LibraryInterface;
use OnkaarGujarr\Library\Repository\Library\LibraryRepository;
use OnkaarGujarr\Library\Repository\UserReadHistory\UserReadHistoryInterface;
use OnkaarGujarr\Library\Repository\UserReadHistory\UserReadHistoryRepository;
use OnkaarGujarr\Library\Services\Library\LibraryService;
use OnkaarGujarr\Library\Provider\EventServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;


class LibraryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'library');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'library');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');    

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('library.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/library'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/library'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/library'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'library');

        // Register the main class to use with the facade
        $this->app->singleton('library', function () {
            return new Library();
        });

        $this->app->bind(LibraryInterface::class,LibraryRepository::class);
        $this->app->bind(UserReadHistoryInterface::class,UserReadHistoryRepository::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
}

<?php

namespace ShinHyungJune\SocialLogin;

use Illuminate\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'social-login');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'social-login');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('social-login.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/social-login'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/'),
            ], 'lang');

            $this->publishes([
                __DIR__.'/../database/migrations/create_users_table.php.stub' =>
                database_path("migrations/".date("Y_m_d_His", time())."_create_users_table.php"),
            ], 'migrations');

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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'social-login');

        // Register the main class to use with the facade
        $this->app->singleton('social-login', function () {
            return new SocialLogin;
        });
    }
}

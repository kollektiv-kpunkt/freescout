<?php

namespace Modules\TelegramBot\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\TelegramBot\Helpers\TelegramBotHelper;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerConfig();
        $this->hooks();
    }

    /**
     * Module hooks.
     */
    public function hooks()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('telegrambot.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'telegrambot'
        );
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

    /** Register Command Class
     * @return void
     */
    public function registerCommands()
    {
        $this->commands([
            \Modules\TelegramBot\Console\TestCommand::class
        ]);
    }
}

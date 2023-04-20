<?php

namespace Modules\TelegramBot\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\TelegramBot\Helpers\TelegramBotHelper;
use App\Conversation;
use Eventy;

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
        Eventy::addAction("conversation.created_by_customer", [$this, "conversationCreated"], 10, 1);
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

    /**
     * Send Telegrambot Message when new conversation is created.
     */
    public function conversationCreated(Conversation $conversation)
    {
        $telegramBotHelper = new TelegramBotHelper();
        $appurl = config('app.url');
        $messageBody = <<<EOD
        Hey y'all\n
        <b>{$conversation->customer->first_name} {$conversation->customer->last_name}</b> contacted you\n
        <b>Subject:</b> «{$conversation->subject}»\n
        \n
        EOD;
        if (!$conversation->user_id) {
            $messageBody .= "This conversation is not assigned to anyone yet. <b>Please make sure to do that ASAP.</b> You can do that by sending /assign followed by the first part of the person's e-mail address. (example: /assign timothy)\n \n";
        }
        $messageBody .= "You can view the conversation here: {$appurl}/conversations/{$conversation->id}\n";
        $messageBody .= "So long 👋";
        $telegramBotHelper->sendMessage($messageBody);
    }
}

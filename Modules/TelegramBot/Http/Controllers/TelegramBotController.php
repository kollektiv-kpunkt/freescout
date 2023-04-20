<?php

namespace Modules\TelegramBot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Longman\TelegramBot\Telegram;
use Modules\TelegramBot\Helpers\TelegramBotHelper;

class TelegramBotController extends Controller
{
    public $bot = "";


    /**
     * Constructor on call
     */

     public function __construct()
    {
        $this->bot = new TelegramBotHelper();
        $this->bot->addCommandsPaths([__DIR__ . '/../../Commands']);
    }


    /**
     * Set the bot webhook.
     */

     public function set()
    {
        try {
            $result = $this->bot->setWebhook(config("app.url") . config("telegrambot.webhook"));
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (\Longman\TelegramBot\Exception\TelegramException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Handle the webhook request.
     */
    public function webhook()
    {

        $this->bot->handle();
    }
}

<?php

namespace Modules\TelegramBot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Longman\TelegramBot\Telegram;
use Modules\TelegramBot\Helpers\TelegramBotHelper;

class TelegramBotController extends Controller
{
    /**
     * Set the bot webhook.
     */
    public function set()
    {
        try {
            $telegram = new TelegramBotHelper();
            $result = $telegram->setWebhook(config("app.url") . config("telegrambot.webhook"));
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (\Longman\TelegramBot\Exception\TelegramException $e) {
            echo $e->getMessage();
        }
    }
}

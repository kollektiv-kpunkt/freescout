<?php

namespace Modules\TelegramBot\Helpers;

use \Longman\TelegramBot\Telegram;
use \Longman\TelegramBot\Request;

class TelegramBotHelper extends Telegram
{
    /**
     * Set bot config on construct.
     */
    public function __construct()
    {
        parent::__construct(
            config('telegrambot.bot.token'),
            config('telegrambot.bot.username')
        );


    }

    /**
     * Send message to chat.
     */
    public function sendMessage($message)
    {
        $result = Request::sendMessage([
            'chat_id' => config('telegrambot.bot.chat_id'),
            'text' => $message,
            "parse_mode" => "HTML",
        ]);

        return $result;
    }
}

<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use App\Conversation;
use App\User;
use Modules\TelegramBot\Helpers\TelegramBotHelper;
use App\Jobs\SendNotificationToUsers;

class AssignCommand extends UserCommand
{
    protected $name = 'assign';
    protected $description = 'Assign the latest conversation to a user';
    protected $usage = '/assign shortname';
    protected $version = '1.0.0';

    public function execute(): \Longman\TelegramBot\Entities\ServerResponse
    {
        $message = $this->getMessage();

        $conversation = Conversation::where("status",1)->where('user_id', null)->orderBy('created_at', 'desc')->get();

        if ($conversation->count() == 0) {
            $text = "There are no conversations to assign.";
        } else if ($conversation->count() > 1) {
            $text = "There are more than one conversation to assign. Please assign them one by one.";
        } else {
            $conversation = $conversation->first();
            $shortname = $message->getText(true);
            $user = User::where('email', 'like', $shortname . '%')->first();
            if ($user) {
                $conversation->changeUser($user->id, $user, true);
                $text = "Conversation assigned to {$user->first_name} {$user->last_name}";

                $notification = \App\Jobs\SendNotificationToUsers::dispatch($user, $conversation, $conversation->threads)
                    ->delay(0)
                    ->onQueue('emails');
            } else {
                $text = "User not found.";
            }
        }

        $bot = new TelegramBotHelper();
        return $bot->sendMessage($text);
    }
}

<?php
namespace Modules\TelegramBot\Console;

use Illuminate\Console\Command;
use Modules\TelegramBot\Helpers\TelegramBotHelper;

class TestCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'telegrambot:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $conversation = \App\Conversation::where("status",1)->where('user_id', null)->orderBy('created_at', 'desc')->get();

        if ($conversation->count() == 0) {
            $text = "There are no conversations to assign.";
        } else if ($conversation->count() > 1) {
            $text = "There are more than one conversation to assign. Please assign them one by one.";
        } else {
            $conversation = $conversation->first();
            $shortname = $message->getText(true);
            $user = User::where('email', 'like', $shortname . '%')->first();
            if ($user) {
                $conversation->changeUser($user->id, null);
                $text = "Conversation assigned to {$user->first_name} {$user->last_name}";
            } else {
                $text = "User not found.";
            }
        }

        dd($text, $conversation);
    }
}

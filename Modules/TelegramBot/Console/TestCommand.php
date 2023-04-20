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

        $bot = new TelegramBotHelper();
        $messageBody = <<<EOD
        Hey y'all\n
        <b>[CUSTOMERNAME]</b> contacted you\n
        <b>Subject:</b> «[SUBJECT]»\n
        \n
        EOD;
        if (true) {
            $messageBody .= "This conversation is not assigned to anyone yet. <b>Please make sure to do that ASAP.</b>\n \n";
        }
        $messageBody .= "You can view the conversation here: https://google.com\n";
        $messageBody .= "So long 👋";
        $bot->sendMessage($messageBody);
    }
}

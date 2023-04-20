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
        $test = $bot->sendMessage('Test message');
        dd($test);
    }
}

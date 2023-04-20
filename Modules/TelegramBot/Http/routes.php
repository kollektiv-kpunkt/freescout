<?php
use App\Misc\Helper;

Route::group(['middleware' => 'web', 'prefix' => "telegrambot", 'namespace' => 'Modules\TelegramBot\Http\Controllers'], function()
{
    Route::get('/set', 'TelegramBotController@set');
    Route::post('/webhook', 'TelegramBotController@webhook');
    Route::get('/getWebhookInfo', 'TelegramBotController@getWebhookInfo');
});

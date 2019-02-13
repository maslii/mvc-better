<?php

namespace App\Controllers\Admin;

class TelegramController extends \Core\AdminController
{
    public function getUpdates()
    {
        $telegram = new \Core\Telegram();

        $response = $telegram->request(
            'getUpdates',
            'POST',
            \APP\Config::$telegram['token']
        );

        echo $response;
    }
}
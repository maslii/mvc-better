<?php

namespace App\Controllers;

class TelegramController extends \Core\Controller
{
    public function inform()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Core\Exceptions\MethodNotAllowedException();
        }

        $telegram = new \Core\Telegram();
        $token = \App\Config::$telegram['token'];
        $chatId = \App\Config::$telegram['chat_id'];

        if (!isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['subject'])) {
            header('Location: /');
            exit;
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $subject = trim($_POST['subject']);

        if (
            empty($name) ||
            empty($email) ||
            empty($phone) ||
            empty($subject)
        ) {
            header('Location: /');
            exit;
        }

        $name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $phone = filter_var($phone, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $subject = filter_var($subject, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (
            $name === false ||
            $email === false ||
            $phone === false ||
            $subject === false
        ) {
            header('Location: /');
            exit;
        }

        $message = 'Ім\'я: _' . $name . '_' . PHP_EOL . PHP_EOL;
        $message .= 'Телефон: *' . $phone . '*' . PHP_EOL;
        $message .= 'Пошта: *' . $email . '*' . PHP_EOL . PHP_EOL;
        $message .= '*' . $subject . '*';

        $result = $telegram->request(
            'SendMessage',
            'POST',
            $token,
            [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]
        );

        /*
        if (!$result) {

        }
        */

        header('Location: /');
        exit;
    }
}
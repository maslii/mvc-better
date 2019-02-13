<?php

namespace Core;

class Telegram
{
    public function request(
        string $methodApi,
        string $methodHttp,
        string $token,
        array $params = []
    )
    {
        $postData = [];

        foreach ($params as $paramKey => $paramValue) {
            $postData[$paramKey] = $paramValue;
        }

        $postData = http_build_query($postData);

        $context = stream_context_create(
            [
                'http' => [
                    'method' => $methodHttp,
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postData
                ]
            ]
        );

        $response = @file_get_contents(
            'https://api.telegram.org/bot' . $token . '/' . $methodApi . '?',
            false,
            $context
        );

        return $response;
    }
}
<?php

namespace app\components;

use GuzzleHttp\Client;

class TelegramAPI
{
    const host      = 'https://api.telegram.org';
    const token     = 'bot1029388919:AAHUhlKGOGB32wmPkmJyPEBIybWpOHhX6U8';

    public static function buildUrl($methodName)
    {
        return '/' . self::token . '/' . $methodName;
    }

    public static function sendMessage(string $chat_id, string $message)
    {
        $client = new Client(['base_uri' => self::host]);

        try {
            return $client->request('post', self::buildUrl('sendMessage'), [
                'json' => [
                    'chat_id' => $chat_id,
                    'text' => $message
                ]
            ]);
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }
}
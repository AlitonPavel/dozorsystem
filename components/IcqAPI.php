<?php

namespace app\components;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class IcqAPI
{
    const host      = 'https://api.icq.net';
    const token     = '001.3880202800.1423390106:751115015';

    public static function buildUrl($methodName)
    {
        return '/' . self::token . '/' . $methodName;
    }

    public static function sendMessage(string $chat_id, string $message)
    {
        $client = new Client(['base_uri' => self::host]);

        try {
            return $client->request('get', '/bot/v1/messages/sendText', [
                RequestOptions::QUERY => [
                    'token'      => self::token,
                    'chatId'     => $chat_id,
                    'text'       => $message
                ]
            ]);
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }
}
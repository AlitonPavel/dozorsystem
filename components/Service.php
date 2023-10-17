<?php

namespace app\components;

class Service
{
    const PAGE_BUILD = 'Страница находится в стадии разработки';

    public static function message($msg)
    {
        return '<p class="service_mess">' . $msg . '</p>';
    }

    public static function pageBuild()
    {
        return self::message(self::PAGE_BUILD);
    }
}
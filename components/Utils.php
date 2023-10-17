<?php


namespace app\components;

class Utils
{
    const DEFAULT_DATE_FORMAT = 'd.m.Y H:i';
    const DEFAUL_DATESHORT_FORMAT = 'd.m.Y';
    const DEFAULT_DATE_FORMAT2 = 'Y-m-d H:i:s';
    const DEFAUL_DATESHORT_FORMAT2 = 'Y-m-d';
    const TIME_FORMAT = 'H:i';

    const patterns = [
        self::DEFAULT_DATE_FORMAT,
        self::DEFAUL_DATESHORT_FORMAT,
        self::DEFAULT_DATE_FORMAT2,
        self::DEFAUL_DATESHORT_FORMAT2
    ];

    public static function dateToFormat(?string $date, string $oldFormat, string $newFormat)
    {
        if (!isset($date)) return '';

        $d = date_create_from_format($oldFormat, $date);

        if ($d)
        {
            return date($newFormat, $d->getTimestamp());
        }

        return $date;
    }

    public static function dateFormat($date, $format = self::DEFAULT_DATE_FORMAT)
    {
        if (empty($date))
        {
            return '';
        }
        return date($format, strtotime($date));
    }

    public static function isDate(?string $date)
    {
        if (!isset($date)) return false;

        foreach (self::patterns as $pattern) {
            if (preg_match(self::createPattenFromFormat($pattern), $date)) {
                return $pattern;
            }
        }

        return false;
    }

    public static function isMoney(?string $money)
    {
        if (preg_match('/^\d+(\.\d{2})?$/', $money) || preg_match('/^\d+(\.\d{1})?$/', $money))
        {
            return true;
        }
        return false;
    }

    public static function isFormatDate(string $date, string $format)
    {
        $pattern = self::createPattenFromFormat($format);
        if (preg_match($pattern, $date)) {
            return true;
        } else {
            return false;
        }
    }

    public static function createPattenFromFormat($format)
    {
        $pattern = $format;
        $pattern = str_replace('d', '[\d]{2}', $pattern);
        $pattern = str_replace('m', '[\d]{2}', $pattern);
        $pattern = str_replace('Y', '[\d]{4}', $pattern);
        $pattern = str_replace('H', '[\d]{2}', $pattern);
        $pattern = str_replace('i', '[\d]{2}', $pattern);
        $pattern = str_replace('s', '[\d]{2}', $pattern);
        return "/^" . $pattern . "$/";
    }

    public static function getRange(int $from, int $to, int $step = 1)
    {
        $result = [];

        for ($i = $from; $i <= $to; $i += $step)
        {
            $result[] = $i;
        }
        return $result;
    }

    public static function toFormatDate(?string $date, string $format)
    {
        if (empty($date))
        {
            return '';
        }
        return self::dateToFormat($date, self::isDate($date), $format);
    }

    public static function date()
    {
        return strtotime(date(self::DEFAUL_DATESHORT_FORMAT2, time()));
    }

    public static function toFormatMoney($str)
    {
        return number_format($str, 2, '.', '');
    }

    public static function formatMoneyToBase(string $money)
    {
        return round($money*100, 0);
    }

    public static function formatBaseToFormatMoney(?string $money)
    {
        return self::toFormatMoney($money/100);
    }

    public static function stringToBoolean($string)
    {
        return (boolean)json_decode($string);
    }
}
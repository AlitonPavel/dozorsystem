<?php


namespace app\models;

use app\components\BaseActiveRecord;

class Region extends BaseActiveRecord
{
    public static function tableName()
    {
        return '{{regions}}';
    }
}
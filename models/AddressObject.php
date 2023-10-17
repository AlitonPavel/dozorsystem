<?php

namespace app\models;

use app\components\BaseActiveRecord;

class AddressObject extends BaseActiveRecord
{
    public static function tableName()
    {
        return '{{AddressObject}}';
    }
}
<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\models\Region;

class Street extends BaseActiveRecord
{
    public static function tableName()
    {
        return '{{streets}}';
    }

    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getFullName()
    {
        return trim($this->region->name) . ', ' . trim($this->name) . ' ' . trim($this->type) . '.';
    }
}
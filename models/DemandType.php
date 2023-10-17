<?php

namespace app\models;

use app\components\BaseActiveRecord;

class DemandType extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{demandtypes}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name'];
        $scenarios[self::SCENARIO_UPDATE] = ['name'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Тип заявки',
        ];
    }
}
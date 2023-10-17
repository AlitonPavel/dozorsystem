<?php

namespace app\models;

use app\components\BaseActiveRecord;

class DemandPrior extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{demandpriors}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'leadtime'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'leadtime'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Приоритет',
            'leadtime' => 'Дней на выполнение',
        ];
    }
}
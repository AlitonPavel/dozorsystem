<?php

namespace app\models;

use app\components\BaseActiveRecord;

class DemandComment extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{demandcomments}}';
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $columns = [
            'id',
            'date',
            'demand_id',
            'user_id',
            'comment',
        ];

        $scenarios[self::SCENARIO_CREATE] = $columns;
        $scenarios[self::SCENARIO_UPDATE] = $columns;
        return $scenarios;
    }

    public function rules() {
        return [
            [['comment'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'date' => 'Дата',
            'demand_id' => 'Заявка',
            'user_id' => 'Автор',
            'comment' => 'Комментарий',
        ];
    }
}

<?php

namespace app\models;

use app\components\BaseActiveRecord;

class Bank extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{banks}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $columns = [
            'name',
            'account',
            'bic',
            'inn',
            'kpp',
            'okpo',
            'ogrn',
            'okato',
            'date_create',
            'user_create',
            'date_change',
            'user_change',
            'deldate'
        ];

        $scenarios[self::SCENARIO_CREATE] = $columns;
        $scenarios[self::SCENARIO_UPDATE] = $columns;
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
            'name' => 'Наименование',
            'account' => 'К/счет',
            'bic' => 'БИК',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'okpo' => 'ОКПО',
            'ogrn' => 'ОГРН',
            'okato' => 'ОКАТО',
        ];
    }

    public function getRequisites()
    {
        return $this->name .
            (empty($this->account) ? '' : ', К/счет: ' . $this->account) .
            (empty($this->bic) ? '' : ', БИК: ' . $this->bic) .
            (empty($this->inn) ? '' : ', ИНН: ' . $this->inn) .
            (empty($this->kpp) ? '' : ', КПП: ' . $this->kpp) .
            (empty($this->okpo) ? '' : ', ОКПО: ' . $this->okpo) .
            (empty($this->ogrn) ? '' : ', ОГРН: ' . $this->ogrn) .
            (empty($this->okato) ? '' : ', ОКАТО: ' . $this->okato);
    }
}

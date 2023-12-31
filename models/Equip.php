<?php

namespace app\models;

use app\components\BaseActiveRecord;

class Equip extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    protected $fields = [
        'pricelow' => BaseActiveRecord::TYPE_MONEY,
        'pricehigh' => BaseActiveRecord::TYPE_MONEY,
    ];

    public static function tableName()
    {
        return '{{equips}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $columns = [
            'id',
            'name',
            'shortname',
            'model',
            'note',
            'unit_id',
            'pricelow',
            'pricehigh',
        ];

        $scenarios[self::SCENARIO_CREATE] = $columns;
        $scenarios[self::SCENARIO_UPDATE] = $columns;
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['shortname'], 'required'],
            [['name'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Полное наименование',
            'shortname' => 'Короткое наименование',
            'model' => 'Модель',
            'note' => 'Примечание',
            'unit_id' => 'Ед. изм.',
            'pricelow' => 'Себестоимость',
            'pricehigh' => 'Цена для клиента',
        ];
    }

    public static function loadEquipsFromArray(array $equips)
    {
        foreach ($equips as $equip)
        {
            $eq = self::find()
                ->andWhere(['name' => $equip['name']])
                ->one();

            if (!$eq)
            {
                $eq = new Equip();
                $eq->shortname = $equip['shortname'];
                $eq->model = $equip['model'];
            }

            $eq->pricelow = $equip['priceLow'];
            $eq->pricehigh = $equip['priceHigh'];
            $eq->note = $equip['description'];
            $eq->save();
        }
    }

    public function beforeValidate()
    {
        $this->name = $this->shortname . ' ' . $this->model;

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }
}

<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\Utils;

class CostCalc extends BaseActiveRecord
{
    const SCENARIO_CREATE               = 'insert';
    const SCENARIO_UPDATE               = 'update';
    const SCENARIO_RECALC               = 'recalc';
    const SCENARIO_UPDATE_DETAILS       = 'details';
    const SCENARIO_READY                = 'ready';
    const SCENARIO_UNREADY              = 'unready';

    protected $fields = [
        'date'                  => BaseActiveRecord::TYPE_DATE,
        'discount'              => BaseActiveRecord::TYPE_MONEY,
        'equiplowsum'           => BaseActiveRecord::TYPE_MONEY,
        'equiphighsum'          => BaseActiveRecord::TYPE_MONEY,
        'worklowsum'            => BaseActiveRecord::TYPE_MONEY,
        'workhighsum'           => BaseActiveRecord::TYPE_MONEY,
        'startlowsum'           => BaseActiveRecord::TYPE_MONEY,
        'starthighsum'          => BaseActiveRecord::TYPE_MONEY,
        'farelowsum'            => BaseActiveRecord::TYPE_MONEY,
        'farehighsum'           => BaseActiveRecord::TYPE_MONEY,
        'projectlowsum'         => BaseActiveRecord::TYPE_MONEY,
        'projecthighsum'        => BaseActiveRecord::TYPE_MONEY,
        'discount'              => BaseActiveRecord::TYPE_MONEY,
        'withoutdiscountsum'    => BaseActiveRecord::TYPE_MONEY,
        'lowsum'                => BaseActiveRecord::TYPE_MONEY,
        'highsum'               => BaseActiveRecord::TYPE_MONEY,
        'profitsum'             => BaseActiveRecord::TYPE_MONEY,
        'profitpercent'         => BaseActiveRecord::TYPE_MONEY,
        'dateready'             => BaseActiveRecord::TYPE_DATE,
    ];

    public static function tableName()
    {
        return '{{costcalcs}}';
    }

    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'object_id'])
            ->joinWith('street');
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Client::className(), ['id' => 'company_id']);
    }

    public function getPrior()
    {
        return $this->hasOne(DemandPrior::className(), ['id' => 'prior_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCostCalcEquips()
    {
        return $this->hasMany(CostCalcEquip::className(), ['calc_id' => 'id'])
            ->joinWith('equip');
    }

    public function getCostCalcWorks()
    {
        return $this->hasMany(CostCalcWork::className(), ['calc_id' => 'id']);

    }

    public function scenarios()
    {
        $attributeInsertUpdate = ['id', 'type_id', 'name', 'date', 'object_id', 'client_id', 'user_id', 'contactFIO', 'contact',
            'typepay', 'planpay', 'prior_id', 'company_id', 'note'];

        $attributes = ['equiplowsum', 'equiphighsum', 'worklowsum',
            'workhighsum', 'startlowsum', 'starthighsum', 'farelowsum', 'farehighsum', 'projectlowsum',
            'projecthighsum', 'discount', 'withoutdiscountsum', 'lowsum', 'highsum', 'dateaccept', 'profitsum',
            'profitpercent'
        ];

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $attributeInsertUpdate;
        $scenarios[self::SCENARIO_UPDATE] = $attributeInsertUpdate;
        $scenarios[self::SCENARIO_RECALC] = $attributes;
        $scenarios[self::SCENARIO_UPDATE_DETAILS] = $attributes;
        $scenarios[self::SCENARIO_READY] = ['dateready'];
        $scenarios[self::SCENARIO_UNREADY] = ['dateready'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['dateready'], 'readyValidation', 'on' => [self::SCENARIO_READY], 'skipOnEmpty'=> false],
            [['dateready'], 'unreadyValidation', 'on' => [self::SCENARIO_UNREADY], 'skipOnEmpty'=> false]
        ];
    }

    public function unreadyValidation($attribute, $params)
    {
        if ($this->user_id != \Yii::$app->user->id)
        {
            $this->addError($attribute, 'Снять готовность '  . $this->getTypeName() . ' может только составитель сметы');
        }
    }

    public function readyValidation($attribute, $params)
    {
        if ($this->user_id != \Yii::$app->user->id)
        {
            $this->addError($attribute, 'Поставить готовность '  . $this->getTypeName() . ' может только составитель сметы');
        }
    }

    public function ready()
    {
        $this->setScenario(self::SCENARIO_READY);
        $this->dateready = date('d.m.Y H:i');
        if ($this->save())
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function UnReady()
    {
        $this->setScenario(self::SCENARIO_UNREADY);
        $this->dateready = null;
        if ($this->save())
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function attributeLabels()
    {
        return [
            'id'                    => 'Номер',
            'type_id'               => 'Тип',
            'name'                  => 'Наименование',
            'date'                  => 'Дата',
            'object_id'             => 'Адрес объекта',
            'client_id'             => 'Заказчик',
            'user_id'               => 'Составитель',
            'contactFIO'            => 'Контактное лицо',
            'contact'               => 'Телефон',
            'typepay'               => 'Форма оплаты',
            'planpay'               => 'Рассрочка',
            'prior_id'              => 'Приоритет',
            'company_id'            => 'Юр. лицо исполнителя',
            'equiplowsum'           => 'Себест. оборудования',
            'equiphighsum'          => 'Стоимость оборудования',
            'worklowsum'            => 'Себест. работ',
            'workhighsum'           => 'Стоимость работ',
            'startlowsum'           => 'Себест. пуско-наладки',
            'starthighsum'          => 'Стоимость пуско-наладки',
            'farelowsum'            => 'Себест. трансп. расходов',
            'farehighsum'           => 'Стоимость трансп. расходов',
            'projectlowsum'         => 'Себест. документации',
            'projecthighsum'        => 'Стоимость документации',
            'discount'              => 'Скидка',
            'withoutdiscountsum'    => 'Стоимость без скидки',
            'lowsum'                => 'Себестоимость',
            'highsum'               => 'Стоимость',
            'note'                  => 'Примечание',
            'dateaccept'            => 'Дата подтверждения',
            'profitsum'             => 'Марж. прибыль сумма',
            'profitpercent'         => 'Марж. прибыль %',
            'dateready'             => 'Дата готовности',
        ];
    }

    public function getTypeName()
    {
        switch ($this->type_id) {
            case 0:
                return 'Коммерческое предложение';
                break;
            case 1:
                return 'Смета';
                break;
        }
    }

    private function recalcEquips()
    {
        $equips = CostCalcEquip::find()
            ->andWhere('deldate is null')
            ->andFilterWhere(['=', 'calc_id', $this->id])
            ->all();

        $equiplowsum    = 0;
        $equiphighsum   = 0;

        foreach ($equips as $equip)
        {
            $equiplowsum    += (int)$equip->pricelowsum;
            $equiphighsum   += (int)$equip->pricehighsum;
        }

        $this->equiplowsum  = Utils::formatBaseToFormatMoney($equiplowsum);
        $this->equiphighsum = Utils::formatBaseToFormatMoney($equiphighsum);

        return [$this->equiplowsum, $this->equiphighsum];
    }

    private function recalcWorks()
    {
        $equips = CostCalcWork::find()
            ->andWhere('deldate is null')
            ->andFilterWhere(['=', 'calc_id', $this->id])
            ->all();

        $worklowsum    = 0;
        $workhighsum   = 0;

        foreach ($equips as $equip)
        {
            $worklowsum     += (int)$equip->pricelowsum;
            $workhighsum    += (int)$equip->pricehighsum;
        }

        $this->worklowsum   = Utils::formatBaseToFormatMoney($worklowsum);
        $this->workhighsum  = Utils::formatBaseToFormatMoney($workhighsum);

        return [$this->worklowsum, $this->workhighsum];
    }

    public function recalc()
    {
        $this->setScenario(self::SCENARIO_RECALC);

        // пересчитываем оборудование
        $equips     = $this->recalcEquips();
        // пересчитываем работы
        $works      = $this->recalcWorks();

        // получаем себестоиомть сметы
        $this->lowsum           =
            // себестоимость оборудования
            $equips[0]
            // себестоимость работ
            + $works[0]
            // себестомость пуско-наладочных работ
            + Utils::formatBaseToFormatMoney($this->startlowsum)
            // себестоимость транспортных расходов
            + Utils::formatBaseToFormatMoney($this->farelowsum)
            // себестоимость проектной документации
            + Utils::formatBaseToFormatMoney($this->projectlowsum);

        // получаем стомость сметы без учета скидки
        $this->withoutdiscountsum =
            // стоимость оборудования
            $equips[1]
            // стоимость работ
            + $works[1]
            // стоимость пуско-наладочных работ
            + Utils::formatBaseToFormatMoney($this->starthighsum)
            // стоимость транспортных расходов
            + Utils::formatBaseToFormatMoney($this->farehighsum)
            // стоимость проектной документации
            + Utils::formatBaseToFormatMoney($this->projecthighsum);

        // скидка
        $this->discount         = Utils::formatBaseToFormatMoney($this->discount);

        $this->startlowsum      = Utils::formatBaseToFormatMoney($this->startlowsum);
        $this->starthighsum     = Utils::formatBaseToFormatMoney($this->starthighsum);
        $this->farelowsum       = Utils::formatBaseToFormatMoney($this->farelowsum);
        $this->farehighsum      = Utils::formatBaseToFormatMoney($this->farehighsum);
        $this->projectlowsum    = Utils::formatBaseToFormatMoney($this->projectlowsum);
        $this->projecthighsum   = Utils::formatBaseToFormatMoney($this->projecthighsum);

        //  получаем сумму скидки
        $discountSum = round($this->withoutdiscountsum*($this->discount/100.00), 2);

        // получаем стоимость сметы
        $this->highsum  = $this->withoutdiscountsum - $discountSum;

        // получаем прибыль
        $this->profitsum = $this->highsum - $this->lowsum;

        // получаем % прибыли
        if ($this->highsum > 0) {
            $this->profitpercent = round((1 - ($this->lowsum / $this->highsum))*100, 2);
        }
        else
        {
            $this->profitpercent = 0;
        }

        $this->save();
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $hasError = false;

        if (!empty($this->dateready) && !in_array($this->getScenario(), [self::SCENARIO_READY, self::SCENARIO_UNREADY]))
        {
            $this->addGeneralError($this->getTypeName() . ' запрещено редактировать, требуется снять готовность.');
            $hasError = true;
        }

        $v = parent::validate($attributeNames, $clearErrors);

        return !$hasError && $v;
    }

    public function beforeSave($insert)
    {
        $this->type_id = 0;
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
<?php

namespace app\models;

use app\components\BaseActiveRecord;

class Objects extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{objects}}';
    }

    public function getStreet() {
        return $this->hasOne(Street::className(), ['id' => 'street_id'])
            ->joinWith('region');
    }

    public function getClient() {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getUserManager() {
        return $this->hasOne(User::className(), ['id' => 'manager']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['street_id', 'house', 'corp', 'client_id', 'manager', 'datebuild', 'quant_doorway', 'note', 'is_service', 'room'];
        $scenarios[self::SCENARIO_UPDATE] = ['street_id', 'house', 'corp', 'client_id', 'manager', 'datebuild', 'quant_doorway', 'note', 'is_service', 'room'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['street_id', 'house'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'street_id' => 'Адрес',
            'house' => 'Дом',
            'corp' => 'Корпус',
            'client_id' => 'Клиент',
            'manager' => 'Менеджер',
            'datebuild' => 'Дата постройки',
            'quant_doorway' => 'Кол-во подъездов',
            'note' => 'Примечание',
            'is_service' => 'Объект на обслуживании',
            'room' => 'Помещение',
        ];
    }

    public function getAddress()
    {
        return $this->street->getFullName() . ', д.' . $this->house . (!empty($this->corp) ? ', корп.' . $this->corp : '') . (empty($this->room) ? '' : ', пом. ' . $this->room);
    }

    public function getServiceText()
    {
        return $this->is_service ? 'На обслуживании' : 'Не на обслуживании';
    }
}
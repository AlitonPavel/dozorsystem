<?php

namespace app\models;

use app\components\BaseActiveRecord;

class Client extends BaseActiveRecord
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return '{{clients}}';
    }

    public function getBank() {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'factaddress', 'juraddress', 'companydetails', 'bank_id', 'email', 'note'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'factaddress', 'juraddress', 'companydetails', 'bank_id', 'email', 'note'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'inn'], 'unique'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'fullname' => 'Полное наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'account' => 'Расч.Счет',
            'ogrn' => 'ОГРН',
            'okpo' => 'ОКПО',
            'factaddress' => 'Фактический адрес',
            'juraddress' => 'Юридический адрес',
            'companydetails' => 'Реквизиты',
            'bank_id' => 'Банк',
            'email' => 'Электронная почта',
            'note' => 'Примечание',
        ];
    }

    /**
     * Получаем реквизиты компании
     *
     * @return string
     */
    public function getCompanyDetails() : string
    {
       if (empty($this->companydetails))
       {
           return $this->juraddress
               . "\n ИНН:" . $this->inn
               . ", КПП:" . $this->kpp
               . ", Рас.сч.:" . $this->account
               . ", ОГРН:" . $this->ogrn
               . (isset($this->bank) ? "\n Банк: " . $this->bank->getRequisites() : '');
       }
       return $this->companydetails;
    }
}
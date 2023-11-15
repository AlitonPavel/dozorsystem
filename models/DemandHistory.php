<?php

namespace app\models;

use app\components\BaseActiveRecord;
use TelegramBot\Api\BotApi;

class DemandHistory extends BaseActiveRecord
{
    const actions = [
        Demand::SCENARIO_CREATE     => 1,
        Demand::SCENARIO_UPDATE     => 2,
        Demand::SCENARIO_TO_MASTER  => 3,
        Demand::SCENARIO_EXEC       => 4,
        Demand::SCENARIO_CHANGE_STATUS => 5,
    ];

    const actionNames = [
        1 => 'Создание',
        2 => 'Изменение',
        3 => 'Передача местеру',
        4 => 'Выполнение',
        5 => 'Измененние статуса',
    ];

    protected $fields = [
        'date' => BaseActiveRecord::TYPE_DATETIME,
        'datexec' => BaseActiveRecord::TYPE_DATETIME,
        'datemaster' => BaseActiveRecord::TYPE_DATETIME,
        'firstdatemaster' => BaseActiveRecord::TYPE_DATETIME,
        'dateaction' => BaseActiveRecord::TYPE_DATETIME,
    ];

    public static function tableName()
    {
        return '{{demandhistories}}';
    }

    public function getType()
    {
        return $this->hasOne(DemandType::className(), ['id' => 'type_id']);
    }

    public function getPrior()
    {
        return $this->hasOne(DemandPrior::className(), ['id' => 'prior_id']);
    }

    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'object_id'])
            ->joinWith('street');
    }

    public function getUserMaster()
    {
        return $this->hasOne(User::className(), ['id' => 'master']);
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $allAttributes = ['action', 'dateaction', 'object_id', 'client_id', 'date', 'creator',
            'contact', 'type_id', 'prior_id', 'demandtext', 'master', 'deadline', 'report', 'datexec', 'datemaster', 'firstdatemaster'];
        $scenarios[Demand::SCENARIO_CREATE] = $allAttributes;
        return $scenarios;
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [
            'id'                => 'Номер',
            'action'            => 'Операция',
            'dateaction'        => 'Дата операции',
            'object_id'         => 'Объект',
            'client_id'         => 'Клиент',
            'date'              => 'Дата рег.',
            'creator'           => 'Заявитель',
            'contact'           => 'Контакты заявителя',
            'type_id'           => 'Тип заявки',
            'prior_id'          => 'Приоритет',
            'demandtext'        => 'Текст заявки',
            'report'            => 'Отчет о выполнении',
            'master'            => 'Исполнитель',
            'deadline'          => 'Предельная дата',
            'datexec'           => 'Дата выполнения',
            'datemaster'        => 'Дата передачи мастеру',
            'firstdatemaster'   => 'Дата первой передачи мастеру'
        ];
    }

    public function getMessageForToMaster()
    {
        return  "Заявка №" . $this->id .
            "\nАдрес: " . $this->object->getAddress() .
            "\nКонтакты: " . $this->creator . " " . $this->contact .
            "\nТекст заявки: " . $this->demandtext;
    }

    public function getActionName()
    {
        return self::actionNames[$this->action];
    }

    public function findStatus()
    {
        // Определяем статус по признакам
        if (!empty($this->datexec))
        {
            return Demand::STATUS_EXEC;
        }
        else if (!empty($this->datemaster))
        {
            return Demand::STATUS_WORK;
        }
        else {
            return Demand::STATUS_NEW;
        }
    }

    public function getStatus()
    {
        if (empty($this->status))
        {
            return $this->findStatus();
        }
        else
        {
            return $this->status;
        }
    }

    public function getStatusText()
    {
        return Demand::statuses[$this->getStatus()] ?? 'Не определен';
    }

    public function getDiff(DemandHistory $preDemand, DemandHistory $demand)
    {
        $str = '';
        $str .= ($preDemand->getStatus() != $demand->getStatus() ? (empty($str) ? '' : ",\n") . 'статус' : '');
        $str .= ($preDemand->object_id != $demand->object_id ? (empty($str) ? '' : ",\n") . 'объект' : '');
        $str .= ($preDemand->client_id != $demand->client_id ? (empty($str) ? '' : ",\n") . 'клиент' : '');
        $str .= ($preDemand->date != $demand->date ? (empty($str) ? '' : ",\n") . 'дата рег.' : '');
        $str .= ($preDemand->creator != $demand->creator ? (empty($str) ? '' : ",\n") . 'создатель' : '');
        $str .= ($preDemand->contact != $demand->contact ? (empty($str) ? '' : ",\n") . 'контакты заявителя' : '');
        $str .= ($preDemand->type_id != $demand->type_id ? (empty($str) ? '' : ",\n") . 'тип заявки' : '');
        $str .= ($preDemand->prior_id != $demand->prior_id ? (empty($str) ? '' : ",\n") . 'приоритет' : '');
        $str .= ($preDemand->demandtext != $demand->demandtext ? (empty($str) ? '' : ",\n") . 'текст заявки' : '');
        $str .= ($preDemand->report != $demand->report ? (empty($str) ? '' : ",\n") . 'отчет о выполнении' : '');
        $str .= ($preDemand->master != $demand->master ? (empty($str) ? '' : ",\n") . 'мастер' : '');
        $str .= ($preDemand->deadline != $demand->deadline ? (empty($str) ? '' : ",\n") . 'предельная дата' : '');
        $str .= ($preDemand->datexec != $demand->datexec ? (empty($str) ? '' : ",\n") . 'дата вып.' : '');
        $str .= ($preDemand->datemaster != $demand->datemaster ? (empty($str) ? '' : ",\n") . 'дата передачи мастеру' : '');
        $str .= ($preDemand->firstdatemaster != $demand->firstdatemaster ? (empty($str) ? '' : ",\n") . 'первоначальная дата передачи мастеру' : '');
        $str .= ($preDemand->deldate != $demand->deldate ? (empty($str) ? '' : ",\n") . 'дата удаления' : '');

        return "Список изменений:\n" . $str;

    }
}
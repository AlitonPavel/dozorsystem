<?php

namespace app\models;

use app\components\BaseActiveRecord;
use TelegramBot\Api\BotApi;

class Demand extends BaseActiveRecord
{
    const SCENARIO_CREATE           = 'insert';
    const SCENARIO_UPDATE           = 'update';
    const SCENARIO_EXEC             = 'exec';
    const SCENARIO_TO_MASTER        = 'tomaster';
    const SCENARIO_CHANGE_STATUS    = 'change_status';
    const SCENARIO_TO_DEFERRED      = 'todeferred';
    const SCENARIO_TO_NEW           = 'tonew';
    const SCENARIO_PLAN             = 'tonew';

    const STATUS_NEW        = 1;
    const STATUS_WORK       = 2;
    const STATUS_DEFERED    = 3;
    const STATUS_EXEC       = 4;
    const STATUS_UNDO       = 5;

    const statuses = [
        self::STATUS_NEW        => 'Новая',
        self::STATUS_WORK       => 'В работе',
        self::STATUS_DEFERED    => 'Отложенная',
        self::STATUS_EXEC       => 'Выполнена',
        self::STATUS_UNDO       => 'Отмена',
    ];

    const statusesColors = [
        self::STATUS_NEW => '#fff',
        self::STATUS_WORK => '#d9edf7',
        self::STATUS_DEFERED => '#fcf8e3',
        self::STATUS_EXEC => '#dff0d8',
        self::STATUS_UNDO => '#E7E7E7',
    ];

    protected $fields = [
        'date'              => BaseActiveRecord::TYPE_DATETIME,
        'datexec'           => BaseActiveRecord::TYPE_DATETIME,
        'datemaster'        => BaseActiveRecord::TYPE_DATETIME,
        'firstdatemaster'   => BaseActiveRecord::TYPE_DATETIME,
        'date_deferred'     => BaseActiveRecord::TYPE_DATETIME,
        'dateplan'          => BaseActiveRecord::TYPE_DATE,
    ];

    public static function tableName()
    {
        return '{{demands}}';
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
        $allAttributes = ['object_id', 'client_id', 'date', 'creator',
            'contact', 'type_id', 'prior_id', 'demandtext', 'master', 'deadline', 'report', 'datexec', 'datemaster', 'firstdatemaster', 'status', 'address'];
        $scenarios[self::SCENARIO_CREATE] = $allAttributes;
        $scenarios[self::SCENARIO_UPDATE] = $allAttributes;
        $scenarios[self::SCENARIO_EXEC] = $allAttributes;
        $scenarios[self::SCENARIO_TO_MASTER] = $allAttributes;
        $scenarios[self::SCENARIO_CHANGE_STATUS] = ['status'];
        $scenarios[self::SCENARIO_TO_DEFERRED] = ['status', 'date_deferred', 'reason_deferred'];
        $scenarios[self::SCENARIO_TO_NEW] = ['status', 'dateexec', 'datemaster', 'date_deferred', 'reason_deferred'];
        $scenarios[self::SCENARIO_PLAN] = ['dateplan'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['date', 'object_id', 'contact', 'type_id', 'prior_id', 'demandtext'], 'required'],
            [['datemaster', 'master'], 'required', 'on' => [self::SCENARIO_TO_MASTER]],
            [['report', 'datemaster', 'datexec', 'master'], 'required', 'on' => [self::SCENARIO_EXEC]],
            [['date_deferred'], 'required', 'on' => [self::SCENARIO_TO_DEFERRED]],
            [['dateplan'], 'required', 'on' => [self::SCENARIO_PLAN]]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'                => 'Номер',
            'status'            => 'Статус',
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
            'firstdatemaster'   => 'Дата первой передачи мастеру',
            'date_deferred'     => 'Отложить заявку до',
            'dateplan'          => 'Плановая дата',
        ];
    }

    public function getMessageForToMaster()
    {
        $address = $this->object ? $this->object->getAddress() : $this->address;

        return  "Заявка №" . $this->id .
            "\nАдрес: " . $address .
            "\nКонтакты: " . $this->creator . " " . $this->contact .
            "\nТекст заявки: " . $this->demandtext;
    }

    public function toMaster(?string $message)
    {
        if (!empty($message))
        {
            $message = $this->getMessageForToMaster() . "\nКомментарий:" .  $message;
        }
        else
        {
            $message = $this->getMessageForToMaster();
        }

        $this->setScenario(Demand::SCENARIO_TO_MASTER);

        if (empty($this->firstdatemaster))
        {
            $this->firstdatemaster = date('d.m.Y H:i');
        }

        if ($this->save())
        {
            /** @var User $user */
            $user = $this->userMaster;

            $user->sendMessage('Новая заявка', $message);

            return true;
        }

        return false;
    }

    public function addHistory()
    {
        $history = new DemandHistory();
        $history->setScenario(Demand::SCENARIO_CREATE);
        $history->action = DemandHistory::actions[$this->getScenario()];
        $history->dateaction = date('d.m.Y H:i');
        $history->demand_id = $this->id;
        $data = [
            'model' => $this->toArray()
        ];
        $history->load($data, 'model');
        $history->save();
    }

    public function beforeSave($insert)
    {
        if (!in_array($this->getScenario(),
            [
                self::SCENARIO_CHANGE_STATUS,
                self::SCENARIO_TO_DEFERRED,
                self::SCENARIO_TO_NEW
            ]
        )) {
            $this->status = $this->findStatus();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->addHistory();
    }

    public function findStatus()
    {
        // Определяем статус по признакам
        if (!empty($this->datexec))
        {
            return self::STATUS_EXEC;
        }
        else if (!empty($this->datemaster))
        {
            return self::STATUS_WORK;
        }
        else {
            return self::STATUS_NEW;
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
        return self::statuses[$this->getStatus()] ?? 'Не определен';
    }

    public function plan($dateplan, ?string $message)
    {
        if (strtotime($dateplan) >= strtotime(date('d.m.Y')))
        {
            $this->setScenario(Demand::SCENARIO_PLAN);
            $this->dateplan = $dateplan;
            $this->save();

            $comment = new DemandComment();
            $comment->demand_id = $this->id;
            $comment->date = date('d.m.Y');
            $comment->user_id = \Yii::$app->user->id;
            $comment->comment = 'Поставлена плановая дата: ' . $comment->date;
            $comment->save();

            return true;
        }
        else
        {
            $this->addError('dateplan', 'Плановая дата должна быть больше или равна текущей дате');
            return false;
        }
    }

    public function getAddress(): string
    {
        return $this->object ? $this->object->getAddress() : $this->address;
    }
}
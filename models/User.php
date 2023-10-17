<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\Messanger;
use Yii;

class User extends BaseActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_CREATE = 'insert';
    const SCENARIO_UPDATE = 'update';

    public $accessToken;

    public static function tableName()
    {
        return '{{users}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['login', 'password', 'first_name', 'surname', 'last_name', 'email', 'tlgm', 'icq'];
        $scenarios[self::SCENARIO_UPDATE] = ['login', 'password', 'first_name', 'surname', 'last_name', 'email', 'tlgm', 'icq'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['login', 'password', 'first_name', 'surname'], 'required'],
            [['login'], 'unique'],
            ['email', 'email'],
            [['first_name', 'surname', 'last_name'], 'match', 'pattern' => '/^[а-яёА-ЯЁ]+$/u', 'message' => 'Имена должны состоять только из русских символов']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::find()->all() as $user) {
            if (strcasecmp($user->login, $username) === 0) {
                return $user;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function getFIO()
    {
        return $this->surname .
            ' ' . mb_strtoupper(mb_substr($this->first_name, 0, 1)) .
            '.' . mb_strtoupper(mb_substr($this->last_name, 0, 1)) . '.';
    }

    public function getFullFIO()
    {
        return $this->surname .
            ' ' . $this->first_name .
            ' ' . $this->last_name;
    }

    public function attributeLabels()
    {
        //'login', 'password', 'first_name', 'surname', 'last_name', 'deldate'
        return [
            'id' => 'Ид',
            'login' => 'Логин',
            'password' => 'Пароль',
            'first_name' => 'Имя',
            'surname' => 'Фамилия',
            'last_name' => 'Отчество',
            'deldate' => 'Дата удаления',
            'email' => 'Электронная почта',
            'tlgm' => 'ИД Телеграмм',
            'icq' => 'ИД ICQ'
        ];
    }

    public function sendMessage(string $subject, string $message)
    {
        if (!empty($subject) && !empty($message)) {

            if (!empty($this->email)) {
                try {
                    Messanger::sendEmail($subject, [$this->email], [], $message);
                }
                catch (\Exception $e)
                {

                }
            }

            if (!empty($this->tlgm)) {
                try {
                    Messanger::sendMessageToTelegramm($this->tlgm, $message);
                }
                catch (\Exception $e)
                {

                }
            }

            if (!empty($this->icq)) {
                try {
                    Messanger::sendMessageToICQ($this->icq, $message);
                }
                catch (\Exception $e)
                {

                }
            }
        }
        return true;
    }

    public function generateSecretCode()
    {
        $abc = 'abcdefghijklmnopqrstuvwxyz';
        $code = '';

        for ($i = 0; $i < 10; $i++)
        {
            $code .= $abc[rand(0, strlen($abc) - 1)];
        }

        return $code;
    }

    public function afterLogin() {
        $this->secretcode = $this->generateSecretCode();
        $session = Yii::$app->session;
        $session->set('secretcode', $this->secretcode);
        $this->save(false);
    }
}

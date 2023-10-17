<?php


namespace app\components;

use SebastianBergmann\CodeCoverage\Util;
use yii\db\ActiveRecord;
use Yii;

class BaseActiveRecord extends ActiveRecord
{
    const TYPE_INT          = 0;
    const TYPE_STRING       = 1;
    const TYPE_DATE         = 2;
    const TYPE_DATETIME     = 3;
    const TYPE_MONEY        = 4;

    protected $fields = [];

    protected $errors = [];

    public function rebuildFields()
    {
        foreach ($this->fields as $name => $type)
        {
            if ($this->isAttributeChanged($name)) {
                if ($type == self::TYPE_DATE) {
                    $this->rebuildFieldDate($name, Utils::DEFAUL_DATESHORT_FORMAT2);
                }
                if ($type == self::TYPE_DATETIME) {
                    $this->rebuildFieldDate($name, Utils::DEFAULT_DATE_FORMAT2);
                }
                if ($type == self::TYPE_MONEY) {
                    $this->rebuildFieldMoney($name);
                }
            }
        }
    }

    public function rebuildFieldDate($field, $format)
    {
        $value = $this->getAttribute($field);
        if (!empty($value)) {
            $format = Utils::isDate($value);
            if ($format) {
                $this->setAttribute($field, Utils::dateToFormat($value, $format, Utils::DEFAULT_DATE_FORMAT2));
            }
        }
    }

    public function rebuildFieldMoney($field)
    {
        $value = $this->getAttribute($field);
        if (!empty($value)) {
            if (Utils::isMoney($value))
            {
                $this->setAttribute($field, Utils::formatMoneyToBase($value));
            }
        }
    }

    public function hasAutoAttribute(array $parts)
    {
        if ($this->hasAttribute(implode('_', $parts))) {
            return implode('_', $parts);
        } else if ($this->hasAttribute(implode('', $parts))) {
            return implode('', $parts);
        }
        return false;
    }

    public function fillAutoCreateAttributes()
    {
        if ($attr = $this->hasAutoAttribute(['date', 'create'])) {
            $this->setAttribute($attr, date('Y-m-d H:i'));
        }
        if (isset(Yii::$app->user) && !Yii::$app->user->isGuest) {
            if ($attr = $this->hasAutoAttribute(['user', 'create'])) {
                $this->setAttribute($attr, Yii::$app->user->getId());
            }
        }
    }

    public function fillAutoChangeAttributes()
    {
        if ($attr = $this->hasAutoAttribute(['date', 'change'])) {
            $this->setAttribute($attr, date('Y-m-d H:i'));
        }

        if (isset(Yii::$app->user) && !Yii::$app->user->isGuest) {
            if ($attr = $this->hasAutoAttribute(['user', 'change'])) {
                $this->setAttribute($attr, Yii::$app->user->getId());
            }
        }
    }

    public function beforeValidate()
    {
        $this->rebuildFields();

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->fillAutoCreateAttributes();
        } else {
            $this->fillAutoChangeAttributes();
        }

        return parent::beforeSave($insert);
    }

    public function delete()
    {
        if ($this->hasAttribute('deldate')) {
            $this->deldate = date('Y-m-d H:i');
            $this->save();
        } else {
            parent::delete();
        }
    }

    public function addGeneralError(string $message)
    {
        $this->errors[] = $message;
    }

    public function getGeneralErrors()
    {
        return $this->errors;
    }

    public function renderGeneralErrors()
    {
        foreach ($this->errors as $error)
        {
            echo '<div class="input_error">' . $error . '</div>';
        }
    }

    public function rebuildFieldMoneyBack($field)
    {
        $value = $this->getAttribute($field);
        if (!empty($value)) {
            if (Utils::isMoney($value))
            {
                $this->setAttribute($field, Utils::formatMoneyToBase($value));
            }
        }
    }

//    public function validate($attributeNames = null, $clearErrors = true)
//    {
//        $validate = parent::validate($attributeNames, $clearErrors);
//
//        if ($validate)
//    }
}
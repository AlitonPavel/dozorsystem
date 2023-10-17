<?php

namespace app\components;

class CheckBox extends Input
{
    public $type = 'checkbox';
    /** @var bool $checked */
    public $checked = false;

    public function init()
    {
        parent::init();

        if ($this->value)
        {
            $this->checked = true;
        }
    }

    public function run()
    {
        return $this->render('checkbox', [
            'widget' => $this
        ]);
    }
}
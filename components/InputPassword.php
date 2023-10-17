<?php

namespace app\components;

class InputPassword extends Input
{
    public $type = 'password';

    public function run()
    {
        return $this->render('password', [
            'widget' => $this
        ]);
    }
}
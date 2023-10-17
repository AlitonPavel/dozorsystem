<?php

namespace app\components;

class SelectInput extends Input
{
    public $items = [];

    public $size = 1;

    public function run()
    {
        return $this->render('selectinput', [
            'widget' => $this
        ]);
    }
}
<?php

namespace app\components;

class InputPrice extends Input
{
    public $placeholder = '00.00';
    public $pattern = '\d+(\.\d{2})?';

    public function run()
    {
        return $this->render('price', [
            'widget' => $this
        ]);
    }
}

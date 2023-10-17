<?php

namespace app\components;

class InputFile extends Input
{
    public $type = 'file';
    public $accept;
    public $size = 30000;

    public function run()
    {
        return $this->render('file', [
            'widget' => $this
        ]);
    }
}

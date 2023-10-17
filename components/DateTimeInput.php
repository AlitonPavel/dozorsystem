<?php

namespace app\components;

class DateTimeInput extends Input
{
    public function run()
    {
        return $this->render('datetime', [
            'widget' => $this
        ]);
    }
}
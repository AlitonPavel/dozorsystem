<?php

namespace app\components;

class DateInput extends Input
{
    public function run()
    {
        return $this->render('date', [
            'widget' => $this
        ]);
    }
}
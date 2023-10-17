<?php
namespace app\components;

use yii\web\View;

class BaseView extends View
{
    public function getClearFix()
    {
        return '<div class="clearfix"></div>';
    }
}
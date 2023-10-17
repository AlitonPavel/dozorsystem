<?php

namespace app\commands\rbac;

use Yii;

class RbacReport
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Печать сметы
        $CostCalcPrint = $authManager->createPermission('CostCalcPrint');

        // Добавление операций
        $authManager->add($CostCalcPrint);
    }
}
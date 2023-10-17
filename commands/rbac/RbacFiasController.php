<?php

namespace app\commands\rbac;

use Yii;
use yii\web\Controller;

class RbacFiasController extends Controller
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $fiasPublic = $authManager->createPermission('fiasPublic');

        // Создание операций
        $fiasIndex = $authManager->createPermission('fiasIndex');

        // Добавление ролей
        $authManager->add($fiasPublic);
        // Добавление операций
        $authManager->add($fiasIndex);

        // Добавление операций ролям
        $authManager->addChild($fiasPublic, $fiasIndex);
    }
}
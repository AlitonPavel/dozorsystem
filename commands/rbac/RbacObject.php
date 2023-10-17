<?php

namespace app\commands\rbac;

use Yii;
use yii\web\Controller;

class RbacObject extends Controller
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminObject = $authManager->createPermission('adminObject');
        $managerObject = $authManager->createPermission('managerObject');
        $userObject = $authManager->createPermission('userObject');

        // Создание операций
        $ObjectView = $authManager->createPermission('ObjectView');
        $ObjectUpdate = $authManager->createPermission('ObjectUpdate');
        $ObjectCreate = $authManager->createPermission('ObjectCreate');
        $ObjectDelete = $authManager->createPermission('ObjectDelete');

        // Добавление ролей
        $authManager->add($userObject);
        $authManager->add($managerObject);
        $authManager->add($adminObject);

        // Добавление операций
        $authManager->add($ObjectView);
        $authManager->add($ObjectUpdate);
        $authManager->add($ObjectCreate);
        $authManager->add($ObjectDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userObject, $ObjectView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerObject, $userObject);
        $authManager->addChild($managerObject, $ObjectUpdate);
        $authManager->addChild($managerObject, $ObjectCreate);
        // Админ (Все права)
        $authManager->addChild($adminObject, $managerObject);
        $authManager->addChild($adminObject, $ObjectDelete);
    }
}
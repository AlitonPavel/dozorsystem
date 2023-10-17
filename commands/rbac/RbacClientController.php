<?php

namespace app\commands\rbac;

use Yii;

class RbacClientController
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminClient = $authManager->createPermission('adminClient');
        $managerClient = $authManager->createPermission('managerClient');
        $userClient = $authManager->createPermission('userClient');

        // Создание операций
        $clientView = $authManager->createPermission('clientView');
        $clientUpdate = $authManager->createPermission('clientUpdate');
        $clientCreate = $authManager->createPermission('clientCreate');
        $clientDelete = $authManager->createPermission('clientDelete');

        // Добавление ролей
        $authManager->add($userClient);
        $authManager->add($managerClient);
        $authManager->add($adminClient);
        
        // Добавление операций
        $authManager->add($clientView);
        $authManager->add($clientUpdate);
        $authManager->add($clientCreate);
        $authManager->add($clientDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userClient, $clientView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerClient, $userClient);
        $authManager->addChild($managerClient, $clientUpdate);
        $authManager->addChild($managerClient, $clientCreate);
        // Админ (Все права)
        $authManager->addChild($adminClient, $managerClient);
        $authManager->addChild($adminClient, $clientDelete);
    }
}
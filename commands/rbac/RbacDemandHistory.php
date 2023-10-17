<?php

namespace app\commands\rbac;

use Yii;

class RbacDemandHistory
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminDemandHistory = $authManager->createPermission('adminDemandHistory');
        $managerDemandHistory = $authManager->createPermission('managerDemandHistory');
        $userDemandHistory = $authManager->createPermission('userDemandHistory');

        // Создание операций
        $DemandHistoryView = $authManager->createPermission('DemandHistoryView');

        // Добавление ролей
        $authManager->add($userDemandHistory);
        $authManager->add($managerDemandHistory);
        $authManager->add($adminDemandHistory);

        // Добавление операций
        $authManager->add($DemandHistoryView);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userDemandHistory, $DemandHistoryView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerDemandHistory, $userDemandHistory);
        // Админ (Все права)
        $authManager->addChild($adminDemandHistory, $managerDemandHistory);
    }
}
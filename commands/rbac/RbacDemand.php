<?php

namespace app\commands\rbac;

use Yii;

class RbacDemand
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminDemand = $authManager->createPermission('adminDemand');
        $managerDemand = $authManager->createPermission('managerDemand');
        $userDemand = $authManager->createPermission('userDemand');

        // Создание операций
        $DemandView = $authManager->createPermission('DemandView');
        $DemandUpdate = $authManager->createPermission('DemandUpdate');
        $DemandCreate = $authManager->createPermission('DemandCreate');
        $DemandDelete = $authManager->createPermission('DemandDelete');

        // Добавление ролей
        $authManager->add($userDemand);
        $authManager->add($managerDemand);
        $authManager->add($adminDemand);

        // Добавление операций
        $authManager->add($DemandView);
        $authManager->add($DemandUpdate);
        $authManager->add($DemandCreate);
        $authManager->add($DemandDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userDemand, $DemandView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerDemand, $userDemand);
        $authManager->addChild($managerDemand, $DemandUpdate);
        $authManager->addChild($managerDemand, $DemandCreate);
        // Админ (Все права)
        $authManager->addChild($adminDemand, $managerDemand);
        $authManager->addChild($adminDemand, $DemandDelete);
    }
}
<?php

namespace app\commands\rbac;

use Yii;

class RbacDemandType
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminDemandType = $authManager->createPermission('adminDemandType');
        $managerDemandType = $authManager->createPermission('managerDemandType');
        $userDemandType = $authManager->createPermission('userDemandType');

        // Создание операций
        $DemandTypeView = $authManager->createPermission('DemandTypeView');
        $DemandTypeUpdate = $authManager->createPermission('DemandTypeUpdate');
        $DemandTypeCreate = $authManager->createPermission('DemandTypeCreate');
        $DemandTypeDelete = $authManager->createPermission('DemandTypeDelete');

        // Добавление ролей
        $authManager->add($userDemandType);
        $authManager->add($managerDemandType);
        $authManager->add($adminDemandType);

        // Добавление операций
        $authManager->add($DemandTypeView);
        $authManager->add($DemandTypeUpdate);
        $authManager->add($DemandTypeCreate);
        $authManager->add($DemandTypeDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userDemandType, $DemandTypeView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerDemandType, $userDemandType);
        $authManager->addChild($managerDemandType, $DemandTypeUpdate);
        $authManager->addChild($managerDemandType, $DemandTypeCreate);
        // Админ (Все права)
        $authManager->addChild($adminDemandType, $managerDemandType);
        $authManager->addChild($adminDemandType, $DemandTypeDelete);
    }
}
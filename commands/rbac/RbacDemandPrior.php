<?php

namespace app\commands\rbac;

use Yii;

class RbacDemandPrior
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminDemandPrior = $authManager->createPermission('adminDemandPrior');
        $managerDemandPrior = $authManager->createPermission('managerDemandPrior');
        $userDemandPrior = $authManager->createPermission('userDemandPrior');

        // Создание операций
        $DemandPriorView = $authManager->createPermission('DemandPriorView');
        $DemandPriorUpdate = $authManager->createPermission('DemandPriorUpdate');
        $DemandPriorCreate = $authManager->createPermission('DemandPriorCreate');
        $DemandPriorDelete = $authManager->createPermission('DemandPriorDelete');

        // Добавление ролей
        $authManager->add($userDemandPrior);
        $authManager->add($managerDemandPrior);
        $authManager->add($adminDemandPrior);

        // Добавление операций
        $authManager->add($DemandPriorView);
        $authManager->add($DemandPriorUpdate);
        $authManager->add($DemandPriorCreate);
        $authManager->add($DemandPriorDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userDemandPrior, $DemandPriorView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerDemandPrior, $userDemandPrior);
        $authManager->addChild($managerDemandPrior, $DemandPriorUpdate);
        $authManager->addChild($managerDemandPrior, $DemandPriorCreate);
        // Админ (Все права)
        $authManager->addChild($adminDemandPrior, $managerDemandPrior);
        $authManager->addChild($adminDemandPrior, $DemandPriorDelete);
    }
}
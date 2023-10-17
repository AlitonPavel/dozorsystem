<?php

namespace app\commands\rbac;

use Yii;
use yii\web\Controller;

class RbacCostCalc extends Controller
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminCostCalc = $authManager->createPermission('adminCostCalc');
        $managerCostCalc = $authManager->createPermission('managerCostCalc');
        $userCostCalc = $authManager->createPermission('userCostCalc');

        // Создание операций
        $CostCalcView = $authManager->createPermission('CostCalcView');
        $CostCalcUpdate = $authManager->createPermission('CostCalcUpdate');
        $CostCalcCreate = $authManager->createPermission('CostCalcCreate');
        $CostCalcDelete = $authManager->createPermission('CostCalcDelete');

        // Права на оборудование
        $CostCalcEquipView = $authManager->createPermission('CostCalcEquipView');
        $CostCalcEquipUpdate = $authManager->createPermission('CostCalcEquipUpdate');
        $CostCalcEquipCreate = $authManager->createPermission('CostCalcEquipCreate');
        $CostCalcEquipDelete = $authManager->createPermission('CostCalcEquipDelete');

        // Права на ФОТ
        $CostCalcWorkView = $authManager->createPermission('CostCalcWorkView');
        $CostCalcWorkUpdate = $authManager->createPermission('CostCalcWorkUpdate');
        $CostCalcWorkCreate = $authManager->createPermission('CostCalcWorkCreate');
        $CostCalcWorkDelete = $authManager->createPermission('CostCalcWorkDelete');

        // Добавление ролей
        $authManager->add($userCostCalc);
        $authManager->add($managerCostCalc);
        $authManager->add($adminCostCalc);

        // Добавление операций
        $authManager->add($CostCalcView);
        $authManager->add($CostCalcUpdate);
        $authManager->add($CostCalcCreate);
        $authManager->add($CostCalcDelete);

        $authManager->add($CostCalcEquipView);
        $authManager->add($CostCalcEquipUpdate);
        $authManager->add($CostCalcEquipCreate);
        $authManager->add($CostCalcEquipDelete);

        $authManager->add($CostCalcWorkView);
        $authManager->add($CostCalcWorkUpdate);
        $authManager->add($CostCalcWorkCreate);
        $authManager->add($CostCalcWorkDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userCostCalc, $CostCalcView);
        $authManager->addChild($userCostCalc, $CostCalcEquipView);
        $authManager->addChild($userCostCalc, $CostCalcWorkView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerCostCalc, $userCostCalc);
        $authManager->addChild($managerCostCalc, $CostCalcUpdate);
        $authManager->addChild($managerCostCalc, $CostCalcCreate);
        $authManager->addChild($managerCostCalc, $CostCalcEquipUpdate);
        $authManager->addChild($managerCostCalc, $CostCalcEquipCreate);
        $authManager->addChild($managerCostCalc, $CostCalcWorkUpdate);
        $authManager->addChild($managerCostCalc, $CostCalcWorkCreate);
        // Админ (Все права)
        $authManager->addChild($adminCostCalc, $managerCostCalc);
        $authManager->addChild($adminCostCalc, $CostCalcDelete);
        $authManager->addChild($adminCostCalc, $CostCalcEquipDelete);
        $authManager->addChild($adminCostCalc, $CostCalcWorkDelete);
    }
}

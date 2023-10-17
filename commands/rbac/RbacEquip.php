<?php

namespace app\commands\rbac;

use Yii;

class RbacEquip
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminEquip = $authManager->createPermission('adminEquip');
        $managerEquip = $authManager->createPermission('managerEquip');
        $userEquip = $authManager->createPermission('userEquip');

        // Создание операций
        $EquipView = $authManager->createPermission('EquipView');
        $EquipUpdate = $authManager->createPermission('EquipUpdate');
        $EquipCreate = $authManager->createPermission('EquipCreate');
        $EquipDelete = $authManager->createPermission('EquipDelete');

        // Добавление ролей
        $authManager->add($userEquip);
        $authManager->add($managerEquip);
        $authManager->add($adminEquip);

        // Добавление операций
        $authManager->add($EquipView);
        $authManager->add($EquipUpdate);
        $authManager->add($EquipCreate);
        $authManager->add($EquipDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userEquip, $EquipView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerEquip, $userEquip);
        $authManager->addChild($managerEquip, $EquipUpdate);
        $authManager->addChild($managerEquip, $EquipCreate);
        // Админ (Все права)
        $authManager->addChild($adminEquip, $managerEquip);
        $authManager->addChild($adminEquip, $EquipDelete);
    }
}
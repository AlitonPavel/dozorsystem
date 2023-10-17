<?php

namespace app\commands\rbac;

use Yii;

class RbacBank
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminBank = $authManager->createPermission('adminBank');
        $managerBank = $authManager->createPermission('managerBank');
        $userBank = $authManager->createPermission('userBank');

        // Создание операций
        $BankView = $authManager->createPermission('BankView');
        $BankUpdate = $authManager->createPermission('BankUpdate');
        $BankCreate = $authManager->createPermission('BankCreate');
        $BankDelete = $authManager->createPermission('BankDelete');

        // Добавление ролей
        $authManager->add($userBank);
        $authManager->add($managerBank);
        $authManager->add($adminBank);

        // Добавление операций
        $authManager->add($BankView);
        $authManager->add($BankUpdate);
        $authManager->add($BankCreate);
        $authManager->add($BankDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userBank, $BankView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerBank, $userBank);
        $authManager->addChild($managerBank, $BankUpdate);
        $authManager->addChild($managerBank, $BankCreate);
        // Админ (Все права)
        $authManager->addChild($adminBank, $managerBank);
        $authManager->addChild($adminBank, $BankDelete);
    }
}
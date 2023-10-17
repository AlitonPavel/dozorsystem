<?php

namespace app\commands\rbac;

use Yii;

class RbacDemandComment
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $adminDemandComment = $authManager->createPermission('adminDemandComment');
        $managerDemandComment = $authManager->createPermission('managerDemandComment');
        $userDemandComment = $authManager->createPermission('userDemandComment');

        // Создание операций
        $DemandCommentView = $authManager->createPermission('DemandCommentView');
        $DemandCommentUpdate = $authManager->createPermission('DemandCommentUpdate');
        $DemandCommentCreate = $authManager->createPermission('DemandCommentCreate');
        $DemandCommentDelete = $authManager->createPermission('DemandCommentDelete');

        // Добавление ролей
        $authManager->add($userDemandComment);
        $authManager->add($managerDemandComment);
        $authManager->add($adminDemandComment);

        // Добавление операций
        $authManager->add($DemandCommentView);
        $authManager->add($DemandCommentUpdate);
        $authManager->add($DemandCommentCreate);
        $authManager->add($DemandCommentDelete);

        // Добавление операций ролям
        // Пользователь (Только просмотр)
        $authManager->addChild($userDemandComment, $DemandCommentView);
        // Менеджер (Просомтр, Добавление, Редактирование)
        $authManager->addChild($managerDemandComment, $userDemandComment);
        $authManager->addChild($managerDemandComment, $DemandCommentUpdate);
        $authManager->addChild($managerDemandComment, $DemandCommentCreate);
        // Админ (Все права)
        $authManager->addChild($adminDemandComment, $managerDemandComment);
        $authManager->addChild($adminDemandComment, $DemandCommentDelete);
    }
}
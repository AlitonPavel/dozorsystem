<?php

namespace app\commands\rbac\admin;

use Yii;
use yii\console\Controller;

class RbacAdminController extends Controller
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        $admin = $authManager->getRole('admin');

        // Создание операций
        $adminIndex = $authManager->createPermission('adminIndex');
        $adminUpdate = $authManager->createPermission('adminUpdate');
        $adminCreate = $authManager->createPermission('adminCreate');
        $adminDelete = $authManager->createPermission('adminDelete');

        // Добавление операций
        $authManager->add($adminIndex);
        $authManager->add($adminUpdate);
        $authManager->add($adminCreate);
        $authManager->add($adminDelete);

        // Добавление операций ролям
        $authManager->addChild($admin, $adminIndex);
        $authManager->addChild($admin, $adminUpdate);
        $authManager->addChild($admin, $adminCreate);
        $authManager->addChild($admin, $adminDelete);
    }
}


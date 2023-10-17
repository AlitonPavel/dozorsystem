<?php
namespace app\commands\rbac;

use Yii;
use yii\console\Controller;

class RbacSiteController extends Controller
{
    public static function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Создание ролей
        //$sitePublic = $authManager->createRole('sitePublic');
        $sitePublic = $authManager->createPermission('sitePublic');

        // Создание операций
        $siteIndex = $authManager->createPermission('siteIndex');
        $siteLogin = $authManager->createPermission('siteLogin');
        $siteLogout = $authManager->createPermission('siteLogout');
        $siteContact = $authManager->createPermission('siteContact');
        $siteAbout = $authManager->createPermission('siteAbout');

        // Добавление ролей
        $authManager->add($sitePublic);
        // Добавление операций
        $authManager->add($siteIndex);
        $authManager->add($siteLogin);
        $authManager->add($siteLogout);
        $authManager->add($siteContact);
        $authManager->add($siteAbout);

        // Добавление операций ролям
        $authManager->addChild($sitePublic, $siteIndex);
        $authManager->addChild($sitePublic, $siteLogin);
        $authManager->addChild($sitePublic, $siteLogout);
        $authManager->addChild($sitePublic, $siteContact);
        $authManager->addChild($sitePublic, $siteAbout);
    }
}


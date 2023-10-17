<?php
namespace app\commands;


use app\commands\rbac\RbacBank;
use app\commands\rbac\RbacCostCalc;
use app\commands\rbac\RbacDemand;
use app\commands\rbac\RbacDemandComment;
use app\commands\rbac\RbacDemandPrior;
use app\commands\rbac\RbacDemandType;
use app\commands\rbac\RbacEquip;
use app\commands\rbac\RbacObject;
use app\commands\rbac\RbacFiasController;
use app\commands\rbac\RbacReport;
use app\models\User;
use Yii;
use yii\console\Controller;
use app\commands\rbac\RbacSiteController;
use app\commands\rbac\admin\RbacAdminController;
use app\commands\rbac\RbacClientController;
use app\commands\rbac\RbacDemandHistory;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        // Создание ролей
        $guest  = $authManager->createRole('guest');
        $admin  = $authManager->createRole('admin');
        $public = $authManager->createRole('public');

        $authManager->add($guest);
        $authManager->add($admin);
        $authManager->add($public);

        RbacSiteController::actionInit();
        RbacAdminController::actionInit();
        RbacFiasController::actionInit();
        RbacClientController::actionInit();
        RbacObject::actionInit();
        RbacDemandType::actionInit();
        RbacDemandPrior::actionInit();
        RbacDemand::actionInit();
        RbacCostCalc::actionInit();
        RbacBank::actionInit();
        RbacDemandHistory::actionInit();
        RbacDemandComment::actionInit();
        RbacEquip::actionInit();
        RbacReport::actionInit();

        // Добавление операций ролям

        // Публичный
        $authManager->addChild($public, $authManager->getPermission('sitePublic'));
        $authManager->addChild($public, $authManager->getPermission('fiasPublic'));
        $authManager->addChild($public, $authManager->getPermission('managerClient'));
        $authManager->addChild($public, $authManager->getPermission('managerObject'));
        $authManager->addChild($public, $authManager->getPermission('userDemandType'));
        $authManager->addChild($public, $authManager->getPermission('userDemandPrior'));
        $authManager->addChild($public, $authManager->getPermission('managerDemand'));
        $authManager->addChild($public, $authManager->getPermission('managerBank'));
        $authManager->addChild($public, $authManager->getPermission('managerDemandHistory'));
        $authManager->addChild($public, $authManager->getPermission('managerDemandComment'));
        $authManager->addChild($public, $authManager->getPermission('managerCostCalc'));
        $authManager->addChild($public, $authManager->getPermission('managerEquip'));
        $authManager->addChild($public, $authManager->getPermission('CostCalcPrint'));

        // Админ
        $authManager->addChild($admin, $public);
        $authManager->addChild($admin, $guest);
        $authManager->addChild($admin, $authManager->getPermission('adminClient'));
        $authManager->addChild($admin, $authManager->getPermission('adminObject'));
        $authManager->addChild($admin, $authManager->getPermission('adminDemandType'));
        $authManager->addChild($admin, $authManager->getPermission('adminDemandPrior'));
        $authManager->addChild($admin, $authManager->getPermission('adminDemand'));
        $authManager->addChild($admin, $authManager->getPermission('adminBank'));
        $authManager->addChild($public, $authManager->getPermission('adminDemandHistory'));
        $authManager->addChild($public, $authManager->getPermission('adminDemandComment'));
        $authManager->addChild($admin, $authManager->getPermission('adminCostCalc'));
        $authManager->addChild($admin, $authManager->getPermission('adminEquip'));

        // Гость
        $authManager->addChild($guest, $authManager->getPermission('sitePublic'));

        $user = User::findOne(['login' => 'admin']);
        if ($user) {
            $authManager->assign($admin, $user->getId());
        }
    }
}

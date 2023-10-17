<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use app\components\BaseAdminController;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use app\commands\rbac\RoleController;
use app\components\Messanger;

/**
 * Default controller for the `admin` module
 */
class UserController extends BaseAdminController
{
    const PAGE_TITLE_INDEX = 'Список пользователей';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create', 'delete', 'testmessage'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['adminIndex'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['adminUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['adminCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['adminDelete'],
                    ],
                    [
                        'actions' => ['testmessage'],
                        'allow' => true,
                        'roles' => ['adminIndex'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new User();
        $model->setScenario(User::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            RoleController::updateUserRoles($this->getRolesFromRequest(), $model->getId());
            return $this->redirect(['/admin/user']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(User::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            RoleController::updateUserRoles($this->getRolesFromRequest(), $model->getId());
            return $this->redirect(['/admin/user']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getRolesFromRequest()
    {
        $reqUser = Yii::$app->request->post('User', []);
        $roles = isset($reqUser['Roles']) ? $reqUser['Roles'] : [];

        return array_map(function ($role, $grant) {
            if ($grant) {
                return $role;
            }
        }, array_keys($roles), array_values($roles));
    }

    public function actionTestmessage()
    {
        $email = Yii::$app->request->get('email');
        if (!empty($email)) {
            Messanger::sendEmail('Тестовое сообщение', [$email], [], 'Проверка  почты');
        }
        $telegram = Yii::$app->request->get('telegram');
        if (!empty($telegram)) {
            Messanger::sendMessageToTelegramm($telegram, 'Проверка телеграм');
        }
        $icq = Yii::$app->request->get('icq');
        if (!empty($icq)) {
            Messanger::sendMessageToICQ($icq, 'Проверка ICQ');
        }
    }
}

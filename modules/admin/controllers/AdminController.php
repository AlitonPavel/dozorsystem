<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use app\components\BaseAdminController;

/**
 * Default controller for the `admin` module
 */
class AdminController extends BaseAdminController
{
    const PAGE_TITLE_INDEX = 'Админка';
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'telegram', 'Icq'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['adminIndex'],
                    ],
                    [
                        'actions' => ['telegram'],
                        'allow' => true,
                        'roles' => ['adminIndex'],
                    ],
                    [
                        'actions' => ['icq'],
                        'allow' => true,
                        'roles' => ['adminIndex'],
                    ],
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

    public function actionTelegram()
    {
        return $this->render('telegram');
    }

    public function actionIcq()
    {
        return $this->render('icq');
    }
}

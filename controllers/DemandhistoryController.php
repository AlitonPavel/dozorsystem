<?php

namespace app\controllers;

use app\components\BaseController;
use yii\filters\AccessControl;

class DemandhistoryController extends BaseController
{
    const PAGE_TITLE_INDEX = 'История изменений заявки';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['DemandHistoryView'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        return $this->render('index', [
            'demand_id' => $id
        ]);
    }
}

<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\CostCalcRender;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ReportController extends BaseController
{

    public $layout = 'report';

    public $head = 'Отчет';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['costcalcprint'],
                'rules' => [
                    [
                        'actions' => ['costcalcprint'],
                        'allow' => true,
                        'roles' => ['CostCalcPrint'],
                    ],
                ],
            ],
        ];
    }

    public function actionCostcalcprint($id)
    {
        $render = new CostCalcRender($id);

        return $this->render('costcalc', [
            'render' => $render
        ]);
    }
}
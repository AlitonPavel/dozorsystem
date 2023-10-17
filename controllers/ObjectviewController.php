<?php

namespace app\controllers;

use app\components\TabController;
use app\models\Objects;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class ObjectviewController extends TabController
{
    const PAGE_TITLE_INDEX = 'Объект';

    public $tabParams = ['id'];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->setTabs([
            ['id' => 'index', 'url' => Url::to(array_merge(['/objectview'], $this->params)), 'title' => 'Общие'],
            ['id' => 'contracts', 'url' => Url::to(array_merge(['/objectview/contracts'], $this->params)), 'title' => 'Договора'],
            ['id' => 'costcalc', 'url' => Url::to(array_merge(['/objectview/costcalc'], $this->params)), 'title' => 'Сметы'],
        ]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'contracts'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['contracts'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionIndex($id)
    {
        $model = $this->findModel($id);

        return $this->render('general', [
            'model' => $model
        ]);
    }

    public function actionContracts($id)
    {
        $model = $this->findModel($id);

        return $this->render('contracts', [
            'model' => $model
        ]);
    }

    public function actionCostcalc($id)
    {
        $model = $this->findModel($id);

        return $this->render('costcalc', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Objects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
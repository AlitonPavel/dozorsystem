<?php

namespace app\controllers;

use app\components\TabController;
use app\models\CostCalc;
use app\models\Demand;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Yii;

class CostcalcviewController extends TabController
{
    const PAGE_TITLE_INDEX = 'Смета';

    public $tabParams = ['id'];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->setTabs([
            ['id' => 'index', 'url' => Url::to(array_merge(['/costcalc/view'], $this->params)), 'title' => 'Общие'],
            ['id' => 'equip', 'url' => Url::to(array_merge(['/costcalc/equip'], $this->params)), 'title' => 'Оборудование'],
            ['id' => 'work', 'url' => Url::to(array_merge(['/costcalc/work'], $this->params)), 'title' => 'ФОТ'],
            ['id' => 'pays', 'url' => Url::to(array_merge(['/costcalc/pays'], $this->params)), 'title' => 'Платежные документы'],
        ]);
    }

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
                        'roles' => ['CostCalcView'],
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

        if (!Yii::$app->request->get('ready', true))
        {
            $model->setScenario(CostCalc::SCENARIO_READY);
            $model->validate();
        }

        if (!Yii::$app->request->get('unready', true))
        {
            $model->setScenario(CostCalc::SCENARIO_UNREADY);
            $model->validate();
        }

        return $this->render('general', [
            'model' => $model
        ]);
    }

    public function actionEquip($id)
    {
        $model = $this->findModel($id);

        return $this->render('equip', [
            'model' => $model
        ]);
    }

    public function actionWork($id)
    {
        $model = $this->findModel($id);

        return $this->render('work', [
            'model' => $model
        ]);
    }

    public function actionPays($id)
    {
        $model = $this->findModel($id);

        return $this->render('pays', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = CostCalc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\CostCalc;
use app\models\CostCalcWork;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class CostcalcworkController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Работы в смете';
    const PAGE_TITLE_CREATE = 'Добавить работу в смету';
    const PAGE_TITLE_UPDATE = 'Редактирование работы в смете';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['CostCalcWorkView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['CostCalcWorkUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['CostCalcWorkCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['CostCalcWorkDelete'],
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
    public function actionIndex($id, $ajax = false)
    {
        if ($ajax)
        {
            return $this->renderPartial('index', [
                'costcalc' => $this->findCostCalc($id),
                'ajax' => true
            ]);
        }
        return $this->render('index', [
            'costcalc' => $this->findCostCalc($id)
        ]);
    }

    public function actionCreate($ajax = false)
    {
        $model = new CostCalcWork();

        if (Yii::$app->request->get('id'))
        {
            $model->calc_id = Yii::$app->request->get('id');
        }

        $model->setScenario(CostCalcWork::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['costcalc/work', 'id' => $model->calc_id]);
        }

        if ($ajax)
        {
            return $this->renderPartial('create', [
                'model' => $model,
                'ajax' => true
            ]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenario(CostCalcWork::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/costcalc/view', 'id' => $model->calc_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        try {
            $model->delete();
        }
        catch (\Exception $e)
        {

        }
        return $this->redirect(['costcalc/view', 'id' => $model->calc_id]);
    }

    protected  function findCostCalc($id)
    {
        if (($model = CostCalc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = CostCalcWork::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

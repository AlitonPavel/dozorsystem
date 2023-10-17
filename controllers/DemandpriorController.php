<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\DemandPrior;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class DemandpriorController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Список приоритетов';
    const PAGE_TITLE_CREATE = 'Создать приоритет';
    const PAGE_TITLE_UPDATE = 'Редактирование приоритета';
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
                        'roles' => ['DemandPriorView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['DemandPriorUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['DemandPriorCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['DemandPriorDelete'],
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
        $model = new DemandPrior();
        $model->setScenario(DemandPrior::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/demandprior']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(DemandPrior::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/demandprior']);
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
        if (($model = DemandPrior::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

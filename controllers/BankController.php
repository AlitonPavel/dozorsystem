<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Bank;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class BankController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Список банков';
    const PAGE_TITLE_CREATE = 'Создать банк';
    const PAGE_TITLE_UPDATE = 'Редактирование банка';

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
                        'roles' => ['BankView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['BankUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['BankCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['BankDelete'],
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
        $model = new Bank();
        $model->setScenario(Bank::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/bank']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Bank::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/bank']);
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
        if (($model = Bank::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\controllers;

use app\components\TabController;
use app\models\Demand;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Yii;

class DemandviewController extends TabController
{
    const PAGE_TITLE_INDEX = 'Заявка';

    public $tabParams = ['id'];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->setTabs([
            ['id' => 'index', 'url' => Url::to(array_merge(['/demand/view'], $this->params)), 'title' => 'Общие'],
            ['id' => 'comment', 'url' => Url::to(array_merge(['/demand/comment'], $this->params)), 'title' => 'Комментарии'],
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
                        'roles' => ['DemandView'],
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

    public function actionComment($id)
    {
        return $this->render('comment', [
            'id' => $id
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Demand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\Utils;
use app\models\Demand;
use app\models\DemandComment;
use http\Url;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class DemandcommentController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Комментарии';
    const PAGE_TITLE_CREATE = 'Написать комметарий';
    const PAGE_TITLE_UPDATE = 'Редактирование комментария';

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
                        'roles' => ['DemandCommentView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['DemandCommentUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['DemandCommentCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['DemandCommentDelete'],
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
                'demand' => $this->findDemand($id),
                'ajax' => true
            ]);
        }
        return $this->render('index', [
            'demand' => $this->findDemand($id)
        ]);
    }

    public function actionCreate($ajax = false)
    {
        $model = new DemandComment();

        if (Yii::$app->request->get('id'))
        {
            $model->demand_id = Yii::$app->request->get('id');
        }

        $model->date = date('d.m.Y H:i');
        $model->user_id = Yii::$app->user->getId();

        $model->setScenario(DemandComment::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['demand/comment', 'id' => $model->demand_id]);

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

    public function checkChangeComment(DemandComment $comment)
    {
        if (Yii::$app->user->getId() != $comment->user_id ||
            Utils::date() != strtotime(Utils::toFormatDate($comment->date, Utils::DEFAUL_DATESHORT_FORMAT2)))
        {
            throw new \Exception('Редактировать комментарий можно только свой и написанный текущим днем');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->checkChangeComment($model);

        $model->setScenario(DemandComment::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/demand/comment', 'id' => $model->demand_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        try {
            $this->checkChangeComment($model);
            $model->delete();
        }
        catch (\Exception $e)
        {

        }
        return $this->redirect(['demand/comment', 'id' => $model->demand_id]);
    }

    protected  function findDemand($id)
    {
        if (($model = Demand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = DemandComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

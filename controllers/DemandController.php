<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\Utils;
use app\models\Demand;
use http\Url;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class DemandController extends BaseController
{
    const reqSort       = 'sort';
    const reqDate       = 'date';
    const reqAddress    = 'address';
    const reqMaster     = 'master';
    const reqStatus     = 'status';
    const reqCreator    = 'creator';
    const reqDemantText = 'demandtext';
    const reqDatePlan   = 'dateplan';
    const reqNumber     = 'number';
    const reqHouse      = 'house';
    const reqContact    = 'contact';

    const PAGE_TITLE_INDEX          = 'Список заявок';
    const PAGE_TITLE_CREATE         = 'Создать заявку';
    const PAGE_TITLE_UPDATE         = 'Редактирование заявки';
    const PAGE_TITLE_TOMASTER       = 'Передача заявки';
    const PAGE_TITLE_TODEFERRED     = 'Отложить заявку';
    const PAGE_TITLE_PLAN           = 'Плановая дата';

    protected $sort;
    protected $date;
    protected $address;
    protected $master;
    protected $status;
    protected $creator;
    protected $demandText;
    protected $datePlan;
    protected $number;
    protected $house;
    protected $contact;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['DemandView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['DemandUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['DemandCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['DemandDelete'],
                    ],
                    [
                        'actions' => ['todeferred'],
                        'allow' => true,
                        'roles' => ['DemandUpdate'],
                    ],
                    [
                        'actions' => ['plan'],
                        'allow' => true,
                        'roles' => ['DemandUpdate'],
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

    public function readRequest()
    {
        parent::readRequest(); // TODO: Change the autogenerated stub

        $this->sort = $this->request->get(self::reqSort);
        $this->date = $this->request->get(self::reqDate);
        $this->address = $this->request->get(self::reqAddress);
        $this->master = $this->request->get(self::reqMaster);
        $this->status = $this->request->get(self::reqStatus);
        $this->creator = $this->request->get(self::reqCreator);
        $this->demandText = $this->request->get(self::reqDemantText);
        $this->datePlan = $this->request->get(self::reqDatePlan);
        $this->number = $this->request->get(self::reqNumber);
        $this->house = $this->request->get(self::reqHouse);
        $this->contact = $this->request->get(self::reqContact);
    }

    public function selectData()
    {
        parent::selectData(); // TODO: Change the autogenerated stub

        $this->source = Demand::find()
            ->andWhere('demands.deldate is null')
            ->joinWith('type')
            ->joinWith('prior')
            ->joinWith('object')
            ->joinWith('userMaster');

        if (empty($this->sort))
        {
            $this->source->addOrderBy('demands.id desc');
        }
        else
        {
            $this->source->addOrderBy($this->sort);
        }

        if (!empty($this->date))
        {
            $this->source->andFilterWhere(['=', 'DATE_FORMAT(demands.DATE, \'%Y-%m-%d\')', Utils::toFormatDate($this->date, Utils::DEFAUL_DATESHORT_FORMAT2)]);
        }

        if (!empty($this->address))
        {
            $this->source->andFilterWhere(['like', 'concat(regions.name, streets.name, objects.house)', $this->address]);
        }

        if (!empty($this->master))
        {
            $this->source->andFilterWhere(['=', 'demands.master', $this->master]);
        }

        if (!empty($this->status))
        {
            $this->source->andFilterWhere(['=', 'demands.status', $this->status]);
        }

        if (!empty($this->creator))
        {
            $this->source->andFilterWhere(['like', 'demands.creator', $this->creator]);
        }

        if (!empty($this->demandText))
        {
            $this->source->andFilterWhere(['like', 'demands.demandtext', $this->demandText]);
        }

        if (!empty($this->datePlan))
        {
            $this->source->andFilterWhere(['=', 'DATE_FORMAT(demands.dateplan, \'%Y-%m-%d\')', Utils::toFormatDate($this->datePlan, Utils::DEFAUL_DATESHORT_FORMAT2)]);
        }

        if (!empty($this->number))
        {
            $this->source->andFilterWhere(['=', 'demands.id', $this->number]);
        }

        if (!empty($this->house))
        {
            $this->source->andFilterWhere(['like', 'objects.house', $this->house]);
        }

        if (!empty($this->contact))
        {
            $this->source->andFilterWhere(['like', 'demands.contact', $this->contact]);
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->selectData();

        return $this->render('index', [
            'controller' => $this,
            'source' => $this->source,
        ]);
    }

    public function actionCreate()
    {
        $model = new Demand();
        $model->setScenario(Demand::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!empty($model->master)) {
                $model->datemaster = date('d.m.Y H:i');
                $model->toMaster(null);
            }
            return $this->redirect(['/demand/view', 'id' => $model->id]);
        }
        $model->date = date('d.m.Y H:i');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenario(Demand::SCENARIO_UPDATE);
        $load = $model->load(Yii::$app->request->post());

        if (!empty($model->datemaster)) {
            $model->setScenario(Demand::SCENARIO_TO_MASTER);
        }

        if (!empty($model->datexec)) {
            $model->setScenario(Demand::SCENARIO_EXEC);
        }

        if ($load && $model->save()) {
            return $this->redirect(['/demand/view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionTomaster($id, $partial)
    {
        $model = $this->findModel($id);
        $model->setScenario(Demand::SCENARIO_TO_MASTER);

        if ($model->load(Yii::$app->request->post()) && $model->toMaster(Yii::$app->request->post('comment'))) {
            $this->redirect(['/demandview', 'id' => $model->id]);
        }

        if ($partial)
        {
            return $this->renderPartial('_tomaster', ['model' => $model]);
        }

        $number = ' №' . $model->id;
        $this->view->title = self::PAGE_TITLE_TOMASTER . $number;

        $this->view->params['breadcrumbs'] = [
            SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
            self::PAGE_TITLE_INDEX => ['url' => '/demand'],
            DemandviewController::PAGE_TITLE_INDEX . $number => ['url' => '/demand/view', 'params' => ['id' => $model->id]],
            $this->view->title . ' мастеру' => ['url' => '/demand/update', 'params' => ['id' => $model->id]],
        ];

        return $this->render('_tomaster', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Demand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTodeferred($id, $partial)
    {
        $model = $this->findModel($id);
        $model->setScenario(Demand::SCENARIO_TO_DEFERRED);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = Demand::STATUS_DEFERED;
            if ($model->save()) {
                $this->redirect(['/demandview', 'id' => $model->id]);
            }
        }

        if (Utils::stringToBoolean($partial))
        {
            return $this->renderPartial('_todeferred', ['model' => $model]);
        }

        $number = ' №' . $model->id;
        $this->view->title = self::PAGE_TITLE_TODEFERRED . $number;

        $this->view->params['breadcrumbs'] = [
            SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
            self::PAGE_TITLE_INDEX => ['url' => '/demand'],
            DemandviewController::PAGE_TITLE_INDEX . $number => ['url' => '/demand/view', 'params' => ['id' => $model->id]],
            $this->view->title . ' мастеру' => ['url' => '/demand/update', 'params' => ['id' => $model->id]],
        ];

        return $this->render('_todeferred', ['model' => $model]);
    }

    public function actionUndo($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Demand::SCENARIO_CHANGE_STATUS);
        $model->status = Demand::STATUS_UNDO;
        $model->save();

        return $this->redirect(['/demand/view', 'id' => $id]);
    }

    public function actionNew($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Demand::SCENARIO_CHANGE_STATUS);

        $model->status          = Demand::STATUS_WORK;
        $model->datexec         = null;
        $model->date_deferred   = null;
        $model->reason_deferred = null;

        $model->save();

        return $this->redirect(['/demand/view', 'id' => $id]);
    }

    public function actionPlan($id, $partial)
    {
        $model = $this->findModel($id);
        $model->setScenario(Demand::SCENARIO_PLAN);

        if ($model->load(Yii::$app->request->post()) && $model->plan($model->dateplan, Yii::$app->request->post('comment'))) {
            $this->redirect(['/demandview', 'id' => $model->id]);
        }

        if ($partial)
        {
            return $this->renderPartial('_plan', ['model' => $model]);
        }

        $number = ' №' . $model->id;
        $this->view->title = self::PAGE_TITLE_PLAN . $number;

        $this->view->params['breadcrumbs'] = [
            SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
            self::PAGE_TITLE_INDEX => ['url' => '/demand'],
            DemandviewController::PAGE_TITLE_INDEX . $number => ['url' => '/demand/view', 'params' => ['id' => $model->id]],
            $this->view->title . ' мастеру' => ['url' => '/demand/update', 'params' => ['id' => $model->id]],
        ];

        return $this->render('_plan', ['model' => $model]);
    }
}


<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Equip;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class EquipController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Список оборудования';
    const PAGE_TITLE_CREATE = 'Создать оборудование';
    const PAGE_TITLE_UPDATE = 'Редактирование оборудования';
    const PAGE_TITLE_LOAD = 'Загрузка оборудования из файла';

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
                        'roles' => ['EquipView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['EquipUpdate'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['EquipCreate'],
                    ],
                    [
                        'actions' => ['load'],
                        'allow' => true,
                        'roles' => ['EquipCreate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['EquipDelete'],
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
        $model = new Equip();
        $model->setScenario(Equip::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/equip']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Equip::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/equip']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionLoad()
    {
        if (isset($_FILES['userfile']))
        {
            try {

                if (file_exists($_FILES['userfile']['tmp_name'])) {
                    $file = $_FILES['userfile']['tmp_name'];

                    /**  Identify the type of $inputFileName  **/
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
                    /**  Create a new Reader of the type that has been identified  **/
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    /**  Load $inputFileName to a Spreadsheet Object  **/
                    $reader->setReadDataOnly(true);

                    $spreadsheet = $reader->load($file);

                    $cells = $spreadsheet->getActiveSheet()->getCellCollection();

                    $equips = [];

                    // Далее перебираем все заполненные строки (столбцы B - O)
                    for ($row = 1; $row <= $cells->getHighestRow(); $row++) {
                        $equips[] = [
                            'shortname'     => $cells->get('A' . $row)->getValue(),
                            'model'         => $cells->get('B' . $row)->getValue(),
                            'name'          => $cells->get('A' . $row)->getValue() . ' ' .  $cells->get('B' . $row)->getValue(),
                            'priceLow'      => $cells->get('C' . $row) ? $cells->get('C' . $row)->getValue() : null,
                            'priceHigh'     => $cells->get('D' . $row) ? $cells->get('D' . $row)->getValue() : null,
                            'description'   => $cells->get('E' . $row) ? $cells->get('E' . $row)->getValue() : null,
                        ];
                    }


                    Equip::loadEquipsFromArray($equips);
                }

                return $this->render('load', [
                    'success' => true
                ]);
            }
            catch (\Exception $e)
            {
                throw new \Exception("При загрузке произошла ошибка");
            }
        }

        return $this->render('load');
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Equip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

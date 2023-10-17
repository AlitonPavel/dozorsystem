<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\AddressObject;
use app\models\Region;
use app\models\Street;
use yii\filters\AccessControl;
use Yii;

class FiasController extends BaseController
{
    const PAGE_TITLE_INDEX = 'Адреса ФИАС';

    const url = "D:/fias/";

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
                        'roles' => ['fiasIndex'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function loadFile(string $filename)
    {
        if (file_exists(self::url . $filename)) {
            $file = self::url . $filename;
        } else {
            $file = "../../fias/" . $filename;
        }

        $db = dbase_open($file, 2);

        if ($db) {


            $record_numbers = dbase_numrecords($db);

            $regionPart = [];
            $streetPart = [];

            for ($i = 1; $i <= $record_numbers; $i++) {

                $row = dbase_get_record_with_names($db, $i);

                if ($row['ACTSTATUS'] == '1') {
                    if ($row['REGIONCODE'] != '00') {
                        $regionPart[] = [
                            0 => $row['AOGUID'],
                            1 => trim(iconv('cp866', 'utf-8', $row['FORMALNAME']))
                        ];
                    }
                    if ($row['STREETCODE'] != '0000') {
                        $streetPart[] = [
                            0 => $row['AOGUID'],
                            1 => $row['PARENTGUID'],
                            2 => trim(iconv('cp866', 'utf-8', $row['FORMALNAME'])),
                            3 => trim(iconv('cp866', 'utf-8', $row['SHORTNAME']))
                        ];
                    }
                }

                if (count($regionPart) >= 1000) {
                    Yii::$app->db->createCommand()->batchInsert(
                        Region::tableName(),
                        ['id', 'name'],
                        $regionPart
                    )->execute();

                    $regionPart = [];
                }
                if (count($streetPart) >= 1000) {
                    Yii::$app->db->createCommand()->batchInsert(
                        Street::tableName(),
                        ['id', 'region_id', 'name', 'type'],
                        $streetPart
                    )->execute();

                    $streetPart = [];
                }
            }

            if (count($regionPart) > 0) {
                Yii::$app->db->createCommand()->batchInsert(
                    Region::tableName(),
                    ['id', 'name'],
                    $regionPart
                )->execute();
            }

            if (count($streetPart) > 0) {
                Yii::$app->db->createCommand()->batchInsert(
                    Street::tableName(),
                    ['id', 'region_id', 'name', 'type'],
                    $streetPart
                )->execute();
            }
        }
    }

    public function actionRefresh()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();

            Yii::$app->db->createCommand()->delete('streets')->execute();
            Yii::$app->db->createCommand()->delete('regions')->execute();

            $this->loadFile('ADDROB78.DBF');
            $this->loadFile('ADDROB47.DBF');

            $transaction->commit();
            $this->redirect('/fias');
        }
        catch (\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionFile($file ="", $dir="/")
    {
        $exists = file_exists($file);
        return $this->render('check', ['ex' => $exists, 'dir' => $dir]);
    }
}
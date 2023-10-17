<?php

use app\components\ActiveRecordTable;
use app\components\Table;
use app\controllers\SiteController;
use app\controllers\DemandhistoryController;
use app\models\DemandHistory;
use app\controllers\DemandviewController;

$this->title = DemandhistoryController::PAGE_TITLE_INDEX;

/** @var integer $demand_id */

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandviewController::PAGE_TITLE_INDEX => ['url' => '/demand/view', 'params' => ['id' => $demand_id]],
    $this->title => ['url' => '', 'params' => ['id' => $demand_id]],
];

/** @var \app\components\BaseView $this */

?>

<?php
    $source = DemandHistory::find()
        ->joinWith('type')
        ->joinWith('prior')
        ->joinWith('object')
        ->joinWith('userMaster')
        ->andFilterWhere(['=', 'demand_id', $demand_id])
        ->addOrderBy('demandhistories.dateaction')
?>
<?= ActiveRecordTable::widget([
    'id' => 'demandhistories',
    'query' => $source,
    'pageSize' => 10,
    'columns' => [
        ['name' => 'Дата операции', 'fieldname' => 'dateaction', 'type' => ActiveRecordTable::TYPE_DATETIME, 'filterfield' => "DATE_FORMAT(demands.DATE, '%Y-%m-%d')", 'width' => '150px'],
        ['name' => 'Операция', 'fieldname' => 'action', 'type' => ActiveRecordTable::TYPE_CALC,'calc' => function(DemandHistory $row) {
            return $row->getActionName();
        }],
        ['name' => 'Список изменившихся полей', 'fieldname' => 'diff', 'type' => ActiveRecordTable::TYPE_CALC,'calc' => function(DemandHistory $row, ?DemandHistory $prevRow) {
            $diff = '';
            if ($prevRow && $row) {
                $diff = $row->getDiff($prevRow, $row);
            }
            return '<span style="white-space: pre-line">' . $diff . '</span>';
        }],
        ['name' => 'Было', 'fieldname' => 'diff1', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function(DemandHistory $row, ?DemandHistory $prevRow) {
            $str = '';
            if ($prevRow) {
                $data = $prevRow->toArray();
                foreach ($data as $key => $column) {
                    if (!in_array($key, ['id', 'demand_id', 'street_id', 'deldate', 'dateaction', 'action']) && $prevRow->getAttribute($key) != $row->getAttribute($key)) {
                        if (empty($str))
                        {
                            $str .= $prevRow->getAttributeLabel($key) . ': ' . $column;
                        }
                        else
                        {
                            $str .= "\n" . $prevRow->getAttributeLabel($key) . ': ' . $column;
                        }
                    }
                }
            }
            return '<span style="white-space: pre-line">' . $str . '</span>';
        }],
        ['name' => 'Стало', 'fieldname' => 'diff2', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function(DemandHistory $row, ?DemandHistory $prevRow) {
            $str = '';
            if ($row && $prevRow) {
                $data = $row->toArray();
                foreach ($data as $key => $column) {
                    if (!in_array($key, ['id', 'demand_id', 'street_id', 'deldate', 'dateaction', 'action']) && $prevRow->getAttribute($key) != $row->getAttribute($key)) {
                        if (empty($str))
                        {
                            $str .= $row->getAttributeLabel($key) . ': ' . $column;
                        }
                        else
                        {
                            $str .= "\n" . $row->getAttributeLabel($key) . ': ' . $column;
                        }
                    }
                }
            }
            return '<span style="white-space: pre-line">' . $str . '</span>';
        }],
    ],
]);
?>






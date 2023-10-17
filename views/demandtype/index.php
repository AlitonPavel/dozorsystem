<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\controllers\DemandtypeController;
use app\models\DemandType;

$this->title = DemandtypeController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить тип',
    'href' => Url::to('/demandtype/create')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'dtypetable',
    'query' => DemandType::find()->andWhere('deldate is null'),
    'columns' => [
        ['name' => 'Наименование типа', 'fieldname' => 'name', 'filtercondition' => Table::FILTER_COND_LIKE],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (DemandType $row) {
                /** @var DemandType $row */
                return Url::to(['/demandtype/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (DemandType $row) {
                return Url::to(['/demandtype/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






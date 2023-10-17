<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\controllers\DemandpriorController;
use app\models\DemandPrior;

$this->title = DemandpriorController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить приоритет',
    'href' => Url::to('/demandprior/create')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'dpriortable',
    'query' => DemandPrior::find()->andWhere('deldate is null'),
    'columns' => [
        ['name' => 'Наименование типа', 'fieldname' => 'name'],
        ['name' => 'Дней на выполнение', 'fieldname' => 'leadtime'],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (DemandPrior $row) {
                /** @var DemandPrior $row */
                return Url::to(['/demandprior/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (DemandPrior $row) {
                return Url::to(['/demandprior/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






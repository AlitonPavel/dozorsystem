<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\models\DemandPrior;
use app\controllers\BankController;
use app\models\Bank;

$this->title = BankController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить банк',
    'href' => Url::to('/bank/create')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'banks',
    'query' => Bank::find()->andWhere('deldate is null'),
    'columns' => [
        ['name' => 'Наименование', 'fieldname' => 'name', 'width' => '400px'],
        ['name' => 'Реквизиты', 'fieldname' => 'bic', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function(Bank $row) {
            return $row->getRequisites();
        }],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION,'buttons' => [
            Table::BTN_EDIT => function (Bank $row) {
                return Url::to(['/bank/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (Bank $row) {
                return Url::to(['/bank/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






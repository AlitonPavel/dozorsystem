<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\ClientController;
use app\models\Client;
use app\controllers\SiteController;

$this->title = ClientController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить клиента',
    'href' => Url::to('/client/create')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'clienttable',
    'query' => Client::find(),
    'columns' => [
        ['name' => 'Наименование', 'fieldname' => 'name', 'width' => '300px'],
        ['name' => 'Реквизиты', 'fieldname' => 'companydetails', 'type' => ActiveRecordTable::TYPE_CALC,'calc' => function(Client $row) {
            return '<span style="white-space: pre-line">' . $row->getCompanyDetails() . '</span>';
        }],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (Client $row) {
                /** @var Client $row */
                return Url::to(['/client/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (Client $row) {
                return Url::to(['/client/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






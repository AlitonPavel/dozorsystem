<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\models\Client;
use app\controllers\SiteController;
use app\controllers\ObjectController;
use app\models\Objects;
use app\components\Filter;

$this->title = ObjectController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить объект',
    'href' => Url::to('/object/create')
]); ?>
<br />

<?= ActiveRecordTable::widget([
    'id' => 'objecttable',
    'query' => $source,
    'enableFilters' => true,
    'filters' => [
        'name' => ['filterfield' => 'concat(regions.name, streets.name, objects.house)', 'reqName' => 'address', 'filtercondition' => Filter::FILTER_CONDITION_LIKE],
    ],
    'columns' => [
        ['name' => 'Адрес, Клиент, Менеджер', 'fieldname' => 'name', 'type' => ActiveRecordTable::TYPE_CALC, 'width' => '400px', 'alias' => 'streets', 'filterfield' => 'concat(regions.name, streets.name, objects.house)',
            'calc' => function (Objects $row) {
            $html = '<a data-pjax="0" href="' . Url::to(['/object/view', 'id' => $row->id]) . '">' . $row->getAddress() . '</a>';
            if (!empty($row->client)) {
                $html .= '<br /><a href="' . Url::to(['/client/update', 'id' => $row->client->id]) . '">' . (isset($row->client->name) ? $row->client->name : 'неизвестно') . '</a>';
            }
            if (!empty($row->userManager)) {
                $html .= '<br />Менеджер: ' . $row->userManager->getFIO();
            }
            return $html;
        }, 'filtercondition' => Table::FILTER_COND_LIKE],
        ['name' => 'Вид обслуживания', 'fieldname' => 'is_service', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function($row) {
            return $row->getServiceText();
        }],
        ['name' => 'Действие', 'fieldname' => 'buttons', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (Objects $row) {
                /** @var Client $row */
                return Url::to(['/object/view', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (Objects $row) {
                return Url::to(['/object/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






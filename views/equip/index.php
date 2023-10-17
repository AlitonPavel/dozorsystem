<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\models\DemandPrior;
use app\controllers\BankController;
use app\models\Bank;
use app\controllers\EquipController;
use app\models\Equip;

$this->title = EquipController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */

?>
<div class="grid">
    <div class="row">
        <div class="column">
            <?= Button::widget([
                'id' => 'btn_add',
                'value' => 'Добавить оборудование',
                'href' => Url::to('/equip/create')
            ]); ?>
        </div>
        <div class="column">
            <?= Button::widget([
                'id' => 'btn_load',
                'value' => 'Загрузить оборудование из файла',
                'href' => Url::to('/equip/load')
            ]); ?>
        </div>
    </div>
</div>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'equips',
    'query' => Equip::find()->andWhere('deldate is null'),
    'columns' => [
        ['name' => 'Наименование', 'fieldname' => 'name', 'type' => ActiveRecordTable::TYPE_CALC, 'width' => '400px', 'calc' => function(Equip $row) {
            return '<a data-pjax="0" href="' . Url::to(['equip/update', 'id' => $row->id]). '">' . $row->name . '</a>';
        }],
        ['name' => 'Примечание', 'fieldname' => 'note', 'width' => '200px'],
        ['name' => 'Себестоимость', 'fieldname' => 'pricelow', 'type' => 'money', 'width' => '400px'],
        ['name' => 'Цена для клиента', 'fieldname' => 'pricehigh', 'type' => 'money', 'width' => '400px'],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (Equip $row) {
                return Url::to(['/equip/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (Equip $row) {
                return Url::to(['/equip/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






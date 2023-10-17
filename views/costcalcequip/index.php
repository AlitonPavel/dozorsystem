<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\controllers\SiteController;
use app\controllers\CostcalcequipController;
use app\models\CostCalcEquip;
use app\components\Utils;

if (!isset($ajax))
{
    $this->title = CostcalcequipController::PAGE_TITLE_INDEX;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        $this->title => ['url' => ''],
    ];
}

/** @var \app\components\BaseView $this */

?>
<?php if(!isset($ajax)) { ?>
    <h1>Оборудование в смете №<?= $costcalc->id; ?></h1>
<?php } ?>
<br />
<?php
    $equiplowsum = Utils::formatBaseToFormatMoney($costcalc->equiplowsum);
    $equiphighsum = Utils::formatBaseToFormatMoney($costcalc->equiphighsum);

    $html = <<<HTML
        <tr class="aggregates" style="font-weight: bold">
            <td colspan="4" style="text-align: right">Всего себестоимость оборудования в смете:</td>
            <td colspan="4">$equiplowsum</td>
        </tr>        
        <tr class="aggregates" style="font-weight: bold">
            <td colspan="4" style="text-align: right">Всего стоимость оборудования в смете:</td>
            <td colspan="4">$equiphighsum</td>
        </tr>
HTML;
    $header = <<<HTML
        <tr class="aggregates">
            <td colspan="7" style="text-align: center; font-weight: bold">Оборудование</td>    
        </tr>
HTML;
?>

<?= ActiveRecordTable::widget([
    'id' => 'banks',
    'showAggregates' => true,
    'showGlobalAggregates' => true,
    'showCustomHeader' => true,
    'query' => \app\models\CostCalcEquip::find()
                    ->joinWith('equip')
                    ->andWhere('costcalcequips.deldate is null')
                    ->andWhere(['costcalcequips.calc_id' => $costcalc->id])
                    ->addOrderBy('costcalcequips.id'),
    'columns' => [
        ['name' => 'Оборудование', 'fieldname' => 'equip_id', 'width' => '250px', 'type' => ActiveRecordTable::TYPE_CALC,'calc' => function(CostCalcEquip $row) {
            return isset($row->equip) ? $row->equip->name : '';
        }],
        ['name' => 'Кол-во', 'fieldname' => 'quant', 'type' => ActiveRecordTable::TYPE_MONEY, 'width' => '100px'],
        ['name' => 'Себестоимость', 'fieldname' => 'pricelow', 'type' => 'money', 'width' => '100px'],
        ['name' => 'Стоимость', 'fieldname' => 'pricehigh', 'type' => 'money', 'width' => '100px'],
        ['name' => 'Всего Себестоимость', 'fieldname' => 'pricelowsum', 'type' => 'money', 'width' => '100px', 'aggregates' =>
            [
                ['caption' => 'Всего:', 'type' => ActiveRecordTable::TYPE_MONEY, 'calc' => function($aggregatedValue, $currentValue) {
                    return $aggregatedValue +  $currentValue;
                }]
            ]
        ],
        ['name' => 'Всего Стоимость', 'fieldname' => 'pricehighsum', 'type' => 'money', 'width' => '100px', 'aggregates' =>
            [
                ['caption' => 'Всего:', 'type' => ActiveRecordTable::TYPE_MONEY, 'calc' => function($aggregatedValue, $currentValue) {
                    return $aggregatedValue +  $currentValue;
                }]
            ]
        ],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'width' => '50px', 'buttons' => [
            Table::BTN_EDIT => function (CostCalcEquip $row) {
                return Url::to(['/costcalcequip/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (CostCalcEquip $row) {
                return Url::to(['/costcalcequip/delete', 'id' => $row->id]);
            },
        ],
        ]
    ],
    'htmlGlobalAggregates' => $html,
    'htmlCustomHeader' => $header,
]);
?>






<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\controllers\SiteController;
use app\models\CostCalcEquip;
use app\components\Utils;
use app\controllers\CostcalcworkController;
use app\models\CostCalcWork;

if (!isset($ajax))
{
    $this->title = CostcalcworkController::PAGE_TITLE_INDEX;

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
    $worklowsum = Utils::formatBaseToFormatMoney($costcalc->worklowsum);
    $workhighsum = Utils::formatBaseToFormatMoney($costcalc->workhighsum);

    $html = <<<HTML
        <tr class="aggregates" style="font-weight: bold">
            <td colspan="4" style="text-align: right">Всего себестоимость ФОТ в смете:</td>
            <td colspan="4">$worklowsum</td>
        </tr>        
        <tr class="aggregates" style="font-weight: bold">
            <td colspan="4" style="text-align: right">Всего стоимость ФОТ в смете:</td>
            <td colspan="4">$workhighsum</td>
        </tr>
HTML;
    $header = <<<HTML
        <tr class="aggregates">
            <td colspan="7" style="text-align: center; font-weight: bold">Фонд оплаты труда</td>    
        </tr>
HTML;
?>

<?= ActiveRecordTable::widget([
    'id' => 'twork',
    'showAggregates' => true,
    'showGlobalAggregates' => true,
    'showCustomHeader' => true,
    'query' => CostCalcWork::find()
                    ->andWhere('costcalcworks.deldate is null')
                    ->andWhere(['costcalcworks.calc_id' => $costcalc->id])
                    ->addOrderBy('costcalcworks.id'),
    'columns' => [
        ['name' => 'Наименование работ', 'fieldname' => 'name', 'width' => '250px', 'type' => ActiveRecordTable::TYPE_TEXT],
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
            Table::BTN_EDIT => function (CostCalcWork $row) {
                return Url::to(['/costcalcwork/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (CostCalcWork $row) {
                return Url::to(['/costcalcwork/delete', 'id' => $row->id]);
            },
        ],
        ]
    ],
    'htmlGlobalAggregates' => $html,
    'htmlCustomHeader' => $header,
]);
?>






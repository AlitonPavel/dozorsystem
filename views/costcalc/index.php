<?php

use app\components\ActiveRecordTable;
use app\components\Form;
use app\components\SelectInput;
use app\components\Utils;
use app\controllers\DemandController;
use app\controllers\SuggestController;
use app\models\Demand;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\controllers\CostcalcController;
use app\models\CostCalc;

if (!$ajax) {
    $this->title = CostcalcController::PAGE_TITLE_INDEX;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        $this->title => ['url' => ''],
    ];
}
/** @var \app\components\BaseView $this */

?>
<?php if ($ajax) { ?>
    <br />
<?php } ?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить КП',
    'href' => Url::to('/costcalc/create')
]); ?>
<br />
<?php if (!$ajax) { ?>

<div class="filter_panel">
    <?php
    $form = Form::begin([
        'id' => 'search_form',
        'button' => false,
        'action' => Url::to([]),
        'method' => 'GET'
    ]);
    ?>
    <div class="grid">
        <div class="row">
            <div class="column">
                <?php
                echo SelectInput::widget(['id' => 'type', 'name' => CostcalcController::reqType, 'caption' => 'Тип', 'width' => '180px', 'items' => [
                    ['id' => 1, 'name' => 'Коммерческое предложение'],
                    ['id' => 2, 'name' => 'Смета'],
                ]]);
                ?>
            </div>
            <div class="column">
                <?= SelectInput::widget(['id' => 'user', 'name' => CostcalcController::reqUser, 'caption' => 'Составитель', 'width' => '180px', 'items' => SuggestController::getUsersForSelectInput()]); ?>
            </div>
        </div>
        <div class="row">
            <div class="column" style="float: right">
                <div class="column">
                    <?= Button::widget(['id' => 'search', 'value' => 'Поиск']); ?>
                </div>
                <div class="column">
                    <?= Button::widget(['id' => 'clear', 'value' => 'Сбросить фильтры', 'type' => 'button']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Form::end(); ?>
</div>
<br />
<?php } ?>
<?= ActiveRecordTable::widget([
    'id' => 'costcalctable',
    'query' => $source,
    'columns' => [
        ['name' => '', 'fieldname' => 'id', 'width' => '150px', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (CostCalc $row) {
            $html = '<a data-pjax="0" href="' . Url::to(['/costcalc/view', 'id' => $row->id]) . '">' . "Номер: " . $row->id . '</a>';
            $html .= "<br />" . $row->getTypeName();
            $html .= "<br />" . Utils::dateToFormat($row->date, Utils::isDate($row->date), Utils::DEFAULT_DATE_FORMAT);
            $html .= "<br />Приоритет: " . $row->prior->name;
            return $html;
        }],
        ['name' => "Наименование работ, Адрес, Примечание", 'fieldname' => 'name', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (CostCalc $row) {
            $html = $row->name;
            $html .= (isset($row->object) ? "<br />" . $row->object->getAddress() : '');
            $html .= "<br />" . $row->note;
            return $html;
        }],
        ['name' => 'Составитель', 'fieldname' => 'user', 'width' => '120px', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (CostCalc $row) {
            return (isset($row->user) ? $row->user->getFIO() : '');
        }],
        ['name' => 'Действие', 'width' => '80px', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_EDIT => function (CostCalc $row) {
                /** @var CostCalc $row */
                return Url::to(['/costcalc/view', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (CostCalc $row) {
                return Url::to(['/costcalc/delete', 'id' => $row->id]);
            },
        ],
        ]
    ],
    'rowAddClass' => function (CostCalc $row) {
        if (empty($row->dateready))
        {
            return 'status_new';
        }
        else
        {
            return 'status_exec';
        }

    }
]);
?>

<?php

$colorStatusNew         = Demand::statusesColors[Demand::STATUS_NEW];
$colorStatusWork        = Demand::statusesColors[Demand::STATUS_WORK];
$colorStatusDeferred    = Demand::statusesColors[Demand::STATUS_DEFERED];
$colorStatusExec        = Demand::statusesColors[Demand::STATUS_EXEC];
$colorStatusUndo        = Demand::statusesColors[Demand::STATUS_UNDO];

$css = <<<EOF
        .status_new {
        background-color: $colorStatusNew
        }
        .status_work {
        background-color: $colorStatusWork
        }
        .status_deferred {
        background-color: $colorStatusDeferred
        }
        .status_exec {
        background-color: $colorStatusExec
        }
        .status_undo {
        background-color: $colorStatusUndo
        }
EOF;

$this->registerCss($css);

?>






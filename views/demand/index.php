<?php

use app\components\ActiveRecordTable;
use app\components\Form;
use app\controllers\SuggestController;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\models\Demand;
use app\controllers\DemandController;
use app\components\Utils;
use app\components\DateInput;
use app\components\InputText;
use app\components\SelectInput;

$this->title = DemandController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

/** @var \app\components\BaseView $this */
/** @var DemandController $controller */

?>


<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Создать заявку',
    'href' => Url::to('/demand/create'),
    'target' => '_blank'
]); ?>
<br/>
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
                <?= DateInput::widget(['id' => 'date', 'caption' => 'Дата рег.', 'width' => '120px']); ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'search_number', 'name' => DemandController::reqNumber, 'caption' => 'Номер', 'width' => '120px']); ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <?= InputText::widget(['id' => 'search_address', 'name' => DemandController::reqAddress, 'caption' => 'Адрес', 'width' => '320px']); ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'search_house', 'name' => DemandController::reqHouse, 'caption' => 'Дом', 'width' => '80px']); ?>
            </div>
            <div class="column">
                <?= SelectInput::widget(['id' => 'master', 'name' => DemandController::reqMaster, 'caption' => 'Исполнитель', 'width' => '180px', 'items' => SuggestController::getUsersForSelectInput()]); ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <?= InputText::widget(['id' => 'search_creator', 'name' => DemandController::reqCreator, 'caption' => 'Заявитель', 'width' => '120px']); ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'search_contact', 'name' => DemandController::reqContact, 'caption' => 'Контакты', 'width' => '120px']); ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'search_demandtext', 'name' => DemandController::reqDemantText, 'caption' => 'Текс заявки', 'width' => '408px']); ?>
            </div>
            <div class="column">
                <b><?= DateInput::widget(['id' => 'search_dateplan', 'name' => DemandController::reqDatePlan, 'caption' => 'План. дата', 'width' => '120px']); ?></b>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <?= SelectInput::widget(['id' => 'status', 'name' => DemandController::reqStatus, 'caption' => 'Статус', 'width' => '180px', 'items' => SuggestController::getStatusesForSelectInput()]); ?>
            </div>
            <div class="column">
                <?php
                    echo SelectInput::widget(['id' => 'sort', 'name' => DemandController::reqSort, 'caption' => 'Сортировать по полю', 'width' => '180px', 'items' => [
                            ['id' => 'id', 'name' => 'Номер &darr;'],
                            ['id' => 'id desc', 'name' => 'Номер &uarr;'],
                            ['id' => 'status', 'name' => 'Статус &darr;'],
                            ['id' => 'status desc', 'name' => 'Статус &uarr;'],
                            ['id' => 'demandtypes.name', 'name' => 'Тип &darr;'],
                            ['id' => 'demandtypes.name desc', 'name' => 'Тип &uarr;'],
                            ['id' => 'demandpriors.name', 'name' => 'Приоритет &darr;'],
                            ['id' => 'demandpriors.name desc', 'name' => 'Приоритет &uarr;'],
                            ['id' => 'users.surname', 'name' => 'Исполнитель &darr;'],
                            ['id' => 'users.surname desc', 'name' => 'Исполнитель &uarr;'],
                            ['id' => 'datexec', 'name' => 'Дата выполнения &darr;'],
                            ['id' => 'datexec desc', 'name' => 'Дата выполнения &uarr;'],
                    ]]);
                ?>
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
<br/>
<?= ActiveRecordTable::widget([
    'id' => 'demandtable',
    'query' => $source,
    'pageSize' => 10,
    'columns' => [
        ['name' => '', 'fieldname' => 'id', 'width' => '150px', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (Demand $row) {
            $html = '<a data-pjax="0" href="' . Url::to(['/demand/view', 'id' => $row->id]) . '">' . "Номер: " . $row->id . '</a>';
            $html .= "<br />Статус: " . $row->getStatusText();
            $html .= "<br />" . Utils::dateToFormat($row->date, Utils::isDate($row->date), Utils::DEFAULT_DATE_FORMAT);
            $html .= "<br />Тип: " . $row->type->name;
            $html .= "<br />Приоритет: " . $row->prior->name;
            return $html;
        }],
        ['name' => 'Адрес, заявитель и текст заявки', 'fieldname' => 'object', 'type' => ActiveRecordTable::TYPE_CALC, 'filterfield' => 'concat(regions.name, streets.name, objects.house)', 'width' => '400px', 'calc' => function (Demand $row) {
            if ($row->object) {
                $html = '<a href="' . Url::to(['object/view', 'id' => $row->object->id]) . '">' . $row->object->getAddress() . '</a>';
            } else {
                $html = $row->address;
            }
            $html .= "<br />" . $row->creator;
            $html .= "<br /><i>" . $row->demandtext . '</i>';
            return $html;
        }],
        ['name' => 'Исполнитель', 'fieldname' => 'master', 'width' => '120px', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (Demand $row) {
            return (isset($row->userMaster) ? $row->userMaster->getFIO() : '');
        }],
        ['name' => 'Предельная дата', 'fieldname' => 'deadline', 'width' => '120px', 'type' => ActiveRecordTable::TYPE_CALC, 'calc' => function (Demand $row) {
            $html = Utils::dateToFormat($row->deadline, Utils::isDate($row->deadline), Utils::DEFAULT_DATE_FORMAT);
            $html .= "<br />Плановая дата: " . Utils::dateToFormat($row->dateplan, Utils::isDate($row->dateplan), Utils::DEFAUL_DATESHORT_FORMAT);
            $html .= "<br />Дата выполнения: " . Utils::dateToFormat($row->datexec, Utils::isDate($row->datexec), Utils::DEFAULT_DATE_FORMAT);
            return $html;
        }],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'width' => '40px', 'buttons' => [
            Table::BTN_EDIT => function (Demand $row) {
                /** @var Demand $row */
                return Url::to(['/demand/view', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (Demand $row) {
                return Url::to(['/demand/delete', 'id' => $row->id]);
            },
        ],
        ],
    ],
    'rowAddClass' => function (Demand $row) {
        switch ($row->getStatus()) {
            case Demand::STATUS_NEW:
                return 'status_new';
                break;
            case Demand::STATUS_WORK:
                return 'status_work';
                break;
            case Demand::STATUS_DEFERED:
                return 'status_deferred';
                break;
            case Demand::STATUS_EXEC:
                return 'status_exec';
                break;
            case Demand::STATUS_UNDO:
                return 'status_undo';
                break;
            default:
                return '';
        }
    }
]);
?>

<?php

$url = json_encode(Url::to([]));

$js = <<<EOF
    $(document).ready(function() {
        $("#clear").on('click', function() {
            event.preventDefault();
            $("#search_form input").val("");
            $('select').prop('selectedIndex',0);
            $("#search").click();
        });
        $("#search_form").on('submit', function() {
            event.preventDefault();
            $.pjax.reload({
                container: '#pjax_demandtable',
                type       : 'GET',
                url        : {$url},
                data       : $('#search_form').serializeArray(),
                push       : true,
                replace    : true,
                timeout    : 1000,
            });
        });
    });
EOF;

$this->registerJs($js);

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





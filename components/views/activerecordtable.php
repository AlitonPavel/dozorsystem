<?php

/** @var \app\components\ActiveRecordTable $widget */
/** @var \app\components\BaseView $this */
/** @var \yii\data\Pagination $paginator */

$this->registerCssFile('@web/css/components/table.css');
$this->registerJsFile('@web/js/components/table.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\components\Utils;
use app\components\Table;
use app\components\LinkPager;

?>
<?php Pjax::begin(['id' => $widget->getPjaxId()]); ?>
<form autocomplete="off" data-pjax="1" action="<?= Url::to([]) ?>">
    <table id="<?= $widget->id ?>" cellpadding="0" cellspacing="0" class="table">
        <thead>
        <tr>
            <?php foreach ($widget->columns as $column) { ?>
                <?php if (!(isset($column['hidden']) && $column['hidden'])) { ?>
                    <td><?= isset($column['name']) ? $column['name'] : '#' ?></td>
                <?php } ?>
            <?php } ?>
        </tr>
        <?php if ($widget->enableFilters) { ?>

            <tr class="table_filters">
                <?php foreach ($widget->columns as $column) { ?>
                    <?php if (!(isset($column['hidden']) && $column['hidden'])) { ?>
                        <td class="table_filters_filter">
                            <input autocomplete="off" type="text"
                                   name="<?= (isset($column['alias']) ? $column['alias'] . '_' : ''), $column['fieldname'] ?>"
                                   value="<?= isset($column['filtervalue']) ? $column['filtervalue'] : '' ?>">
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>
        </thead>
        <tbody>

        <?php foreach ($widget->data as $row) { ?>
            <?php
            /** @var \app\components\BaseActiveRecord $prevRow */
            $func = $widget->rowAddClass;
            $classRow = !empty($func) ? $func($row) : '' ?>
            <tr class="<?= $classRow ?>">

                <?php foreach ($widget->columns as $column) { ?>
                    <?php if (!(isset($column['hidden']) && $column['hidden'])) { ?>
                        <td style="<?= (isset($column['width']) ? 'width: ' . $column['width'] : '') ?>">
                            <?php
                            if (isset($column['action']) && isset($column['action'][Table::BTN_INSERT])) {
                                $url = $column['action'][Table::BTN_INSERT]($row);
                                ?>
                                <a data-pjax="0" href="<?= $url ?>" class="table_action">
                                        <span>
                                            <img src="/web/images/dot.gif" title="Вставить"
                                                 class="table_icon table_icon_ins">
                                        </span>
                                </a>
                                <?php
                            }
                            if (isset($column['action']) && isset($column['action'][Table::BTN_EDIT])) {
                                $url = $column['action'][Table::BTN_EDIT]($row);
                                ?>
                                <a data-pjax="0" href="<?= $url ?>" class="table_action">
                        <span>
                            <img src="/web/images/dot.gif" title="Изменить"
                                 class="table_icon table_icon_edit">
                        </span>
                                </a>
                                <?php
                            }
                            if (isset($column['action']) && isset($column['action'][Table::BTN_DELETE])) {
                                $url = $column['action'][Table::BTN_DELETE]($row);
                                ?>
                                <a data-pjax="0" href="<?= $url ?>" data-method="post">
                            <span>
                                <img src="/web/images/dot.gif" title="Удалить"
                                     class="table_icon table_icon_del">
                            </span>
                                </a>

                                <?
                            }

                            if (isset($column['value'])) {
                                echo $column['value']($row, $prevRow);
                            } else if (isset($column['fieldname']) && !empty($column['fieldname'])) {
                                if (isset($column['type']) && $column['type'] == 'date') {
                                    echo Utils::dateFormat($row->{$column['fieldname']}, Utils::DEFAULT_DATE_FORMAT);
                                } else if (isset($column['type']) && $column['type'] == 'money') {
                                    echo Utils::formatBaseToFormatMoney($row->{$column['fieldname']});
                                } else {
                                    echo $row->{$column['fieldname']};
                                }

                            }
                            ?>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php
                $prevRow = $row;
            }
        ?>
        </tbody>
    </table>
    <?= LinkPager::widget(['pagination' => $paginator]); ?>
    <input id="<?= $widget->getSubmitId(); ?>" type="submit" style="display: none; visibility: hidden">
</form>
<?php Pjax::end(); ?>


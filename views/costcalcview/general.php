<?php

use app\components\Button;
use app\components\Form;
use app\components\InputText;
use app\components\Utils;
use app\controllers\SiteController;
use app\controllers\CostcalcController;
use app\controllers\CostcalcviewController;
use app\components\TextArea;
use app\controllers\SuggestController;
use yii\helpers\Url;

/** @var \app\models\CostCalc $model */

$this->title = $model->getTypeName() . ' №' . $model->id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];

$this->registerCssFile('@web/css/components/table.css');

?>
<div class="grid">
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= InputText::widget(['id' => 'number', 'caption' => $model->getAttributeLabel('id'), 'value' => $model->id, 'readOnly' => true]); ?>
                </div>
                <div class="column">
                    <?= InputText::widget(['id' => 'date', 'caption' => $model->getAttributeLabel('date'), 'value' => Utils::toFormatDate($model->date, Utils::DEFAUL_DATESHORT_FORMAT), 'readOnly' => true]) ?>
                </div>
            </div>
            <div class="row">
                <?= InputText::widget(['id' => 'name', 'width' => '400px', 'caption' => $model->getAttributeLabel('name'), 'value' => $model->name, 'readOnly' => true]); ?>
            </div>
            <div class="row">
                <?= InputText::widget(['id' => 'object_id', 'width' => '600px', 'caption' => $model->getAttributeLabel('object_id'), 'value' => isset($model->object) ? $model->object->getAddress() : '', 'readOnly' => true]); ?>
            </div>
            <div class="row">
                <?= InputText::widget(['id' => 'client_id', 'width' => '600px', 'caption' => $model->getAttributeLabel('client_id'), 'value' => isset($model->client) ? $model->client->name : '', 'readOnly' => true]); ?>
            </div>
            <div class="row">
                <div class="column">
                    <?= InputText::widget(['id' => 'contactFIO', 'width' => '200px', 'caption' => $model->getAttributeLabel('contactFIO'), 'value' => $model->contactFIO]) ?>
                </div>
                <div class="column">
                    <?= InputText::widget(['id' => 'contact', 'width' => '200px', 'caption' => $model->getAttributeLabel('contact'), 'value' => $model->contact]) ?>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <?= InputText::widget(['id' => 'user_id', 'width' => '300px', 'caption' => $model->getAttributeLabel('user_id'), 'value' => isset($model->user) ? $model->user->getFIO() : '', 'readOnly' => true]); ?>
                </div>
                <div class="column">
                    <?= InputText::widget(['id' => 'dateready', 'caption' => $model->getAttributeLabel('dateready'), 'value' => Utils::toFormatDate($model->dateready, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
                </div>
            </div>
        </div>
        <div class="column" style="float: right">
            <div class="row">
                <?= InputText::widget(['id' => 'typepay', 'width' => '300px', 'caption' => $model->getAttributeLabel('typepay'), 'value' => $model->typepay, 'readOnly' => true]); ?>
            </div>
            <div class="row">
                <?= InputText::widget(['id' => 'planpay', 'width' => '300px', 'caption' => $model->getAttributeLabel('planpay'), 'value' => $model->planpay, 'readOnly' => true]); ?>
            </div>
            <div class="row">
                <?= InputText::widget(['id' => 'prior_id', 'width' => '300px', 'caption' => $model->getAttributeLabel('prior_id'), 'value' => (isset($model->prior) ? $model->prior->name : ''), 'readOnly' => true]); ?>
            </div>
            <div class="row">
<!--                --><?//= InputText::widget(['id' => 'typepay', 'width' => '300px', 'caption' => $model->getAttributeLabel('typepay'), 'value' => $model->typepay, 'readOnly' => true]); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <?= TextArea::widget(['id' => 'note', 'readOnly' => true, 'caption' => $model->getAttributeLabel('note'), 'value' => $model->note, 'width' => '100%', 'height' => '50px']); ?>
    </div>
    <div class="row">
        <div class="input_error"><?= $model->getFirstError('dateready') ?></div>
    </div>
    <div class="row">
        <div class="column">
            <?= Button::widget([
                'id' => 'btn_edit_calc',
                'value' => 'Изменить',
                'href' => \yii\helpers\Url::to(['/costcalc/update', 'id' => $model->id])
            ]); ?>
        </div>
        <?php if (empty($model->dateready)) { ?>
            <div class="column">
                <?= Button::widget([
                    'id' => 'btn_ready_calc',
                    'value' => 'Проставить готовность',
                    'href' => \yii\helpers\Url::to(['/costcalc/ready', 'id' => $model->id])
                ]); ?>
            </div>
        <?php } else { ?>
            <div class="column">
                <?= Button::widget([
                    'id' => 'btn_ready_calc',
                    'value' => 'Снять готовность',
                    'href' => \yii\helpers\Url::to(['/costcalc/unready', 'id' => $model->id])
                ]); ?>
            </div>
        <?php } ?>
        <div class="column" style="float: right">
            <?= Button::widget([
                'id' => 'btn_print_calc',
                'value' => 'Печать',
                'href' => \yii\helpers\Url::to(['/costcalc/print', 'id' => $model->id])
            ]); ?>
        </div>
    </div>
</div>
<br />
<style>
    .costcalcitogo td {
        text-align: center;
    }
</style>
<table class="table costcalcitogo" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">Оборудование</td>
        </tr>
        <tr>
            <td width="50%">Себестоимость</td>
            <td>Стоимость</td>
        </tr>
        <tr>
            <td><?= Utils::formatBaseToFormatMoney($model->equiplowsum) ?></td>
            <td><?= Utils::formatBaseToFormatMoney($model->equiphighsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right">Оборудование прибыль:</td>
            <td style="text-align: left"><?= Utils::formatBaseToFormatMoney($model->equiphighsum - $model->equiplowsum); ?></td>
        </tr>
        <tr>
            <td style="text-align: right">Оборудование марж. прибыль:</td>
            <td style="text-align: left"><?= ($model->equiphighsum != 0) ? Utils::toFormatMoney(round((1 - $model->equiplowsum/$model->equiphighsum)*100, 2)) : 0; ?>%</td>
        </tr>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">ФОТ</td>
        </tr>
        <tr>
            <td width="50%">Себестоимость</td>
            <td>Стоимость</td>
        </tr>
        <tr>
            <td><?= Utils::formatBaseToFormatMoney($model->worklowsum) ?></td>
            <td><?= Utils::formatBaseToFormatMoney($model->workhighsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right">ФОТ прибыль:</td>
            <td style="text-align: left"><?= Utils::formatBaseToFormatMoney($model->workhighsum - $model->worklowsum); ?></td>
        </tr>
        <tr>
            <td style="text-align: right">ФОТ марж. прибыль:</td>
            <td style="text-align: left"><?= ($model->workhighsum != 0) ? Utils::toFormatMoney(round((1 - $model->worklowsum/$model->workhighsum)*100, 2)) : 0; ?>%</td>
        </tr>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">Пуско-наладочные работы <i>(включено в ФОТ)</i></td>
        </tr>
        <tr>
            <td width="50%">Себестоимость</td>
            <td>Стоимость</td>
        </tr>
        <tr>
            <td><?= Utils::formatBaseToFormatMoney($model->startlowsum) ?></td>
            <td><?= Utils::formatBaseToFormatMoney($model->starthighsum) ?></td>
        </tr>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">Транспортные расходы <i>(включено в ФОТ)</i></td>
        </tr>
        <tr>
            <td width="50%">Себестоимость</td>
            <td>Стоимость</td>
        </tr>
        <tr>
            <td><?= Utils::formatBaseToFormatMoney($model->farelowsum) ?></td>
            <td><?= Utils::formatBaseToFormatMoney($model->farehighsum) ?></td>
        </tr>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">Проектная документация <i>(включено в ФОТ)</i></td>
        </tr>
        <tr>
            <td width="50%">Себестоимость</td>
            <td>Стоимость</td>
        </tr>
        <tr>
            <td><?= Utils::formatBaseToFormatMoney($model->projectlowsum) ?></td>
            <td><?= Utils::formatBaseToFormatMoney($model->projecthighsum) ?></td>
        </tr>
        <tr>
            <td class="aggregates" colspan="2" style="font-weight: bold;">Итого</i></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Скидка:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->discount) ?>%</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Себестоимость:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->lowsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Стоимость без скидки:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->withoutdiscountsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Итоговая стоимость договора:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->highsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Прибыль:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->profitsum) ?></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Марж.прибыль:</td>
            <td style="font-weight: bold"><?= Utils::formatBaseToFormatMoney($model->profitpercent) ?></td>
        </tr>
    </tbody>
</table>
<br />
<div class="grid">
    <div class="row">
        <div class="column">
            <?= Button::widget([
                'id' => 'btn_edit_details',
                'value' => 'Редактировать Доп. информацию',
                'href' => \yii\helpers\Url::to(['/costcalc/details', 'id' => $model->id])
            ]); ?>
        </div>
    </div>
</div>

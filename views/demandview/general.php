<?php

use app\components\Form;
use app\controllers\SiteController;
use app\controllers\DemandviewController;
use app\components\InputText;
use app\components\TextArea;
use app\controllers\DemandController;
use app\components\Utils;
use app\components\Button;
use app\components\DateTimeInput;
use  yii\helpers\Url;
use app\models\Demand;

/** @var \app\models\Demand $model */

$this->title = DemandviewController::PAGE_TITLE_INDEX . ' №' . $model->id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandController::PAGE_TITLE_INDEX => ['url' => '/demand'],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];

$text = "Заявитель: " . $model->creator .
    "\nКонтакт: " . $model->contact .
    "\nТекст заявки:\n" . $model->demandtext;

?>

<div class="grid">
    <div class="row">
        <div class="column">
            <?= InputText::widget(['id' => 'number', 'caption' => $model->getAttributeLabel('id'), 'value' => $model->id, 'readOnly' => true]); ?>
        </div>
        <div class="column">
            <?= InputText::widget(['id' => 'date', 'caption' => $model->getAttributeLabel('date'), 'value' => Utils::toFormatDate($model->date, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
        </div>
        <div class="column">
            <b><?= InputText::widget(['id' => 'status', 'caption' => $model->getAttributeLabel('status'), 'value' => $model->getStatusText(), 'readOnly' => true]) ?></b>
        </div>
    </div>
    <div class="row">
        <?= InputText::widget([
            'id' => 'object',
            'width' => '400px',
            'value' => isset($model->object) ? $model->object->getAddress() : '',
            'readOnly' => true,
            'caption' => $model->getAttributeLabel('object_id')
        ]); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= InputText::widget(['id' => 'type', 'width' => '200px', 'readOnly' => true, 'caption' => $model->getAttributeLabel('type_id'), 'value' => isset($model->type) ? $model->type->name : '']) ?>
        </div>
        <div class="column">
            <?= InputText::widget(['id' => 'prior', 'width' => '200px', 'readOnly' => true, 'caption' => $model->getAttributeLabel('prior_id'), 'value' => isset($model->prior) ? $model->prior->name : '']) ?>
        </div>
        <div class="column">
            <?= InputText::widget(['id' => 'fmaster', 'width' => '200px', 'readOnly' => true, 'caption' => $model->getAttributeLabel('master'), 'value' => isset($model->userMaster) ? $model->userMaster->getFIO() : '']) ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= InputText::widget([
                'id' => 'client',
                'width' => '630px',
                'value' => isset($model->client) ? $model->client->name : '',
                'readOnly' => true,
                'caption' => $model->getAttributeLabel('client_id')
            ]); ?>
        </div>
        <div class="column">
            <b>
                <?= InputText::widget(['id' => 'dateplanview', 'caption' => $model->getAttributeLabel('dateplan'), 'value' => Utils::toFormatDate($model->dateplan, Utils::DEFAUL_DATESHORT_FORMAT), 'readOnly' => true]) ?>
            </b>
        </div>
    </div>
    <div class="row">
        <?= TextArea::widget([
                'id' => 'demandtext',
                'width' => '100%',
                'height' => '100px',
                'readOnly' => true,
                'caption' => 'Заявитель, Контакт, Текст заявки',
                'value' => $text]
        ); ?>
    </div>
    <div class="row">
        <?php if (!empty($model->datemaster)) { ?>
            <div class="column">
                <?= Button::widget(['id' => 'repeat_tomaster', 'value' => 'Повторно передать заявку мастеру', 'href' => Url::to(['/demand/tomaster', 'id' => $model->id, 'partial' => false])]);?>
            </div>
            <?php if (!in_array($model->getStatus(), [Demand::STATUS_DEFERED, Demand::STATUS_EXEC, Demand::STATUS_UNDO])) { ?>
                <div class="column">
                    <?= Button::widget(['id' => 'to_deferred', 'value' => 'Перевести заявку в отложенную', 'href' => Url::to(['/demand/todeferred', 'id' => $model->id, 'partial' => false])]);?>
                </div>
            <?php } ?>
            <?php if ($model->getStatus() != Demand::STATUS_UNDO) { ?>
                <div class="column" style="float: right">
                    <?= Button::widget(['id' => 'undo', 'value' => 'Отменить заявку', 'href' => Url::to(['/demand/undo', 'id' => $model->id, 'partial' => false])]);?>
                </div>
            <?php } ?>
            <?php if (in_array($model->getStatus(), [Demand::STATUS_DEFERED, Demand::STATUS_UNDO, Demand::STATUS_EXEC])) { ?>
                <div class="column">
                    <?= Button::widget(['id' => 'to_new', 'value' => 'Вернуть заявку в начальный статус', 'href' => Url::to(['/demand/new', 'id' => $model->id, 'partial' => false])]);?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php if (empty($model->datemaster)) { ?>
        <div class="row filter_panel">
            <?= Yii::$app->runAction('/demand/tomaster', ['id' => $model->id, 'partial' => true]); ?>
        </div>
    <?php } ?>
    <div class="row filter_panel">
        <?= Yii::$app->runAction('/demand/plan', ['id' => $model->id, 'partial' => true]); ?>
    </div>
    <div class="row filter_panel">
        <div class="row">
            <div class="column">
                <?= InputText::widget(['id' => 'fdatemaster', 'caption' => $model->getAttributeLabel('datemaster'), 'value' => Utils::toFormatDate($model->datemaster, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'datexec', 'caption' => $model->getAttributeLabel('datexec'), 'value' => Utils::toFormatDate($model->datexec, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'firstdatemaster', 'caption' => $model->getAttributeLabel('firstdatemaster'), 'value' => Utils::toFormatDate($model->firstdatemaster, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
            </div>
            <div class="column">
                <?= InputText::widget(['id' => 'date_deferred', 'caption' => 'Дата перевода заявки в отложенную', 'value' => Utils::toFormatDate($model->date_deferred, Utils::DEFAULT_DATE_FORMAT), 'readOnly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <?= TextArea::widget([
                    'id' => 'report',
                    'width' => '100%',
                    'height' => '100px',
                    'readOnly' => true,
                    'caption' => $model->getAttributeLabel('report'),
                    'value' => $model->report]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= Button::widget([
                'id' => 'btn_edit_dem',
                'value' => 'Изменить',
                'href' => \yii\helpers\Url::to(['/demand/update', 'id' => $model->id])
            ]); ?>
        </div>
        <div class="column" style="float: right;">
            <?= Button::widget([
                'id' => 'btn_history',
                'value' => 'История изменений',
                'href' => \yii\helpers\Url::to(['/demandhistory', 'id' => $model->id])
            ]); ?>
        </div>
    </div>
</div>


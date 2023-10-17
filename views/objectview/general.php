<?php

use app\controllers\SiteController;
use app\controllers\ObjectController;
use app\components\Utils;
use app\components\Button;

/** @var \app\models\Objects $model */

$this->title = $model->getAddress();

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ObjectController::PAGE_TITLE_INDEX => ['url' => '/object'],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];

?>
<div class="grid">
    <div class="row">
        <?= \app\components\InputText::widget([
            'id' => 'address',
            'value' => $model->getAddress(),
            'caption' => 'Адрес',
            'width' => '600px',
            'readOnly' => true
        ]); ?>
    </div>
    <div class="row">
        <?= \app\components\InputText::widget([
            'id' => 'client',
            'value' => isset($model->client) ? $model->client->name : '',
            'caption' => 'Клиент',
            'width' => '600px',
            'readOnly' => true
        ]); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= \app\components\InputText::widget([
                'id' => 'qdoorway',
                'value' => $model->quant_doorway,
                'caption' => 'Кол-во подъездов',
                'width' => '120px',
                'readOnly' => true
            ]); ?>
        </div>
        <div class="column">
            <?= \app\components\InputText::widget([
                'id' => 'datebuild',
                'value' => $model->datebuild,
                'caption' => 'Дата постройки',
                'width' => '120px',
                'readOnly' => true
            ]); ?>
        </div>
        <div class="column">
            <?= \app\components\InputText::widget([
                'id' => 'manager',
                'value' => isset($model->userManager) ? $model->userManager->getFIO() : '',
                'caption' => 'Менеджер',
                'width' => '200px',
                'readOnly' => true
            ]); ?>
        </div>
        <div class="column">
            <?php if ($model->is_service) {
                echo \app\components\Service::message('Объект на обслуживании');
            } else {
                echo '<p>Не на обслуживании</p>';
            }?>
        </div>
    </div>
    <div class="row">
        <?= \app\components\TextArea::widget([
            'id' => 'note',
            'value' => $model->note,
            'caption' => 'Примечание',
            'height' => '100px',
            'width' => '100%',
            'readOnly' => true
        ]); ?>
    </div>
    <div class="row">
        <?= Button::widget([
            'id' => 'btn_edit_object',
            'value' => 'Изменить',
            'href' => \yii\helpers\Url::to(['/object/update', 'id' => $model->id])
        ]); ?>
    </div>
</div>


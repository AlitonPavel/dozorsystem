<?php
/** @var \app\models\Demand $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;
use app\components\InputText;
use app\controllers\SuggestController;
use yii\helpers\Url;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'demand',
        'model' => $model
    ]);
    ?>

    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'date', 'readOnly' => true]) ?>
        </div>
        <div class="column">
            <b><?= InputText::widget(['id' => 'status', 'caption' => $model->getAttributeLabel('status'), 'value' => $model->getStatusText(), 'readOnly' => true]) ?></b>
        </div>
    </div>
    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'object_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'o']),
            'model' => $model,
            'width' => '400px',
            'value' => $model->object_id,
            'text' => isset($model->object) ? $model->object->getAddress() : '',
            'placeholder' => '-начните вводить адрес-'
        ]); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createSelectInput(['id' => 'type_id', 'width' => '200px', 'items' => SuggestController::getDemandTypesForSelectInput()]) ?>
        </div>
        <div class="column">
            <?= $form->createSelectInput(['id' => 'prior_id', 'width' => '200px', 'items' => SuggestController::getDemandPriorsForSelectInput()]) ?>
        </div>
        <div class="column">
            <?= $form->createSelectInput(['id' => 'master', 'width' => '200px', 'items' => SuggestController::getUsersForSelectInput()]) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'client_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'c']),
            'model' => $model,
            'width' => '610px',
            'value' => $model->client_id,
            'text' => isset($model->client) ? $model->client->name : '',
            'placeholder' => '-начните вводить клиента-'
        ]); ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'creator', 'width' => '610px']) ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'contact', 'width' => '610px']) ?>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'demandtext', 'width' => '100%', 'height' => '100px']) ?>
    </div>

    <?php if ($update) { ?>
        <div class="row">
            <div class="filter_panel">
                <div class="row">
                    <div class="column">
                        <?= $form->createInputText(['id' => 'datemaster', 'readOnly' => true]) ?>
                    </div>
                    <div class="column">
                        <?= $form->createDateTimeInput(['id' => 'datexec']) ?>
                    </div>
                </div>
                <div class="row">
                    <?= $form->createTextArea(['id' => 'report', 'width' => '100%', 'height' => '100px']) ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php Form::end(); ?>
</div>
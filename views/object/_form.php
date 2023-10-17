<?php
/** @var \app\models\Objects $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;
use app\components\AutoComplete;
use yii\helpers\Url;
use app\controllers\SuggestController;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'objects',
        'model' => $model
    ]);
    ?>

    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'street_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 's']),
            'model' => $model,
            'width' => '600px',
            'value' => $model->street_id,
            'text' => isset($model->street) ? $model->street->getFullName() : '',
            'placeholder' => '-начните вводить адрес-'
        ]); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'house', 'model' => $model]); ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'corp', 'model' => $model]); ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'room', 'model' => $model]); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'client_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'c']),
            'model' => $model,
            'width' => '600px',
            'value' => $model->client_id,
            'text' => isset($model->client) ? $model->client->name : ''
        ]); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'quant_doorway', 'model' => $model, 'width' => '120px']); ?>
        </div>
        <div class="column">
            <?= $form->createSelectInput(['id' => 'datebuild', 'width' => '120px', 'items' => SuggestController::getRangeForSelectInput(1900, date('Y')+100, 1)]); ?>
        </div>
        <div class="column">
            <?= $form->createAutoComplete([
                'id' => 'manager',
                'source' => Url::to(['/suggest', SuggestController::reqModel => 'u']),
                'model' => $model,
                'width' => '200px',
                'value' => $model->manager,
                'text' => isset($model->userManager) ? $model->userManager->getFIO() : ''
            ]); ?>
        </div>
        <div class="column">
            <br />
            <?= $form->createCheckBox(['id' => 'is_service', 'caption' => 'Объект на обслуживании']); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createTextArea([
            'id' => 'note',
            'model' => $model,
            'width' => '100%',
            'height' => '100px'
        ]);
        ?>
    </div>
    <?php Form::end(); ?>
</div>
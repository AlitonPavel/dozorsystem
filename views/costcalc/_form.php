<?php
/** @var \app\models\CostCalc $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\CostCalc;
use app\components\Form;
use app\controllers\SuggestController;
use yii\helpers\Url;

?>

<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'costcalc',
        'model' => $model
    ]);
    ?>

    <div class="row">
        <?= $form->createDateInput(['id' => 'date']); ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'name', 'width' => '400px']) ?>
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
        <?= $form->createAutoComplete([
            'id' => 'client_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'c']),
            'model' => $model,
            'width' => '400px',
            'value' => $model->client_id,
            'text' => isset($model->client) ? $model->client->name : '',
            'placeholder' => '-начните вводить клиента-'
        ]); ?>
    </div>
    <div class="row">
        <?= $form->createSelectInput(['id' => 'user_id', 'width' => '200px', 'items' => SuggestController::getUsersForSelectInput()]) ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'contactFIO', 'width' => '200px']) ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'contact', 'width' => '200px']) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createSelectInput(['id' => 'typepay', 'width' => '200px', 'items' => SuggestController::getTypePaySelectInput()]) ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'planpay', 'width' => '400px']) ?>
    </div>
    <div class="row">
        <?= $form->createSelectInput(['id' => 'prior_id', 'width' => '200px', 'items' => SuggestController::getDemandPriorsForSelectInput()]) ?>
    </div>
    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'company_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'c']),
            'model' => $model,
            'width' => '400px',
            'value' => $model->company_id,
            'text' => isset($model->company) ? $model->company->name : '',
            'placeholder' => '-начните вводить клиента-'
        ]); ?>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'note', 'height' => '50px', 'width' => '100%']); ?>
    </div>
    <div class="row">
        <?= $model->renderGeneralErrors(); ?>
    </div>
    <?php Form::end(); ?>
</div>
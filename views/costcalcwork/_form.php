<?php
/** @var \app\models\CostCalcWork $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'costcalcwork',
        'model' => $model,
        'submitName' => 'Добавить работу в смету'
    ]);
    ?>
    <?= $form->createInputText(['id' => 'calc_id', 'readOnly' => true, 'type' => 'hidden']); ?>
    <div class="row">
        <?= $form->createInputText(['id' => 'name']); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'quant', 'width' => '180px']) ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'pricelow', 'width' => '180px']) ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'pricehigh', 'width' => '180px']) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'note', 'width' => '100%', 'height' => '50px']); ?>
    </div>
    <div class="row">
        <?= $model->renderGeneralErrors(); ?>
    </div>
    <?php Form::end(); ?>
</div>
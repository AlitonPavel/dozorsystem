<?php
/** @var \app\models\Equip $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'equip',
        'model' => $model
    ]);
    ?>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'shortname', 'width' => '600px']); ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'model', 'width' => '600px']); ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'pricelow', 'width' => '200px']); ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'pricehigh', 'width' => '200px']); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'note', 'width' => '100%', 'height' => '50px']); ?>
    </div>
    <div class="row">
        <div class="input_error"><?= $model->getFirstError('name'); ?></div>
    </div>
    <?php Form::end(); ?>
</div>
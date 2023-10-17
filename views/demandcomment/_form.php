<?php
/** @var \app\models\DemandComment $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'demandcomment',
        'model' => $model
    ]);
    ?>
    <?= $form->createInputText(['id' => 'demand_id', 'readOnly' => true, 'type' => 'hidden']); ?>
    <div class="row">
        <div class="column"><?= $form->createInputText(['id' => 'date', 'readOnly' => true]) ?></div>
        <div class="column"><?= $form->createInputText(['id' => 'user', 'caption' => 'Автор', 'value' => $model->user->getFIO(),'readOnly' => true]) ?></div>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'comment', 'width' => '100%', 'height' => '50px']); ?>
    </div>
    <?php Form::end(); ?>
</div>
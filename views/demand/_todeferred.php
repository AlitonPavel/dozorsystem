<?php

use app\components\Form;
use app\components\Utils;
use yii\helpers\Url;
use app\components\TextArea;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'todeferred',
        'action' => Url::to(['/demand/todeferred', 'id' => $model->id, 'partial' => false]),
        'model' => $model,
        'method' => 'post',
        'submitName' => 'Перевести заявку в отложенные'
    ]);
    ?>

    <div class="row">
        <div class="column">
            <?= $form->createDateTimeInput(['id' => 'date_deferred', 'caption' => $model->getAttributeLabel('date_deferred'), 'readOnly' => true]) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'reason_deferred', 'caption' => 'Причина перевода заявки в отложенную',  'width' => '100%', 'height' => '100px']); ?>
    </div>

    <?php Form::end(); ?>
</div>
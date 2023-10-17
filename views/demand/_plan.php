<?php

use app\components\Form;
use yii\helpers\Url;
use app\components\TextArea;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'plan',
        'action' => Url::to(['/demand/plan', 'id' => $model->id, 'partial' => false]),
        'model' => $model,
        'method' => 'post',
        'submitName' => 'Поставить новую плановую дату'
    ]);
    ?>

    <div class="row">
        <div class="column">
            <?= $form->createDateInput(['id' => 'dateplan', 'value' => null]) ?>
        </div>
    </div>
    <div class="row">
        <?= TextArea::widget(['id' => 'comment', 'caption' => 'Комментарий',  'width' => '100%', 'height' => '100px']); ?>
    </div>

    <?php Form::end(); ?>
</div>
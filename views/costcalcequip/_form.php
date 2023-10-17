<?php
/** @var \app\models\CostCalcEquip $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\Form;
use app\controllers\SuggestController;
use yii\helpers\Url;

?>
<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'costcalcequip',
        'model' => $model,
        'submitName' => 'Добавить оборудование в смету'
    ]);
    ?>
    <?= $form->createInputText(['id' => 'calc_id', 'readOnly' => true, 'type' => 'hidden']); ?>
    <div class="row">
        <?= $form->createAutoComplete([
            'id' => 'equip_id',
            'source' => Url::to(['/suggest', SuggestController::reqModel => 'e']),
            'model' => $model,
            'width' => '400px',
            'value' => null,
            'text' => (isset($model->equip) ? $model->equip->name : ''),
            'placeholder' => '-начните вводить оборудование-'
        ]); ?>
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
    <div class="row">
        <div class="row">
            <?= \app\components\CheckBox::widget(['id' => 'add_work', 'name' => 'add_work', 'caption' => 'Добавить работу', 'checked' => true]); ?>
        </div>
        <div class="row" id="work">

        </div>
    </div>
    <?php Form::end(); ?>
</div>

<?php

$js = <<<EOF
    $(document).ready(function() {
        $( "#equip_id_text" ).autocomplete({
            select: function( event, ui ) {
                var item  = ui.item;
                if (item)
                {
                    $("#pricelow").val(item.priceLow);
                    $("#pricehigh").val(item.priceHigh);
                }
            }
        });
    });
EOF;

$this->registerJs($js);

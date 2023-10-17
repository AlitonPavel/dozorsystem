<?php
/** @var \app\components\CheckBox $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/input.css');
$this->registerCssFile('@web/css/components/checkbox.css');

$id_hidden = $widget->id . '_hidden';

$js = <<<EOF
    $(document).ready(function() {
        $("#{$widget->id}").on('change', function() {
            if (this.checked)
            {
                $("#{$id_hidden}").val(1);
            }
            else
            {
                $("#{$id_hidden}").val(0);
            }
        });
    });
EOF;

$this->registerJs($js);

?>
<div class="checkbox">
    <input class="checkbox_input" id="<?= $widget->id ?>" type="<?= $widget->type ?>" <?= $widget->checked ? 'checked' : '' ?> value="<?= $widget->value ?>"/>
    <label class="checkbox_label" for="<?= $widget->id ?>"><?= $widget->caption ?></label>
    <input class="checkbox_input_hidden" id="<?= $id_hidden ?>" type="hidden" name="<?= $widget->name ?>" value="<?= $widget->value ?>"/>
    <div class="input_error"><?= $widget->error ?></div>
</div>

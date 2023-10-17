<?php
/** @var \app\components\Input $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/input.css');
?>
<div class="input">
    <label class="input_label" for="<?= $widget->id ?>"><?= $widget->caption, ':'?></label>
    <input
        class="input_input"
        id="<?= $widget->id ?>"
        onfocus="this.setAttribute('type', 'password');"
        type="text"
        name="<?= $widget->name ?>"
        value="<?= htmlspecialchars($widget->value) ?>"
        style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>" <?= $widget->readOnly ? 'readonly' : '' ?>
        <?= $widget->autocomplete ? 'autocomplete="' . $widget->autocomplete. '"' : '' ?>
    />
    <div class="input_error"><?= $widget->error ?></div>
</div>
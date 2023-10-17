<?php
/** @var \app\components\Input $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/input.css');
?>
<div class="input">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?= $widget->size ?>" />
    <input
        class="input_input"
        id="<?= $widget->id ?>"
        type="<?= $widget->type ?>"
        name="<?= $widget->name ?>"
        value="<?= htmlspecialchars($widget->value) ?>"
        style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>" <?= $widget->readOnly ? 'readonly' : '' ?>
        <?= $widget->pattern ? 'pattern="' . $widget->pattern . '"' : '' ?>
        <?= $widget->placeholder ? 'placeholder="' . $widget->placeholder . '"' : '' ?>
        <?= $widget->autocomplete ? 'autocomplete="' . $widget->autocomplete. '"' : '' ?>
        <?= $widget->accept ? 'accept="' . $widget->accept. '"' : '' ?>
    />
    <div class="input_error"><?= $widget->error ?></div>
</div>
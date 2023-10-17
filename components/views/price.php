<?php
/** @var \app\components\Input $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/input.css');

use app\components\Utils;

?>
<div class="input">
    <label class="input_label" for="<?= $widget->id ?>"><?= $widget->caption, ':'?></label>
    <input
        class="input_input"
        id="<?= $widget->id ?>"
        type="<?= $widget->type ?>"
        name="<?= $widget->name ?>"
        value="<?= htmlspecialchars(Utils::toFormatMoney($widget->value)); ?>"
        style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>" <?= $widget->readOnly ? 'readonly' : '' ?>
        pattern="\d+(\.\d{2})?"
        placeholder="<?= $widget->placeholder ?>"
        <?= $widget->autocomplete ? 'autocomplete="' . $widget->autocomplete. '"' : '' ?>
    />
    <div class="input_error"><?= $widget->error ?></div>
</div>
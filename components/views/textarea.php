<?php
/** @var \app\components\Input $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/textarea.css');
?>
<div class="textarea">
    <label class="textarea_label" for="<?= $widget->id ?>"><?= $widget->caption, ':'?></label>
    <textarea
        class="textarea_text"
        id="<?= $widget->id ?>"
        name="<?= $widget->name ?>"
        style="<?= isset($widget->width) ? 'width:' . $widget->width . ';': '' ?><?= isset($widget->height) ? 'height:' . $widget->height . ';' : '' ?>"
        <?= $widget->readOnly ? 'readonly' : '' ?>
    ><?= $widget->value ?></textarea>
    <div class="input_error"><?= $widget->error ?></div>
</div>

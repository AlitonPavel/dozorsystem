<?php
/** @var \app\components\SelectInput $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/selectinput.css');
?>
<div class="selectinput">
    <label class="selectinput_label" for="<?= $widget->id ?>"><?= $widget->caption, ':'?></label>
    <select class="selectinput_select" size="<?= $widget->size ?>" id="<?= $widget->id ?>" type="<?= $widget->type ?>" name="<?= $widget->name ?>" value="<?= htmlspecialchars($widget->value) ?>" style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>" <?= $widget->readOnly ? 'readonly' : '' ?>>
        <option></option>
        <?php foreach ($widget->items as $item) { ?>
            <option <?= ($widget->value == $item['id']) ? 'selected' : '' ?> value="<?= $item['id']?>"><?= $item['name'] ?></option>
        <?php } ?>
    </select>
    <div class="input_error"><?= $widget->error ?></div>
</div>

<?php
/** @var \app\components\Button $widget */
/** @var \app\components\BaseView $this */
$this->registerCssFile('@web/css/components/button.css');
?>
<?php if (!empty($widget->href)) { ?>
    <a href="<?= $widget->href ?>"
       class="button_a" <?= !empty($widget->target) ? 'target="' . $widget->target . '"' : '' ?>>
        <button <?= empty($widget->type) ? '' : 'type="' . $widget->type . '"' ?> id="<?= $widget->id ?>" class="button"><?= $widget->value ?></button>
    </a>
<?php } else { ?>
    <button <?= empty($widget->type) ? '' : 'type="' . $widget->type . '"' ?> id="<?= $widget->id ?>" class="button"><?= $widget->value ?></button>
<?php } ?>
<div style="clear: both"></div>
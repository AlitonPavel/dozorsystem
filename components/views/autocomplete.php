<?php

use app\assets\JqueryUIAsset;
/** @var \app\components\BaseView $this */
/** @var \app\components\AutoComplete $widget */

JqueryUIAsset::register($this);

$this->registerCssFile('@web/css/components/autocomplete.css');

$source = json_encode($widget->source);

$js = <<<EOF
    $(document).ready(function() {
        $( "#{$widget->getTextId()}" ).autocomplete({
          source: {$source},
          change: function( event, ui ) {
            item = ui.item;
            if (item != undefined)
            {
                $("#{$widget->id}").val(item.id);
            }
            else {
                $("#{$widget->id}").val('');
            }
          }
        });
    });
EOF;

$this->registerJs($js);

?>

<div class="autocomplete">
    <label class="autocomplete_label" for="<?= $widget->getTextId() ?>"><?= isset($widget->caption) ? $widget->caption . ':' : '' ?></label>
    <input class="autocomplete_text" style="<?= !empty($widget->width) ? 'width:' . $widget->width : '' ?>" id="<?= $widget->getTextId() ?>" value="<?= htmlspecialchars($widget->text) ?>" placeholder="<?= $widget->placeholder ?>" <?= $widget->readOnly ? 'readonly' : '' ?>/>
    <input class="autocomplete_input" type="hidden" id="<?= $widget->id ?>" name="<?= $widget->name ?>" value="<?= $widget->value ?>" />
    <div class="input_error"><?= $widget->error ?></div>
</div>
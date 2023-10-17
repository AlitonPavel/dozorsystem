<?php

use app\assets\JqueryUIAsset;
use app\components\Utils;
/** @var \app\components\BaseView $this */
/** @var \app\components\AutoComplete $widget */

JqueryUIAsset::register($this);

$this->registerCssFile('@web/css/components/date.css');

$js = <<<EOF
    $(document).ready(function() {
        $.datepicker.regional['ru'] = {
                    closeText: 'Закрыть',
                    prevText: 'Пред',
                    nextText: 'След',
                    currentText: 'Сегодня',
                    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                    'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                    'Июл','Авг','Сен','Окт','Ноя','Дек'],
                    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                    weekHeader: 'Нед',
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
                    
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    
        $( "#{$widget->id}" ).datepicker({showButtonPanel: true, dateFormat: 'dd.mm.yy', closeText: 'Очистить', onClose: function (dateText, inst) {
            if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                $(this).val('');
            }
        }});
    });
EOF;

$this->registerJs($js);

?>

<div class="date">
    <label class="date_label" for="<?= $widget->id ?>"><?= isset($widget->caption) ? $widget->caption . ':' : '' ?></label>
    <input class="date_input" type="text" id="<?= $widget->id ?>" value="<?= Utils::dateFormat($widget->value, Utils::DEFAUL_DATESHORT_FORMAT) ?>" name="<?= $widget->name ?>" style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>"/>
    <div class="input_error"><?= $widget->error ?></div>
</div>

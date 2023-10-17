<?php

use app\assets\JqueryUIAsset;
use app\components\Utils;
/** @var \app\components\BaseView $this */
/** @var \app\components\AutoComplete $widget */

JqueryUIAsset::register($this);

$this->registerCssFile('@web/css/components/datetime.css');

$id_time = $widget->id . '_time';
$id_hidden = $widget->id . '_hidden';

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
        
        function getValue(idDate, idTime) {
            var v = '';
            
            if ($('#' + idDate).val())
            {
                v = $('#' + idDate).val();
            }
            else 
            {
                return v;
            }
            
            if ($('#' + idTime).val())
            {
                v += ' ' + $('#' + idTime).val();
            }
            else
            {
                v += ' 00:00';
            }
            
            return v;
        };
        
        $("#{$widget->id}").datepicker({showButtonPanel: true, closeText: 'Очистить', onClose: function (dateText, inst) {
            if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                document.getElementById(this.id).value = '';
                $("#{$id_hidden}").val(getValue('{$widget->id}', '{$id_time}'));
            }
        }, dateFormat: 'dd.mm.yy'});
        
         $("#{$widget->id}").on('change', function() {
            $("#{$id_hidden}").val(getValue('{$widget->id}', '{$id_time}'));
        });
        $("#{$id_time}").on('change', function() {
            $( "#{$id_hidden}").val(getValue('{$widget->id}', '{$id_time}')); 
        });
    });
EOF;

$this->registerJs($js);

?>

<div class="datetime">
    <label class="datetime_label" for="<?= $widget->id ?>"><?= isset($widget->caption) ? $widget->caption . ':' : '' ?></label>
    <input class="datetime_input" type="text" id="<?= $widget->id ?>" value="<?= Utils::dateFormat($widget->value, Utils::DEFAUL_DATESHORT_FORMAT) ?>" style="<?= isset($widget->width) ? 'width:' . $widget->width : '' ?>"/>
    <input class="datetime_input_time" type="time" id="<?= $widget->id, '_time' ?>" value="<?= Utils::dateFormat($widget->value, Utils::TIME_FORMAT) ?>" style="height: 18px; width: 60px"/>
    <input type="hidden" id="<?= $widget->id, '_hidden' ?>" name="<?= $widget->name ?>" value="<?= Utils::dateFormat($widget->value, Utils::DEFAULT_DATE_FORMAT) ?>"/>
    <div class="input_error"><?= $widget->error ?></div>
</div>


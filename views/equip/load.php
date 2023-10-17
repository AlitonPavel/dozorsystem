<?php

use app\components\Form;
use app\controllers\EquipController;
use app\controllers\SiteController;

$this->title = EquipController::PAGE_TITLE_LOAD;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    EquipController::PAGE_TITLE_INDEX => ['url' => '/equip'],
    $this->title => ['url' => ''],
];

?>

<div class="grid">
    <div class="row">
        <div class="column">
            <ul>
                Требование к файлу:
                <li>Файл должен быть в формате xls, xlsx</li>
                <li>Список оборудования должен начинатся с первой строки и не содержать пропуски. Пустая строка расценивается как окончание файла.</li>
                <li>Порядок колонок: Короткое наименование (текст), Модель(тест), Себестоимость (формат с точкой, 123.55), Цена для клиента(формат с точкой, 123.55), Примечание (текст)</li>
                <li>Если в БД уже будет данное обрудование, то программа обновит данные по этому оборудование.</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="column">
            Пример:
            <table border="1">
                <tbody>
                    <tr>
                        <td>Уличная видеокамера</td>
                        <td>DAHUA DH-IPC-HFW5441EP-ZE</td>
                        <td>31390</td>
                        <td>37668</td>
                        <td>Видеокамера IP уличная цилиндрическая 4Мп 1/2.7” 4M CMOS,ICR,WDR(120дБ),чувствительность 0.01 лк@F1.5 сжатие: H.265+/H.265/H.264+/H.264/H.264B/H.264H/MJPEG,3 </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br />
    <br />
    <?php
        if (isset($success))
        {
            ?>
                <div class="row">
                    <div class="column" style="color: #0AA473">
                        Файл успешно загружен, Вы можете загрузить еще файл.
                    </div>
                </div>
            <?php
        }
    ?>

    <?php
        $form = Form::begin([
            'id'            => 'file',
            'submitName'    => 'Загрузить',
            'enctype'       => "multipart/form-data",
        ]);
    ?>
    <div class="row">
        <div class="column">
            <?= $form->createInputFile(['id' => 'userfile', 'name' => 'userfile', 'accept' => '.xls, .xlsx']); ?>
        </div>
    </div>
    <?php Form::end(); ?>
</div>

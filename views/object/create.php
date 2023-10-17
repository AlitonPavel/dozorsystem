<?php

use app\controllers\SiteController;
use app\controllers\ObjectController;
/* @var $this yii\web\View */
/* @var $model app\models\Object */

$this->title = 'Создать объект';

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ObjectController::PAGE_TITLE_INDEX => ['url' => '/object'],
    $this->title => ['url' => ''],
];

?>
<div class="object-create">
    <?= $this->render('_form', [
        'model' => $model,
        ''
    ]) ?>

</div>

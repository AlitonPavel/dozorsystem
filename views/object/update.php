<?php

use app\controllers\SiteController;
use app\controllers\ObjectController;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = $model->getAddress();

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ObjectController::PAGE_TITLE_INDEX => ['url' => '/object'],
    $this->title => ['url' => '/object/view', 'params' => ['id' => $model->id]],
    'Редактирование' => ['url' => '/object/update', 'params' => ['id' => $model->id]],
];
?>
<div class="object-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
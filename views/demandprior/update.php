<?php

use app\controllers\SiteController;
use app\controllers\DemandtypeController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandType */

$this->title = $model->name;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandtypeController::PAGE_TITLE_INDEX => ['url' => '/demandtype'],
    $model->name => ['url' => '/demandtype/update', 'params' => ['id' => $model->id]],
];
?>
<div class="dtype-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
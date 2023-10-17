<?php

use app\controllers\SiteController;
use app\controllers\DemandpriorController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandPrior */

$this->title = $model->name;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandpriorController::PAGE_TITLE_INDEX => ['url' => '/demandprior'],
    $model->name => ['url' => '/demandprior/update', 'params' => ['id' => $model->id]],
];
?>
<div class="dprior-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
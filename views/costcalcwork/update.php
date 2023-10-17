<?php

use app\controllers\SiteController;
use app\controllers\CostcalcviewController;
use app\controllers\CostcalcworkController;

/* @var $this yii\web\View */
/* @var $model app\models\CostCalcWork */

$this->title = CostcalcworkController::PAGE_TITLE_UPDATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcviewController::PAGE_TITLE_INDEX => ['url' => '/coscalc/view', 'params' => ['id' => $model->calc_id]],
    CostcalcworkController::PAGE_TITLE_UPDATE => ['url' => '/costcalcwork/update', 'params' => ['id' => $model->id]],
];
?>
<div class="costcalcwork-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
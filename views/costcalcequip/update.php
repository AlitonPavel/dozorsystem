<?php

use app\controllers\SiteController;
use app\controllers\CostcalcequipController;
use app\controllers\CostcalcviewController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = CostcalcequipController::PAGE_TITLE_UPDATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcviewController::PAGE_TITLE_INDEX => ['url' => '/coscalc/view', 'params' => ['id' => $model->calc_id]],
    CostcalcequipController::PAGE_TITLE_UPDATE => ['url' => '/costcalcequip/update', 'params' => ['id' => $model->id]],
];
?>
<div class="costcalcequip-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
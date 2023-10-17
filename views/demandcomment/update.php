<?php

use app\controllers\SiteController;
use app\controllers\DemandviewController;
use app\controllers\DemandcommentController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = DemandcommentController::PAGE_TITLE_UPDATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandviewController::PAGE_TITLE_INDEX => ['url' => '/demand', 'params' => ['id' => $model->demand_id]],
    DemandcommentController::PAGE_TITLE_UPDATE => ['url' => '/demandcomment/update', 'params' => ['id' => $model->id]],
];
?>
<div class="demandcomment-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
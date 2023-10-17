<?php

use app\controllers\SiteController;
use app\controllers\ObjectController;
use app\controllers\DemandController;
use app\controllers\DemandviewController;

/* @var $this yii\web\View */
/* @var $model app\models\Demand */

$number = ' №' . $model->id;
$this->title = DemandController::PAGE_TITLE_UPDATE . $number;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandController::PAGE_TITLE_INDEX => ['url' => '/demand'],
    DemandviewController::PAGE_TITLE_INDEX . $number => ['url' => '/demand/view', 'params' => ['id' => $model->id]],
    $this->title => ['url' => '/demand/update', 'params' => ['id' => $model->id]],
];
?>
<div class="demand-update">
    <?= $this->render('_form', [
        'model' => $model,
        'update' => true
    ]) ?>
</div>
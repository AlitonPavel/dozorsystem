<?php

use app\controllers\SiteController;
use app\controllers\DemandpriorController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandPrior */

$this->title = DemandpriorController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandPriorController::PAGE_TITLE_INDEX => ['url' => '/demandprior'],
    $this->title => ['url' => ''],
];

?>
<div class="dprior-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

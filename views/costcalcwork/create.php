<?php

use app\controllers\SiteController;
use app\controllers\CostcalcworkController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandComment */

if (!isset($ajax)) {
    $this->title = CostcalcworkController::PAGE_TITLE_CREATE;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        CostcalcworkController::PAGE_TITLE_INDEX => ['url' => '/costcalc/view'],
        $this->title => ['url' => ''],
    ];
}

?>
<div class="costcalcwork-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

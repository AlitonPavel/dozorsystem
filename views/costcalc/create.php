<?php

use app\controllers\SiteController;
/* @var $this yii\web\View */
/* @var $model app\models\CostCalc */
use app\controllers\CostcalcController;
use app\controllers\CostcalcviewController;
$title = CostcalcController::PAGE_TITLE_CREATE;

$this->title = $title;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $title => ['url' => ''],
];

?>
<div class="costcalc-create">
    <?= $this->render('_form', [
        'model' => $model,
        'update' => false
    ]) ?>

</div>

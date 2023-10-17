<?php

use app\controllers\SiteController;
/* @var $this yii\web\View */
/* @var $model app\models\CostCalc */
use app\controllers\CostcalcController;

$title = CostcalcController::PAGE_TITLE_UPDATE . ' - ' . $model->getTypeName();

$this->title = $title;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $model->getTypeName() . ' №' . $model->id  => ['url' => '/costcalc/view', 'params' => ['id' => $model->id]],
    $title . ' №' . $model->id => ['url' => '/costcalc/update', 'params' => ['id' => $model->id]],
];

?>
<div class="costcalc-update">
    <?= $this->render('_form', [
        'model' => $model,
        'update' => false
    ]) ?>

</div>

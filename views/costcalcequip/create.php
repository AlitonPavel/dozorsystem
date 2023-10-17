<?php

use app\controllers\SiteController;
use app\controllers\DemandcommentController;
use app\controllers\CostcalcequipController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandComment */

if (!isset($ajax)) {
    $this->title = CostcalcequipController::PAGE_TITLE_CREATE;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        CostcalcequipController::PAGE_TITLE_INDEX => ['url' => '/costcalc/view'],
        $this->title => ['url' => ''],
    ];
}

?>
<div class="costcalcequip-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

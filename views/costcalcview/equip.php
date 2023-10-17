<?php

use app\controllers\DemandController;
use app\controllers\DemandviewController;
use app\controllers\SiteController;
use app\controllers\CostcalcequipController;
use app\controllers\CostcalcController;

$this->title = CostcalcequipController::PAGE_TITLE_INDEX . ' '. $model->getTypeName() . ' №' . $model->id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $model->getTypeName() . ' №' . $model->id => ['url' => '/costcalc/view', 'params' => ['id' => $model->id]],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];
?>
<div class="row filter_panel">
    <?= Yii::$app->runAction('/costcalcequip/create', ['ajax' => true]); ?>
</div>
<?= Yii::$app->runAction('/costcalcequip', ['id' => $model->id, 'ajax' => true]); ?>

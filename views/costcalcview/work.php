<?php

use app\controllers\SiteController;
use app\controllers\CostcalcController;
use app\controllers\CostcalcworkController;

$this->title = CostcalcworkController::PAGE_TITLE_INDEX . ' '. $model->getTypeName() . ' №' . $model->id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $model->getTypeName() . ' №' . $model->id => ['url' => '/costcalc/view', 'params' => ['id' => $model->id]],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];
?>
<div class="row filter_panel">
    <?= Yii::$app->runAction('/costcalcwork/create', ['ajax' => true]); ?>
</div>
<?= Yii::$app->runAction('/costcalcwork', ['id' => $model->id, 'ajax' => true]); ?>

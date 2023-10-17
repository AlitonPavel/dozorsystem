<?php

use app\controllers\SiteController;
/* @var $this yii\web\View */
/* @var $model app\models\Demand */
use app\controllers\DemandController;

$this->title = DemandController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandController::PAGE_TITLE_INDEX => ['url' => '/demand'],
    $this->title => ['url' => ''],
];

?>
<div class="demand-create">
    <?= $this->render('_form', [
        'model' => $model,
        'update' => false
    ]) ?>

</div>

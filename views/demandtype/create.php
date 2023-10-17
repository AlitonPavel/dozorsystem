<?php

use app\controllers\SiteController;
use app\controllers\DemandtypeController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandType */

$this->title = DemandtypeController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandtypeController::PAGE_TITLE_INDEX => ['url' => '/demandtype'],
    $this->title => ['url' => ''],
];

?>
<div class="dtype-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

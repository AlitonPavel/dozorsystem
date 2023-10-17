<?php

use app\controllers\SiteController;
use app\controllers\DemandcommentController;

/* @var $this yii\web\View */
/* @var $model app\models\DemandComment */

if (!isset($ajax)) {
    $this->title = DemandcommentController::PAGE_TITLE_CREATE;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        DemandcommentController::PAGE_TITLE_INDEX => ['url' => '/demandcomment'],
        $this->title => ['url' => ''],
    ];
}

?>
<div class="demandcomment-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

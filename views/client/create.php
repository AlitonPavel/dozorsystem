<?php

use app\controllers\SiteController;
use app\controllers\ClientController;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = ClientController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ClientController::PAGE_TITLE_INDEX => ['url' => '/client'],
    $this->title => ['url' => ''],
];

?>
<div class="client-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

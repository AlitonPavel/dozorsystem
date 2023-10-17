<?php

use app\controllers\SiteController;
use app\controllers\ClientController;
use app\models\Client;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = $model->name;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ClientController::PAGE_TITLE_INDEX => ['url' => '/client'],
    $this->title => ['url' => '/client/update/' . $model->id],
];
?>
<div class="client-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
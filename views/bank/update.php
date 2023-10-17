<?php

use app\controllers\SiteController;
use app\controllers\BankController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->name;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    BankController::PAGE_TITLE_INDEX => ['url' => '/bank'],
    $model->name => ['url' => '/bank/update', 'params' => ['id' => $model->id]],
];
?>
<div class="bank-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
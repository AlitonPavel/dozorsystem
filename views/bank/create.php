<?php

use app\controllers\SiteController;
use app\controllers\BankController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = BankController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    BankController::PAGE_TITLE_INDEX => ['url' => '/bank'],
    $this->title => ['url' => ''],
];

?>
<div class="bank-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

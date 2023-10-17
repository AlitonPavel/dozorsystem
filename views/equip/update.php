<?php

use app\controllers\SiteController;
use app\controllers\EquipController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->name;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    EquipController::PAGE_TITLE_INDEX => ['url' => '/equip'],
    $model->name => ['url' => '/equip/update', 'params' => ['id' => $model->id]],
];
?>
<div class="equip-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
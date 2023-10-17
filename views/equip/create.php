<?php

use app\controllers\SiteController;
use app\controllers\EquipController;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = EquipController::PAGE_TITLE_CREATE;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    EquipController::PAGE_TITLE_INDEX => ['url' => '/equip'],
    $this->title => ['url' => ''],
];

?>
<div class="equip-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

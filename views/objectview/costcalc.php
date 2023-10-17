<?php

use app\components\Service;
use app\controllers\ObjectController;
use app\controllers\SiteController;

/** @var \app\models\Objects $model */

$this->title = $model->getAddress();

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    ObjectController::PAGE_TITLE_INDEX => ['url' => '/object'],
    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];

?>

<?= Yii::$app->runAction('/costcalc', ['ajax' => true, 'object' => $model->id]); ?>

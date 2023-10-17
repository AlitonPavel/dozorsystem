<?php

use app\controllers\SiteController;
use app\controllers\CostcalcController;
use app\controllers\CostcalcworkController;

$this->title = 'Платежные документы в смете' . ' №' . $model->id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],

    $this->title => ['url' => '', 'params' => ['id' => $model->id]],
];
?>

<?= \app\components\Service::pageBuild(); ?>

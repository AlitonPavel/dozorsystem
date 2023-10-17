<?php

use app\controllers\DemandController;
use app\controllers\DemandviewController;
use app\controllers\SiteController;

$this->title = DemandviewController::PAGE_TITLE_INDEX . ' №' . $id;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    DemandController::PAGE_TITLE_INDEX => ['url' => '/demand'],
    $this->title => ['url' => '/demand/view', 'params' => ['id' => $id]],
    \app\controllers\DemandcommentController::PAGE_TITLE_INDEX . ' к заявке №' . $id => ['url' => '', 'params' => ['id' => $id]],
];
?>

<?=
Yii::$app->runAction('/demandcomment/index', ['id' => $id, 'ajax' => true]);
?>

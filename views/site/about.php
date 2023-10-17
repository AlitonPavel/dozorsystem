<?php

/* @var $this yii\web\View */

use app\controllers\SiteController;
use app\components\Service;

$this->title = SiteController::PAGE_TITLE_ABOUT;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];
?>
<div class="site-about">
    <?= Service::pageBuild(); ?>
</div>

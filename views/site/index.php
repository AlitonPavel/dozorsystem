<?php
/* @var $this yii\web\View */

use app\controllers\SiteController;
use app\components\MenuController;

$this->title = 'Главная';

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

?>

<h2>Меню</h2>

<ul class="index_menu">
    <?= MenuController::getMenuHtmlForIndex(); ?>
</ul>

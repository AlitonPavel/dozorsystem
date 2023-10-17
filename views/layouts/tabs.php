<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\TopMenu;
use app\components\Breadcrumbs;
use app\components\MenuController;

AppAsset::register($this);

$this->registerCssFile('@web/css/tabs.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php
$user = Yii::$app->user->identity;
?>
<?php $this->beginBody() ?>

<div class="main">
    <div class="main_container tabs">
        <div class="main_container_logo">
            <div class="main_container_logo_left">
                <a href="<?= \yii\helpers\Url::to('/')?>"></a>
            </div>
        </div>
        <div class="main_container_menu">
            <?= TopMenu::widget([
                'options' => [
                    // todo вот тут бы получать массив из какони-будь файла
                    'tree' => MenuController::getMenu()
                ]
            ]); ?>
        </div>
        <div class="main_container_breadcrumbds">
            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
        </div>
        <?= Alert::widget() ?>
        <div class="tabs">
        <?php foreach (Yii::$app->controller->tabs as $tab) { ?>
            <a href="<?= $tab['url']?>"><div class="tabs_item <?= Yii::$app->controller->action->id == $tab['id'] ? 'tabs_item_current' : '' ?>"><?= $tab['title'] ?></div></a>
        <?php } ?>
        </div>

        <div class="main_container_page">
            <?= $content ?>
        </div>
        <div class="main_container_footer">
            <br />
            <br />
            <br />
            <br />
            <br />
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

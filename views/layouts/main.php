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
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/css/images/favicon_DS.png">
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
    <div class="main_container">
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
        <div class="main_container_page">
            <div class="main_container_title">
                <?= $this->title ?>
            </div>
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

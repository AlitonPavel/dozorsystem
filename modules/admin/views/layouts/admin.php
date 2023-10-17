<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\TopMenu;
use app\components\Breadcrumbs;

AppAsset::register($this);
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
    <div class="main_container">
        <div class="main_container_menu">
            <?= TopMenu::widget([
                'options' => [
                    // todo вот тут бы получать массив из какони-будь файла
                    'tree' => [
                        ['name' => 'Главная', 'url' => '/admin/admin', 'childs' => [
                            Yii::$app->user->isGuest ?
                                ['name' => 'Вход', 'url' => 'site/login'] :
                                ['name' => 'Выход (' . $user->getFIO() . ')' , 'url' => '/site/logout'],
                        ]],
                        ['name' => 'Вернуться на сайт', 'url' => '/']
                    ]
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
        <br />
        <br />
        <br />
        <br />
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


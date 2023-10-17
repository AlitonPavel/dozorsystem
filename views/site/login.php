<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\components\Form;
use app\controllers\SiteController;

$this->title = SiteController::PAGE_TITLE_LOGIN;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

?>
<div class="site-login">
    <p>Заполните форму для входа:</p>
    <?php
    $form = Form::begin([
        'id' => 'login-form',
        'model' => $model,
        'submitName' => 'Войти'
    ]);
    ?>
    <?= $form->createInputText(['id' => 'username', 'autocomplete' => "off"]); ?>
    <?= $form->createInputPassword(['id' => 'password', 'autocomplete' => "new-password"]); ?>
    <br>
    <?php Form::end(); ?>
</div>

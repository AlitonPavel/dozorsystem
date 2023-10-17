<?php

use app\modules\admin\controllers\AdminController;
use app\modules\admin\controllers\UserController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Создать пользователя';

$this->params['breadcrumbs'] = [
    AdminController::PAGE_TITLE_INDEX => ['url' => '/admin/admin'],
    UserController::PAGE_TITLE_INDEX => ['url' => '/admin/user'],
    'Создание пользователя' => ['url' => ''],
];

?>
<div class="user-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

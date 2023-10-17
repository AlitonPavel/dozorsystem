<?php

use yii\helpers\Url;

$this->title = 'Админка';

$this->params['breadcrumbs'] = [
    $this->title => ['url' => ''],
];

?>
<style>
    .admin-menu li {
            margin-bottom: 1em;
        }
</style>
<h3>Администрирование</h3>
<ul class="admin-menu">
    <li><a href="<?= Url::to(['/admin/user'])?>">Список пользователей</a></li>
    <li><a href="<?= Url::to(['/admin/admin/telegram'])?>">Инструкция к Telegram</a></li>
    <li><a href="<?= Url::to(['/admin/admin/icq'])?>">Инструкция к ICQ</a></li>
</ul>

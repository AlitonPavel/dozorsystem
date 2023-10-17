<?php
$this->title = 'Инструкция Telegram';

$this->params['breadcrumbs'] = [
    'Админка' => ['url' => '/admin/admin'],
    $this->title => ['url' => ''],
];

?>

<ul>
    <li>
        <div>Создаем канал</div>
        <div>
            <img src="/web/images/telegram01.jpg">
        </div>
    </li>
    <li>
        <div>Пишем человеко-понятное название канала</div>
        <div>
            <img src="/web/images/telegram02.jpg">
        </div>
    </li>
    <li>
        <div>Выбираем "Публичный канал" и пишем ссылку - это идентификатор канала (запоминаем)</div>
        <div>
            <img src="/web/images/telegram03.jpg">
        </div>
    </li>
    <li>
        <div>Добавляем участника. Начинаем вводить dozorsystembot. Добавляем "Бот компании DozorSystem"</div>
        <div>
            <img src="/web/images/telegram04.jpg">
        </div>
    </li>
    <li>
        <div>Бота можно добавить только как администратора канала. Поэтому делаем его администратором и назначаем права как на рисунке</div>
        <div>
            <img src="/web/images/telegram05.jpg">
        </div>
    </li>
    <li>
        После того как создали канал и добавили в него бота, прописываем идентификатора канала в базу, не забыв проставить @ перед названием.
    </li>
</ul>


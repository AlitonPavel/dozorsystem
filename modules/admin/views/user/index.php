<?php

use app\modules\admin\controllers\AdminController;
use app\components\ActiveRecordTable;
use app\models\User;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\components\Filter;


$this->title = 'Список пользователей';

$this->params['breadcrumbs'] = [
    AdminController::PAGE_TITLE_INDEX => ['url' => '/admin/admin'],
    $this->title => ['url' => ''],
];

/** @var \app\models\User[] $users */
/** @var \app\components\BaseView $this */

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Добавить пользователя',
    'href' => Url::to('/admin/user/create')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'usertable',
    'query' => User::find(),
    'columns' => [
        ['name' => 'Фамилия', 'fieldname' => 'surname', 'type' => ActiveRecordTable::TYPE_CALC, 'filtercondition' => Table::FILTER_COND_LIKE, 'calc' => function (User $row) {
            return '<a data-pjax="0" href="' . Url::to('/admin/user/' . $row->getId()) . '">' . $row->getFullFIO() . '</a>';
        }],
        ['name' => 'Логин', 'fieldname' => 'login', 'filtercondition' => Table::FILTER_COND_LIKE],
        ['name' => 'Дата добавления', 'fieldname' => 'date_create', 'type' => ActiveRecordTable::TYPE_DATETIME, 'filtercondition' => Table::FILTER_COND_LIKE],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'buttons' => [
            Table::BTN_INSERT => function (User $row) {
                return Url::to('/admin/user/create');
            },
            Table::BTN_EDIT => function (User $row) {
                return Url::to(['/admin/user/update', 'id' => $row->getId()]);
            },
            Table::BTN_DELETE => function (User $row) {
                return Url::to(['/admin/user/delete', 'id' => $row->getId()]);
            },
        ],
        ]
    ]
]);
?>






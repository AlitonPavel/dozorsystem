<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Table;
use app\components\Button;
use app\controllers\SiteController;
use app\models\Bank;
use app\controllers\DemandcommentController;
use app\models\DemandComment;

if (!isset($ajax)) {
    $this->title = DemandcommentController::PAGE_TITLE_INDEX;

    $this->params['breadcrumbs'] = [
        SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
        $this->title => ['url' => ''],
    ];
}
/** @var \app\components\BaseView $this */

?>
<h1>Комментарии к заявке №<?= $demand->id; ?></h1>
<div class="row filter_panel">
    <?= Yii::$app->runAction('/demandcomment/create', ['ajax' => true]); ?>
</div>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'banks',
    'query' => DemandComment::find()
                    ->andWhere('deldate is null')
                    ->andWhere(['demand_id' => $demand->id])
                    ->addOrderBy('id desc'),
    'columns' => [
        ['name' => 'Дата', 'fieldname' => 'date', 'type' => 'date', 'width' => '130px'],
        ['name' => 'Автор', 'fieldname' => 'user_id', 'width' => '130px', 'type' => ActiveRecordTable::TYPE_CALC,'calc' => function(DemandComment $row) {
            return isset($row->user) ? $row->user->getFIO() : '';
        }],
        ['name' => 'Комментарий', 'fieldname' => 'comment'],
        ['name' => 'Действие', 'type' => ActiveRecordTable::TYPE_ACTION, 'width' => '50px', 'buttons' => [
            Table::BTN_EDIT => function (DemandComment $row) {
                return Url::to(['/demandcomment/update', 'id' => $row->id]);
            },
            Table::BTN_DELETE => function (DemandComment $row) {
                return Url::to(['/demandcomment/delete', 'id' => $row->id]);
            },
        ],
        ]
    ]
]);
?>






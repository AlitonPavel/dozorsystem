<?php

use app\components\ActiveRecordTable;
use yii\helpers\Url;
use app\components\Button;
use app\controllers\FiasController;
use app\controllers\SiteController;
use app\models\Street;

$this->title = FiasController::PAGE_TITLE_INDEX;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    $this->title => ['url' => ''],
];

?>
<?= Button::widget([
    'id' => 'btn_add',
    'value' => 'Обновить ФИАС',
    'href' => Url::to('/fias/refresh')
]); ?>
<br />
<?= ActiveRecordTable::widget([
    'id' => 'streetable',
    'query' => Street::find()->joinWith('region')->addOrderBy('name'),
    'columns' => [
            ['name' => 'Наименование', 'alias' => 'streets', 'fieldname' => 'name', 'value' => function($row) {return $row->getFullName();}, 'filtercondition' => ActiveRecordTable::FILTER_COND_LIKE],
            ['name' => 'Тип', 'alias' => 'streets', 'fieldname' => 'type', 'filtercondition' => ActiveRecordTable::FILTER_COND_LIKE],
            ['name' => 'Регион', 'alias' => 'regions', 'fieldname' => 'name', 'value' => function($row) {return $row->region->name;}, 'filtercondition' => ActiveRecordTable::FILTER_COND_LIKE],
        ]
    ]);
?>






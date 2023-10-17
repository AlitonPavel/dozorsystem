<?php

/** @var \app\components\ActiveRecordTable $widget */
/** @var \app\components\BaseView $this */
/** @var \yii\data\Pagination $paginator */
/** @var array $prepareData */

use app\components\LinkPager;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerCssFile('@web/css/components/table.css');
$this->registerJsFile('@web/js/components/table.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<?php Pjax::begin(['id' => $widget->getPjaxId()]); ?>
<form autocomplete="off" data-pjax="1" action="<?= Url::to([]) ?>">
    <table id="<?= $widget->id ?>" cellpadding="0" cellspacing="0" class="table">
        <thead>
            <?= $widget->renderCustomHeader(); ?>
            <?= $widget->renderHeadColumns(); ?>
            <?= $widget->renderFilterColumns(); ?>
        </thead>
        <tbody>
            <?= $widget->renderData(); ?>
            <?= $widget->renderAggregates(); ?>
            <?= $widget->renderGlobalAggregates(); ?>
        </tbody>
    </table>
    <?= LinkPager::widget(['pagination' => $paginator, 'firstPageLabel' => 'В начало', 'lastPageLabel' => 'В конец']); ?>
    <input id="<?= $widget->getSubmitId(); ?>" type="submit" style="display: none; visibility: hidden">
</form>
<?php Pjax::end(); ?>
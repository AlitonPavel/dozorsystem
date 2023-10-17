<?php

use app\components\Form;
use app\components\Utils;
use app\controllers\DemandController;
use app\controllers\DemandviewController;
use app\controllers\SiteController;
use yii\helpers\Url;
use app\controllers\SuggestController;
use app\components\TextArea;

?>
<div class="grid">
<?php
$form = Form::begin([
    'id' => 'tomaster',
    'action' => Url::to(['/demand/tomaster', 'id' => $model->id, 'partial' => false]),
    'model' => $model,
    'method' => 'post',
    'submitName' => 'Передать заявку мастеру'
]);
?>

    <div class="row">
        <div class="column">
            <?= $form->createSelectInput(['id' => 'master', 'caption' => $model->getAttributeLabel('master'), 'width' => '200px','items' => SuggestController::getUsersForSelectInput()]) ?>
        </div>
        <div class="column">
            <?= $form->createDateTimeInput(['id' => 'datemaster', 'value' => date(Utils::DEFAULT_DATE_FORMAT2), 'caption' => $model->getAttributeLabel('datemaster')]) ?>
        </div>
    </div>
    <div class="row">
        <?= TextArea::widget(['id' => 'comment', 'caption' => 'Комментарий',  'width' => '100%', 'height' => '100px', 'value' => $model->getMessageForToMaster()]); ?>
    </div>

<?php Form::end(); ?>
</div>
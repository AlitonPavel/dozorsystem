<?php
/** @var \app\models\CostCalc $model */
/** @var \app\components\BaseView $this */

/* @var $form yii\widgets\ActiveForm */

use app\components\CostCalc;
use app\components\Form;
use app\controllers\CostcalcController;
use app\controllers\SiteController;
use app\controllers\SuggestController;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\controllers\CostcalcviewController;

$title = CostcalcController::PAGE_TITLE_UPDATE_DETAILS;

$this->title = $title;

$this->params['breadcrumbs'] = [
    SiteController::PAGE_TITLE_INDEX => ['url' => '/'],
    CostcalcController::PAGE_TITLE_INDEX => ['url' => '/costcalc'],
    $model->getTypeName() . ' №' . $model->id => ['url' => '/costcalc/view', 'params' => ['id' => $model->id]],
    $title => ['url' => '', 'params' => ['id' => $model->id]],
];

?>


<div class="grid">
    <?php
    $form = Form::begin([
        'id' => 'costcalc',
        'model' => $model
    ]);
    ?>

    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'startlowsum']); ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'starthighsum']); ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'farelowsum']); ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'farehighsum']); ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'projectlowsum']); ?>
        </div>
        <div class="column">
            <?= $form->createInputPrice(['id' => 'projecthighsum']); ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputPrice(['id' => 'discount']); ?>
        </div>
    </div>
    <div class="row">
        <?= $model->renderGeneralErrors(); ?>
    </div>
    <?php Form::end(); ?>
</div>
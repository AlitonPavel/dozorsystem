<?php
    /** @var \app\models\DemandPrior $model */
    /** @var \app\components\BaseView $this */
    /* @var $form yii\widgets\ActiveForm */
    use app\components\Form;
?>

<?php
    $form = Form::begin([
        'id' => 'demandprior',
        'model' => $model
    ]);
?>
    <?= $form->createInputText(['id' => 'name']); ?>
    <?= $form->createInputText(['id' => 'leadtime']); ?>
<?php Form::end(); ?>

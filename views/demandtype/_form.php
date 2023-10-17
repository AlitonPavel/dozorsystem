<?php
    /** @var \app\models\DemandType $model */
    /** @var \app\components\BaseView $this */
    /* @var $form yii\widgets\ActiveForm */
    use app\components\Form;
?>

<?php
    $form = Form::begin([
        'id' => 'demandtype',
        'model' => $model
    ]);
?>
    <?= $form->createInputText(['id' => 'name']); ?>
<?php Form::end(); ?>

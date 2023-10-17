<?php
    /** @var \app\models\Bank $model */
    /** @var \app\components\BaseView $this */
    /* @var $form yii\widgets\ActiveForm */
    use app\components\Form;
?>

<?php
    $form = Form::begin([
        'id' => 'bank',
        'model' => $model
    ]);
?>
    <?= $form->createInputText(['id' => 'name', 'width' => '600px']); ?>
    <?= $form->createInputText(['id' => 'account', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'bic', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'inn', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'kpp', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'okpo', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'ogrn', 'width' => '200px']); ?>
    <?= $form->createInputText(['id' => 'okato', 'width' => '200px']); ?>
<?php Form::end(); ?>

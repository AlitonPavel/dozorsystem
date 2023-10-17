<?php
    /** @var \app\models\Client $model */
    /** @var \app\components\BaseView $this */
    /* @var $form yii\widgets\ActiveForm */
    use app\components\Form;
use app\controllers\SuggestController;
use yii\helpers\Url;

?>
<div class="grid">
<?php
    $form = Form::begin([
        'id' => 'client',
        'model' => $model
    ]);
?>

    <div class="row">
        <?= $form->createInputText(['id' => 'name', 'width' => '350px']); ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'fullname', 'width' => '350px']); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'inn']); ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'kpp']); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'account', 'width' => '350px']); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'ogrn']); ?>
        </div>
        <div class="column">
            <?= $form->createInputText(['id' => 'okpo']); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'factaddress', 'width' => '450px']); ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'juraddress', 'width' => '450px']); ?>
    </div>
    <div class="row">
        <?= $form->createInputText(['id' => 'email', 'width' => '350px']); ?>
    </div>
    <div class="row">
        <div class="column">
            <?= $form->createAutoComplete([
                'id' => 'bank_id',
                'source' => Url::to(['/suggest', SuggestController::reqModel => 'b']),
                'model' => $model,
                'width' => '600px',
                'value' => $model->bank_id,
                'text' => isset($model->bank) ? $model->bank->name : ''
            ]); ?>
        </div>
        <div class="column">
            <a href="<?= Url::to('/bank')?>" target="_blank">Справочник банков</a>
        </div>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'companydetails', 'width' => '100%', 'height' => '50px']); ?>
    </div>
    <div class="row">
        <?= $form->createTextArea(['id' => 'note', 'width' => '100%', 'height' => '50px']); ?>
    </div>
<?php Form::end(); ?>
</div>
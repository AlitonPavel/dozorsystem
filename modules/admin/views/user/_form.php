<?php
    /** @var \app\models\User $model */
    /** @var \app\components\BaseView $this */
    /* @var $form yii\widgets\ActiveForm */
    use app\components\Form;
    use app\commands\rbac\RoleController;
    use app\components\Button;
?>
<div class="grid">
<?php
    $form = Form::begin([
        'id' => 'user',
        'model' => $model
    ]);
?>
    <?= $form->createInputText(['id' => 'login']); ?>
    <?= $form->createInputText(['id' => 'password']); ?>
    <?= $form->createInputText(['id' => 'surname']); ?>
    <?= $form->createInputText(['id' => 'first_name']); ?>
    <?= $form->createInputText(['id' => 'last_name']); ?>
    <?= $form->createInputText(['id' => 'email', 'width' => '300px']); ?>
    <?= $form->createInputText(['id' => 'tlgm', 'width' => '300px']); ?>
    <div class="row">
        <div class="column">
            <?= $form->createInputText(['id' => 'icq', 'width' => '300px']); ?>
        </div>
    </div>
    <div class="row">
        <?= Button::widget([
            'id' => 'test',
            'value' => 'Отправить тестовое сообщение',
            'type' => 'button'
        ]); ?>
    </div>
    <h3>Роли:</h3>
    <?php
        foreach (RoleController::getAllRolesByUser($model->getId()) as $role)
        {
            echo $form->createCheckBox(['id' => $role['role'], 'caption' => $role['rolename'], 'value' => $role['checked'], 'groupName' => 'Roles']);
        }
    ?>
    <br>
<?php Form::end(); ?>
</div>
<?php
$js = <<<EOF
    $(document).ready(function() {
        $('#test').on('click', function() {
            $.ajax({
                'url': '/admin/user/testmessage',
                'data': {
                    'email': $('#email').val(),
                    'telegram': $('#tlgm').val(),
                    'icq': $('#icq').val()
                },
                'success': function(res) {
                    res = JSON.parse(res);
                    console.log(res);
                }
            });
        });
    });
EOF;

$this->registerJs($js);

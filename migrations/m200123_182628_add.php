<?php

use yii\db\Migration;
use app\models\User;
use app\commands\rbac\RoleController;
/**
 * Class m200123_182628_add
 */
class m200123_182628_add extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $model = new User();
        $model->login = 'test';
        $model->password = 'test';
        $model->first_name = 'Тест';
        $model->surname = 'Тест';
        $model->last_name = 'Тест';
        $model->date_create = date('Y-m-d H:i');
        $model->save();

        RoleController::updateUserRoles(['public'], $model->getId());
    }

    public function down()
    {
        echo "m200123_182628_add cannot be reverted.\n";
        $this->delete('users', ['login' => 'test']);
//        return false;
    }

}

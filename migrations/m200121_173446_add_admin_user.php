<?php

use app\commands\rbac\RoleController;
use app\models\User;
use yii\db\Migration;
/**
 * Class m200121_173446_add_admin_user
 */
class m200121_173446_add_admin_user extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $model = new User();
        $model->login = 'admin';
        $model->password = '1234';
        $model->first_name = 'Павел';
        $model->surname = 'Рогов';
        $model->last_name = 'Юрьевич';
        $model->date_create = date('Y-m-d H:i');
        $model->save();

        RoleController::updateUserRoles(['admin'], $model->getId());

        $model2 = new User();
        $model2->login = 'vadim';
        $model2->password = '1234';
        $model2->first_name = 'Вадим';
        $model2->surname = 'Чистоусов';
        $model2->last_name = 'Чистоусов';
        $model2->date_create = date('Y-m-d H:i');
        $model2->save();

        RoleController::updateUserRoles(['admin'], $model2->getId());
    }

    public function down()
    {
        $this->delete('users', ['login' => 'admin']);
        $this->delete('users', ['login' => 'vadim']);
    }

}

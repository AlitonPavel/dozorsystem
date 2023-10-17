<?php

use yii\db\Migration;
/**
 * Class m200121_172120_create_table_users
 */
class m200121_172120_create_table_users extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(50)->notNull(),
            'first_name' => $this->string(25)->notNull(),
            'surname' => $this->string(25)->notNull(),
            'last_name' => $this->string(25)->notNull(),
            'access_token' => $this->string(50),
            'auth_key' => $this->string(50),
            'date_create' => $this->dateTime(),
            'user_create' => $this->integer(),
            'date_change' => $this->dateTime(),
            'user_change' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }

}

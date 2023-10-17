<?php

use yii\db\Migration;

/**
 * Class m200218_175520_create_table_demandtypes
 */
class m200218_175520_create_table_demandtypes extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('demandtypes', [
            'id' => $this->primaryKey(),
            'name' => $this->string(36)->notNull()->unique(),
            'datecreate' => $this->dateTime(),
            'usercreate' => $this->integer(),
            'datechange' => $this->dateTime(),
            'userchange' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);
    }

    public function down()
    {
        echo "m200218_175520_create_table_demandtypes cannot be reverted.\n";

        $this->dropTable('demandtypes');
    }

}

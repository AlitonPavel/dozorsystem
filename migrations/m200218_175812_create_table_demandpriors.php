<?php

use yii\db\Migration;

/**
 * Class m200218_175812_create_table_demandpriors
 */
class m200218_175812_create_table_demandpriors extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('demandpriors', [
            'id' => $this->primaryKey(),
            'name' => $this->string(36)->notNull()->unique(),
            'leadtime' => $this->integer()->notNull(),
            'datecreate' => $this->dateTime(),
            'usercreate' => $this->integer(),
            'datechange' => $this->dateTime(),
            'userchange' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);
    }

    public function down()
    {
        echo "m200218_175812_create_table_demandpriors cannot be reverted.\n";

        $this->dropTable('demandpriors');
    }

}

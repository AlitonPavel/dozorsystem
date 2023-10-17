<?php

use yii\db\Migration;

/**
 * Class m200419_114138_add_table_demandcomments
 */
class m200419_114138_add_table_demandcomments extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('demandcomments', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime()->notNull(),
            'demand_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'comment' => $this->text()->notNull(),
            'datecreate' => $this->dateTime(),
            'usercreate' => $this->integer(),
            'datechange' => $this->dateTime(),
            'userchange' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);

        $this->createIndex('demand_id_idx', 'demandcomments', 'demand_id', false);
    }

    public function down()
    {
        echo "m200419_114138_add_table_demandcomments cannot be reverted.\n";
        $this->dropTable('demandcomments');
    }

}

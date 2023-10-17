<?php

use yii\db\Migration;

/**
 * Class m200321_125347_add_demand_history
 */
class m200321_125347_add_demand_history extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('demandhistories', [
            'id' => $this->primaryKey(),
            'action' => $this->integer(),
            'dateaction' => $this->dateTime(),
            'demand_id' => $this->integer()->notNull(),
            'object_id' => $this->integer(),
            'street_id' => $this->string(36),
            'client_id' => $this->integer(),
            'date' => $this->dateTime()->notNull(),
            'creator' => $this->string(120),
            'contact' => $this->string(200),
            'type_id' => $this->integer()->notNull(),
            'prior_id' => $this->integer()->notNull(),
            'demandtext' => $this->text()->notNull(),
            'report' => $this->text(),
            'master' => $this->integer(),
            'datemaster' => $this->dateTime(),
            'deadline' => $this->dateTime(),
            'datexec' => $this->dateTime(),
            'firstdatemaster' => $this->dateTime(),
            'deldate' => $this->dateTime()
        ]);

        $this->createIndex('demand_id_idx', 'demandhistories', ['demand_id'], false);
    }

    public function down()
    {
        echo "m200321_125347_add_demand_history cannot be reverted.\n";
        $this->dropTable('demandhistories');
    }

}

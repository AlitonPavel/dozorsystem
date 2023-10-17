<?php

use yii\db\Migration;

/**
 * Class m200219_190419_change_table_objects
 */
class m200219_190419_change_table_objects extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('demands', 'object_id', $this->integer()->notNull());
        $this->addColumn('demands', 'datemaster', $this->dateTime());
    }

    public function down()
    {
        echo "m200219_190419_change_table_objects cannot be reverted.\n";

        $this->alterColumn('demands', 'object_id', $this->integer());
        $this->dropColumn('demands', 'datemaster');
    }

}

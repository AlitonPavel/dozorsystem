<?php

use yii\db\Migration;

/**
 * Class m200321_123158_change_table_clients
 */
class m200321_123158_change_table_clients extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('clients', 'email', $this->string(200));
        $this->addColumn('clients', 'note', $this->text());
    }

    public function down()
    {
        echo "m200321_123158_change_table_clients cannot be reverted.\n";
        $this->dropColumn('clients', 'email');
        $this->dropColumn('clients', 'note');
    }
}

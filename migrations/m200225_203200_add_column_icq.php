<?php

use yii\db\Migration;

/**
 * Class m200225_203200_add_column_icq
 */
class m200225_203200_add_column_icq extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('users', 'icq', $this->string(200));
    }

    public function down()
    {
        echo "m200225_203200_add_column_icq cannot be reverted.\n";

        $this->dropColumn('users', 'icq');
    }
}

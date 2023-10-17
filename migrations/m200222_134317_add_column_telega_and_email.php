<?php

use yii\db\Migration;

/**
 * Class m200222_134317_add_column_telega_and_email
 */
class m200222_134317_add_column_telega_and_email extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('users', 'email', $this->string(250));
        $this->addColumn('users', 'tlgm', $this->string(250));
    }

    public function down()
    {
        echo "m200222_134317_add_column_telega_and_email cannot be reverted.\n";

        $this->dropColumn('users', 'email');
        $this->dropColumn('users', 'tlgm');
    }

}

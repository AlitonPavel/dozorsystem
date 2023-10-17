<?php

use yii\db\Migration;

/**
 * Class m200321_113040_add_room_in_object
 */
class m200321_113040_add_room_in_object extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('objects', 'room', $this->string(100));
    }

    public function down()
    {
        echo "m200321_113040_add_room_in_object cannot be reverted.\n";
        $this->dropColumn('objects', 'room');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m200218_194235_change_table_objects
 */
class m200218_194235_change_table_objects extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $command =  Yii::$app->db->createCommand('update objects set datebuild = null where true');
        $command->execute();
        $this->alterColumn('objects', 'datebuild', $this->integer());
    }

    public function down()
    {
        echo "m200218_194235_change_table_objects cannot be reverted.\n";
        $this->alterColumn('objects', 'datebuild', $this->dateTime());
    }

}

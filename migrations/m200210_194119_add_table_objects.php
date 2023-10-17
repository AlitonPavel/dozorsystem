<?php

use yii\db\Migration;

/**
 * Class m200210_194119_add_table_objects
 */
class m200210_194119_add_table_objects extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('objects', [
            'id' => $this->primaryKey(),
            'street_id' => $this->string(36)->notNull(),
            'house' => $this->string(20)->notNull(),
            'corp' => $this->string(10),
            'client_id' => $this->integer(),
            'manager' => $this->integer(),
            'datebuild' => $this->dateTime(),
            'quant_doorway' => $this->integer(),
            'is_service' => $this->boolean(),
            'note' => $this->text(),
            'date_create' => $this->dateTime(),
            'user_create' => $this->integer(),
            'date_change' => $this->dateTime(),
            'user_change' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);

        $this->createIndex('house_idx', 'objects', ['house'], false);
        $this->createIndex('house_corp_deldate_idx', 'objects', ['house', 'corp', 'deldate'], true);
    }

    public function down()
    {
        $this->dropTable('objects');
    }

}

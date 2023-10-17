<?php

use yii\db\Migration;

/**
 * Class m200322_125117_add_table_equips
 */
class m200322_125117_add_table_equips extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('equips', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string()->notNull()->unique(),
            'note'                  => $this->text(),
            'unit_id'               => $this->integer(),
            'pricelow'              => $this->integer(),
            'pricehigh'             => $this->integer(),
            'datecreate'            => $this->dateTime(),
            'usercreate'            => $this->integer(),
            'datechange'            => $this->dateTime(),
            'userchange'            => $this->integer(),
            'deldate'               => $this->dateTime()
        ]);

        $this->createIndex('equips_id_name_idx', 'equips', ['id', 'name'], false);
    }

    public function down()
    {
        echo "m200322_125117_add_table_equips cannot be reverted.\n";

        $this->dropTable('equips');
    }

}

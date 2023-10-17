<?php

use yii\db\Migration;

/**
 * Class m200203_185847_fias
 */
class m200203_185847_fias extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        // Регионы
        $this->createTable('regions', [
            'id' => $this->string(36),
            'name' => $this->string(120)
        ]);

        $this->addPrimaryKey('region_pk_idx', 'regions', 'id');
        $this->createIndex('region_name_idx', 'regions', 'name', false);

        // Улицы
        $this->createTable('streets', [
            'id' => $this->string(36),
            'region_id' => $this->string(36),
            'type' => $this->string(10),
            'name' => $this->string(120)
        ]);

        $this->addPrimaryKey('street_pk_idx', 'streets', 'id');
        $this->createIndex('street_name_idx', 'streets', 'name', false);
    }

    public function down()
    {
        $this->dropTable('regions');
        $this->dropTable('streets');
    }

}

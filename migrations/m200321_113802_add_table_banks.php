<?php

use yii\db\Migration;

/**
 * Class m200321_113802_add_table_banks
 */
class m200321_113802_add_table_banks extends Migration
{
        // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('banks', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull()->unique(),
            'account' => $this->string(20),
            'bic' => $this->string(10)->unique(),
            'inn' => $this->string(10),
            'kpp' => $this->string(9),
            'okpo' => $this->string(8),
            'ogrn' => $this->string(13),
            'okato' => $this->string(13),
            'date_create' => $this->dateTime(),
            'user_create' => $this->dateTime(),
            'date_change' => $this->dateTime(),
            'user_change' => $this->integer(),
            'deldate' => $this->dateTime(),
        ]);

        $this->createIndex('banks_name_id_idx', 'banks', ['id', 'name'], false);

        $this->addColumn('clients', 'bank_id', $this->integer());
    }

    public function down()
    {
        echo "m200321_113802_add_table_banks cannot be reverted.\n";

        $this->dropTable('banks');
        $this->dropColumn('clients', 'bank_id');
    }
}

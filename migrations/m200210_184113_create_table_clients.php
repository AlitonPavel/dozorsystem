<?php

use yii\db\Migration;

/**
 * Class m200210_184113_create_table_clients
 */
class m200210_184113_create_table_clients extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('clients', [
            'id' => $this->primaryKey(),
            'client_name' => $this->string(200)->notNull()->unique(),
            'inn' => $this->string(10),
            'kpp' => $this->string(9),
            'account' => $this->string(20),
            'ogrn' => $this->string(13),
            'okpo' => $this->string(8),
            'date_create' => $this->dateTime(),
            'user_create' => $this->dateTime(),
            'date_change' => $this->dateTime(),
            'user_change' => $this->integer(),
            'deldate' => $this->dateTime(),
        ]);

        $this->createIndex('client_name_id_idx', 'clients', ['id', 'client_name'], false);
    }

    public function down()
    {
        $this->dropTable('clients');
    }

}

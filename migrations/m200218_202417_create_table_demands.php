<?php

use yii\db\Migration;

/**
 * Class m200218_202417_create_table_demands
 */
class m200218_202417_create_table_demands extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('demands', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer(),
            'street_id' => $this->string(36),
            'client_id' => $this->integer(),
            'date' => $this->dateTime()->notNull(),
            'creator' => $this->string(120),
            'contact' => $this->string(200)->notNull(),
            'type_id' => $this->integer()->notNull(),
            'prior_id' => $this->integer()->notNull(),
            'demandtext' => $this->text()->notNull(),
            'report' => $this->text(),
            'master' => $this->integer(),
            'deadline' => $this->dateTime(),
            'datexec' => $this->dateTime(),
            'datecreate' => $this->dateTime(),
            'usercreate' => $this->integer(),
            'datechange' => $this->dateTime(),
            'userchange' => $this->integer(),
            'deldate' => $this->dateTime()
        ]);

        $this->createIndex('date_idx', 'demands', ['date'], false);
        $this->createIndex('master_idx', 'demands', ['master'], false);
        $this->createIndex('deadline_idx', 'demands', ['deadline'], false);
    }

    public function down()
    {
        echo "m200218_202417_create_table_demands cannot be reverted.\n";

        $this->dropTable('demands');
    }

}


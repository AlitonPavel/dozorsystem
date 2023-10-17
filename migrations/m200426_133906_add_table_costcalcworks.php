<?php

use yii\db\Migration;

/**
 * Class m200426_133906_add_table_costcalcworks
 */
class m200426_133906_add_table_costcalcworks extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('costcalcworks', [
            'id'                    => $this->primaryKey(),
            'calc_id'               => $this->integer()->notNull(),
            'cceq_id'               => $this->integer(),
            'name'                  => $this->string()->notNull(),
            'quant'                 => $this->integer()->notNull(),
            'pricelow'              => $this->integer()->notNull(),
            'pricehigh'             => $this->integer()->notNull(),
            'pricelowsum'           => $this->integer()->notNull(),
            'pricehighsum'          => $this->integer()->notNull(),
            'note'                  => $this->text(),
            'sort'                  => $this->integer(),
            'datecreate'            => $this->dateTime(),
            'usercreate'            => $this->integer(),
            'datechange'            => $this->dateTime(),
            'userchange'            => $this->integer(),
            'deldate'               => $this->dateTime()
        ]);

        $this->createIndex('costcalcworks_calc_id_idx', 'costcalcworks', ['calc_id'], false);
    }

    public function down()
    {
        $this->dropTable('costcalcworks');
    }
}

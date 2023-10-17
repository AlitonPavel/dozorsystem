<?php

use yii\db\Migration;

/**
 * Class m200323_161310_add_table_costcalcequips
 */
class m200323_161310_add_table_costcalcequips extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('costcalcequips', [
            'id'                    => $this->primaryKey(),
            'calc_id'               => $this->integer()->notNull(),
            'equip_id'              => $this->integer()->notNull(),
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

        $this->createIndex('costcalcequips_calc_id_idx', 'costcalcequips', ['calc_id'], false);
    }

    public function down()
    {
        echo "m200323_161310_add_table_costcalcequips cannot be reverted.\n";

        $this->dropTable('costcalcequips');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m200527_173342_add_dateready_to_costcalc
 */
class m200527_173342_add_dateready_to_costcalc extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('costcalcs', 'dateready', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('costcalcs', 'dateready', $this->dateTime());
    }
}

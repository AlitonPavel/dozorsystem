<?php

use yii\db\Migration;

/**
 * Class m200322_113612_change_column_object_costcalc
 */
class m200322_113612_change_column_object_costcalc extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->renameColumn('costcalcs', 'object', 'object_id');
        $this->alterColumn('costcalcs', 'object_id', $this->integer());
        $this->renameColumn('costcalcs', 'comany_id', 'company_id');
    }

    public function down()
    {
        echo "m200322_113612_change_column_object_costcalc cannot be reverted.\n";

        $this->renameColumn('costcalcs', 'object_id', 'object');
        $this->alterColumn('costcalcs', 'object', $this->string());
        $this->renameColumn('costcalcs', 'company_id', 'comany_id');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m201025_122918_add_dateplan
 */
class m201025_122918_add_dateplan extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('demands', 'dateplan', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('demands', 'dateplan');
    }
}

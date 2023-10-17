<?php

use yii\db\Migration;

/**
 * Class m200601_165238_add_index_for_demand_creator_demtext
 */
class m200601_165238_add_index_for_demand_creator_demtext extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createIndex('demands_creator_idx', 'demands', ['creator'], false);
    }

    public function down()
    {
        $this->dropIndex('demands_creator_idx', 'demands');
    }

}

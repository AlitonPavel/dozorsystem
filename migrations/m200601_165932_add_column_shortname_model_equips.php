<?php

use yii\db\Migration;

/**
 * Class m200601_165932_add_column_shortname_model_equips
 */
class m200601_165932_add_column_shortname_model_equips extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('equips', 'shortname', $this->string(200));
        $this->addColumn('equips', 'model', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('equips', 'shortname');
        $this->dropColumn('equips', 'model');
    }

}

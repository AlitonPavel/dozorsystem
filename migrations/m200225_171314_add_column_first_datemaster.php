<?php

use yii\db\Migration;

/**
 * Class m200225_171314_add_column_first_datemaster
 */
class m200225_171314_add_column_first_datemaster extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('demands', 'firstdatemaster', $this->dateTime());
    }

    public function down()
    {
        echo "m200225_171314_add_column_first_datemaster cannot be reverted.\n";

        $this->dropColumn('demands', 'firstdatemaster');
    }

}

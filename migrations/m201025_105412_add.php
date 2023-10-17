<?php

use yii\db\Migration;

/**
 * Class m201025_105412_add
 */
class m201025_105412_add extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('demands', 'date_deferred', $this->dateTime());
        $this->addColumn('demands', 'reason_deferred', $this->text());
    }

    public function down()
    {
        $this->dropColumn('demands', 'date_deferred');
        $this->dropColumn('demands', 'reason_deferred');
    }

}

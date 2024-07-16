<?php

use yii\db\Migration;

/**
 * Class m240716_172536_add_new_address_column
 */
class m240716_172536_add_new_address_column extends Migration
{

    public function up()
    {
        $this->addColumn('demands', 'address', $this->string(200));
    }

    public function down()
    {
        $this->dropColumn('demands', 'address');
    }

}

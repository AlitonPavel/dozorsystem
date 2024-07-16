<?php

use yii\db\Migration;

/**
 * Class m240716_173024_del_not_null_object_id_in_demands
 */
class m240716_173024_del_not_null_object_id_in_demands extends Migration
{

    public function up()
    {
        $this->alterColumn('demands', 'object_id', $this->integer()->null());
    }

    public function down()
    {

    }
}

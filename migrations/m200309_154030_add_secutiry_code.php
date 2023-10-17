<?php

use yii\db\Migration;

/**
 * Class m200309_154030_add_secutiry_code
 */
class m200309_154030_add_secutiry_code extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('users', 'secretcode', $this->string(25));
    }

    public function down()
    {
        echo "m200309_154030_add_secutiry_code cannot be reverted.\n";
        $this->dropColumn('users', 'secretcode');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m200218_185923_change_table_clients
 */
class m200218_185923_change_table_clients extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->renameColumn('clients', 'client_name', 'name');

        $this->addColumn('clients', 'fullname', $this->string(250));
        $this->addColumn('clients', 'factaddress', $this->string(250));
        $this->addColumn('clients', 'juraddress', $this->string(250));
        $this->addColumn('clients', 'companydetails', $this->text());
    }

    public function down()
    {
        echo "m200218_185923_change_table_clients cannot be reverted.\n";

        $this->renameColumn('clients',  'name', 'client_name');

        $this->dropColumn('clients', 'fullname');
        $this->dropColumn('clients', 'factaddress');
        $this->dropColumn('clients', 'juraddress');
        $this->dropColumn('clients', 'companydetails');

    }

}

<?php

use yii\db\Migration;

/**
 * Class m200226_171006_create_table_costcalcs
 */
class m200226_171006_create_table_costcalcs extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('costcalcs', [
            'id'                    => $this->primaryKey(),
            'type_id'               => $this->integer(),
            'name'                  => $this->string(250),
            'date'                  => $this->dateTime(),
            'object'                => $this->string(),
            'client_id'             => $this->integer(),
            'user_id'               => $this->integer(),
            'contactFIO'            => $this->string(120),
            'contact'               => $this->string(120),
            'typepay'               => $this->string(50),
            'planpay'               => $this->text(),
            'prior_id'              => $this->integer(),
            'comany_id'             => $this->integer(),
            'equiplowsum'           => $this->integer(),
            'equiphighsum'          => $this->integer(),
            'worklowsum'            => $this->integer(),
            'workhighsum'           => $this->integer(),
            'startlowsum'           => $this->integer(),
            'starthighsum'          => $this->integer(),
            'farelowsum'            => $this->integer(),
            'farehighsum'           => $this->integer(),
            'projectlowsum'         => $this->integer(),
            'projecthighsum'        => $this->integer(),
            'discount'              => $this->integer(),
            'withoutdiscountsum'    => $this->integer(),
            'lowsum'                => $this->integer(),
            'highsum'               => $this->integer(),
            'profitsum'             => $this->integer(),
            'profitpercent'         => $this->integer(),
            'note'                  => $this->text(),
            'dateaccept'            => $this->dateTime(),
            'datecreate'            => $this->dateTime(),
            'usercreate'            => $this->integer(),
            'datechange'            => $this->dateTime(),
            'userchange'            => $this->integer(),
            'deldate'               => $this->dateTime()
        ]);
    }

    public function down()
    {
        echo "m200226_171006_create_table_costcalcs cannot be reverted.\n";

        $this->dropTable('costcalcs');
    }

}

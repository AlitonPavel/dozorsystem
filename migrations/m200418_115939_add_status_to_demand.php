<?php

use yii\db\Migration;
use app\models\Demand;
/**
 * Class m200418_115939_add_status_to_demand
 */
class m200418_115939_add_status_to_demand extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('demands', 'status', $this->integer());
        $this->addColumn('demandhistories', 'status', $this->integer());
        $this->createIndex('status_idx', 'demands', 'status', false);

        foreach (Demand::find()->all() as $demand)
        {
            if (empty($demand->status))
            {
                $demand->setScenario(Demand::SCENARIO_UPDATE);
                $demand->status = $demand->getStatus();
                $demand->save();
            }
        }
    }

    public function down()
    {
        $this->dropColumn('demands', 'status');
        $this->dropColumn('demandhistories', 'status');
    }

}

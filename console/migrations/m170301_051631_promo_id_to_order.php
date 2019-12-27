<?php

use yii\db\Migration;

class m170301_051631_promo_id_to_order extends Migration
{
    public function up()
    {

        $this->addColumn('order','promo_id',$this->integer());
    }

    public function down()
    {
        echo "m170301_051631_promo_id_to_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

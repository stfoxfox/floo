<?php

use yii\db\Migration;

class m170120_205526_add_columns_to_order extends Migration
{
    public function up()
    {

        $this->addColumn('order','payment_status',$this->integer()->defaultValue(0));
        $this->addColumn('order','restaurant_zone_id',$this->string());
        $this->addColumn('restaurant_zone','zone_external_id',$this->string());


    }

    public function down()
    {
        $this->dropColumn('order','payment_status',$this->integer()->defaultValue(0));
        $this->dropColumn('order','restaurant_zone_id',$this->integer()->defaultValue(0));

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

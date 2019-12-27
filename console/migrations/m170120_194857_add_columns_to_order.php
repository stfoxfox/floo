<?php

use yii\db\Migration;

class m170120_194857_add_columns_to_order extends Migration
{
    public function up()
    {

        $this->addColumn('order','sber_id',$this->string());
        $this->addColumn('order','platron_id',$this->string());
    }

    public function down()
    {
        echo "m170120_194857_add_columns_to_order cannot be reverted.\n";

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

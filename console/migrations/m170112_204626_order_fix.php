<?php

use yii\db\Migration;

class m170112_204626_order_fix extends Migration
{
    public function up()
    {

        $this->addColumn('order','name',$this->string());
    }

    public function down()
    {
        echo "m170112_204626_order_fix cannot be reverted.\n";

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

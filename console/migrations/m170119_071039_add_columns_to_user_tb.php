<?php

use yii\db\Migration;

class m170119_071039_add_columns_to_user_tb extends Migration
{
    public function up()
    {

        $this->addColumn('user','balance',$this->integer());

    }

    public function down()
    {
        echo "m170119_071039_add_columns_to_user_tb cannot be reverted.\n";

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

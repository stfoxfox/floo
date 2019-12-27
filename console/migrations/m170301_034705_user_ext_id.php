<?php

use yii\db\Migration;

class m170301_034705_user_ext_id extends Migration
{
    public function up()
    {

        $this->addColumn('user','ext_uuid',$this->string());
    }

    public function down()
    {
        echo "m170301_034705_user_ext_id cannot be reverted.\n";

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

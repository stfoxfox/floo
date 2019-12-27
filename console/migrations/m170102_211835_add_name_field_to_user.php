<?php

use yii\db\Migration;

class m170102_211835_add_name_field_to_user extends Migration
{
    public function up()
    {

        $this->addColumn('user','name',$this->string());
    }

    public function down()
    {
        echo "m170102_211835_add_name_field_to_user cannot be reverted.\n";

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

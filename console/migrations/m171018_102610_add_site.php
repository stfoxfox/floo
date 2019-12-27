<?php

use yii\db\Migration;

class m171018_102610_add_site extends Migration
{
    public function up()
    {

        $this->addColumn('external_site','created_at',$this->timestamp());

        $this->addColumn('external_site','updated_at',$this->timestamp());

    }

    public function down()
    {
        echo "m171018_102610_add_site cannot be reverted.\n";

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

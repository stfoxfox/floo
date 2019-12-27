<?php

use yii\db\Migration;

class m171029_092635_add_site_banner extends Migration
{
    public function up()
    {

        $this->addColumn('promo','site_banner_fine_name',$this->string());

    }

    public function down()
    {
        echo "m171029_092635_add_site_banner cannot be reverted.\n";

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

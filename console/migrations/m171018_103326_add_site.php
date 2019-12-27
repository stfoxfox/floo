<?php

use yii\db\Migration;

class m171018_103326_add_site extends Migration
{
    public function up()
    {
        $this->dropForeignKey('promo-external_site_id-fkey','promo');
        $this->addForeignKey('promo-external_site_id-fkey','promo','external_site_id','external_site','id','cascade','cascade');

    }

    public function down()
    {
        echo "m171018_103326_add_site cannot be reverted.\n";

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

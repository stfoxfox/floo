<?php

use yii\db\Migration;

class m171018_080158_add_site extends Migration
{
    public function up()
    {


        $this->addColumn('promo','external_site_id',$this->integer());

        $this->addForeignKey('promo-external_site_id-fkey','promo','external_site_id','promo','id','cascade','cascade');

        $this->createIndex('promo-external_site_id-idx','promo','external_site_id');

    }

    public function down()
    {
        echo "m171018_080158_add_site cannot be reverted.\n";

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

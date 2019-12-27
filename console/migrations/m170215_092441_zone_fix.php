<?php

use yii\db\Migration;

class m170215_092441_zone_fix extends Migration
{
    public function up()
    {
        $this->dropForeignKey('restaurant_zone-restaurant_id-fkey','restaurant_zone');

        $this->addForeignKey('restaurant_zone-restaurant_id-fkey','restaurant_zone','restaurant_id','restaurant','id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m170215_092441_zone_fix cannot be reverted.\n";

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

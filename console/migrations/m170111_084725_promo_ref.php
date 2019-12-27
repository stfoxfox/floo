<?php

use yii\db\Migration;

class m170111_084725_promo_ref extends Migration
{
    public function up()
    {


        $this->addColumn('promo','action_type',$this->integer()->defaultValue(0));
        $this->addColumn('promo','discount',$this->integer());
        $this->addColumn('promo','min_order',$this->float());

    }

    public function down()
    {
        $this->dropColumn('promo','action_type',$this->integer());
        $this->dropColumn('promo','discount',$this->integer());
        $this->dropColumn('promo','min_order',$this->float());
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

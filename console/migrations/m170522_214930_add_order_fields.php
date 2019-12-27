<?php

use yii\db\Migration;

class m170522_214930_add_order_fields extends Migration
{
    public function up()
    {

        $this->addColumn('order','dc_link_approve',$this->text());
        $this->addColumn('order','dc_link_cancel',$this->text());


    }

    public function down()
    {
        echo "m170522_214930_add_order_fields cannot be reverted.\n";

        return false;
    }
}

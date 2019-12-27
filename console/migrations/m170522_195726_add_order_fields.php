<?php

use yii\db\Migration;

class m170522_195726_add_order_fields extends Migration
{
    public function up()
    {

        $this->addColumn('order','delivery_at',$this->string());
    }

    public function down()
    {
        echo "m170522_195726_add_order_fields cannot be reverted.\n";

        return false;
    }
}

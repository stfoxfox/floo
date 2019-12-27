<?php

use yii\db\Migration;

class m170423_075942_add_full_address_to_address extends Migration
{
    public function up()
    {


        $this->addColumn('address','full_address', $this->string());
    }

    public function down()
    {
        echo "m170423_075942_add_full_address_to_address cannot be reverted.\n";

        return false;
    }
}

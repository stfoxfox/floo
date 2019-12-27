<?php

use yii\db\Migration;

class m170725_013426_add_css_class_field_to_catalogitem extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_item','css_class',$this->string());
    }

    public function safeDown()
    {
        echo "m170725_013426_add_css_class_field_to_catalogitem cannot be reverted.\n";

        return false;
    }
}

<?php

use yii\db\Migration;

class m170724_065246_add_alias_field_to_catalog extends Migration
{
    public function safeUp()
    {

        $this->addColumn('catalog_category','alias',$this->string());
        
    }

    public function safeDown()
    {
        echo "m170724_065246_add_alias_field_to_catalog cannot be reverted.\n";

        return false;
    }
}

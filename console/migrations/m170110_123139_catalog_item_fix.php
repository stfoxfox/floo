<?php

use yii\db\Migration;

class m170110_123139_catalog_item_fix extends Migration
{
    public function up()
    {

        $this->dropColumn('catalog_item','ext_code_st_st',$this->float());
        $this->dropColumn('catalog_item','ext_code_big_st',$this->float());
        $this->dropColumn('catalog_item','ext_code_st_big',$this->float());
        $this->dropColumn('catalog_item','ext_code_big_big',$this->float());

        $this->addColumn('catalog_item','ext_code_st_st',$this->string());
        $this->addColumn('catalog_item','ext_code_big_st',$this->string());
        $this->addColumn('catalog_item','ext_code_st_big',$this->string());
        $this->addColumn('catalog_item','ext_code_big_big',$this->string());
    }

    public function down()
    {
        echo "m170110_123139_catalog_item_fix cannot be reverted.\n";

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

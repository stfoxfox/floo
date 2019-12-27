<?php

use yii\db\Migration;

class m161211_211528_catalog_item_refactor extends Migration
{
    public function up()
    {

        $this->dropColumn('catalog_item','price');
        $this->addColumn('catalog_item','price',$this->float());

        $this->addColumn('catalog_item','price_st_st',$this->float());
        $this->addColumn('catalog_item','price_big_st',$this->float());
        $this->addColumn('catalog_item','price_st_big',$this->float());
        $this->addColumn('catalog_item','price_big_big',$this->float());

        $this->addColumn('catalog_item','ext_code_st_st',$this->float());
        $this->addColumn('catalog_item','ext_code_big_st',$this->float());
        $this->addColumn('catalog_item','ext_code_st_big',$this->float());
        $this->addColumn('catalog_item','ext_code_big_big',$this->float());



    }

    public function down()
    {
        echo "m161211_211528_catalog_item_refactor cannot be reverted.\n";

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

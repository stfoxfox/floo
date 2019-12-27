<?php

use yii\db\Migration;

class m161120_170308_catalog_categoty_table extends Migration
{
    public function up()
    {

        $this->createTable('catalog_category',
            array(
                'id'=>$this->primaryKey(),
                'title'=>$this->string(75),
                'sort'=>$this->integer()->defaultValue(0),
                'show_in_app'=>$this->boolean()->defaultValue(true),
                'created_at'=>$this->timestamp()->defaultExpression("now()"),
                'updated_at'=>$this->timestamp()->defaultExpression("now()")
            ));


    }

    public function down()
    {


        $this->dropTable('catalog_category');
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

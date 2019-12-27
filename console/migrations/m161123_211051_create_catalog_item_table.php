<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_item`.
 */
class m161123_211051_create_catalog_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('catalog_item', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'sort'=>$this->integer(),
            'file_name'=>$this->string(),
            'ext_code'=>$this->string(),
            'price'=>$this->string(),
            'category_id'=>$this->integer(),
            'active'=>$this->boolean(),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")

        ]);

        $this->createIndex('catalog_item-category_id-idx','catalog_item','category_id');
        $this->addForeignKey('catalog_item-category_id-fkey','catalog_item','category_id','catalog_category','id','SET NULL','CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('catalog_item');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_item_modificator`.
 */
class m161124_130248_create_catalog_item_modificator_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('catalog_item_modificator', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'price'=>$this->float()->notNull(),
            'icon'=>$this->string(),
            'ext_code'=>$this->string()->notNull(),
            'active'=>$this->boolean()->defaultValue(true),
            'sort'=>$this->integer()->defaultValue(0),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")

        ]);


        $this->createTable('catalog_item_modificator_link',array(
            'catalog_item_modificator_id'=>$this->integer()->notNull(),
            'catalog_item_id'=>$this->integer()->notNull(),
            'PRIMARY KEY(catalog_item_modificator_id, catalog_item_id)'

        ));

        $this->addForeignKey('catalog_item_modificator_link-catalog_item_modificator_id-fkey','catalog_item_modificator_link','catalog_item_modificator_id','catalog_item_modificator','id','CASCADE','CASCADE');
        $this->addForeignKey('catalog_item_modificator_link-catalog_item_id-fkey','catalog_item_modificator_link','catalog_item_id','catalog_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-catalog_item_modificator_link-catalog_item_modificator_id','catalog_item_modificator_link','catalog_item_modificator_id');
        $this->createIndex('idx-catalog_item_modificator_link-catalog_item_id', 'catalog_item_modificator_link', 'catalog_item_id');




    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('catalog_item_modificator_link');
        $this->dropTable('catalog_item_modificator');
    }
}

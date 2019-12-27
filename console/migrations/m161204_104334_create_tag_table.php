<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m161204_104334_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'tag'=>$this->string()->notNull(),
            'sort'=>$this->integer()->defaultValue(0),
            'created_at'=>$this->timestamp()->defaultValue('NOW()'),
            'updated_at'=>$this->timestamp()->defaultValue('NOW()'),
        ]);


        $this->createTable('catalog_item_tag_link',array(
            'tag_id'=>$this->integer()->notNull(),
            'catalog_item_id'=>$this->integer()->notNull(),
            'PRIMARY KEY(tag_id, catalog_item_id)'

        ));

        $this->addForeignKey('catalog_item_tag_link-tag_id-fkey','catalog_item_tag_link','tag_id','tag','id','CASCADE','CASCADE');
        $this->addForeignKey('catalog_item_tag_link-catalog_item_id-fkey','catalog_item_tag_link','catalog_item_id','catalog_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-catalog_item_tag_link-tag_id','catalog_item_tag_link','tag_id');
        $this->createIndex('idx-catalog_item_tag_link-catalog_item_id', 'catalog_item_tag_link', 'catalog_item_id');



        $this->createTable('restaurant_tag_link',array(
            'tag_id'=>$this->integer()->notNull(),
            'restaurant_id'=>$this->integer()->notNull(),
            'PRIMARY KEY(tag_id, restaurant_id)'

        ));

        $this->addForeignKey('restaurant_tag_link-tag_id-fkey','restaurant_tag_link','tag_id','tag','id','CASCADE','CASCADE');
        $this->addForeignKey('restaurant_tag_link-restaurant_id-fkey','restaurant_tag_link','restaurant_id','restaurant','id','CASCADE','CASCADE');
        $this->createIndex('idx-restaurant_tag_link-tag_id','restaurant_tag_link','tag_id');
        $this->createIndex('idx-restaurant_tag_link-restaurant_id', 'restaurant_tag_link', 'restaurant_id');

        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('catalog_item_tag_link');
        $this->dropTable('restaurant_tag_link');
        $this->dropTable('tag');
    }
}

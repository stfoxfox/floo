<?php

use yii\db\Migration;

/**
 * Handles the creation of table `promo`.
 */
class m161215_180913_create_promo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {


        $this->createTable('promo', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'description_short'=>$this->text(),
            'sort'=>$this->integer(),
            'for_all_restaurants'=>$this->boolean(),
            'active'=>$this->boolean()->defaultValue(true),
            'file_name'=>$this->string(),
            'created_at'=>$this->timestamp()->defaultValue('NOW()'),
            'updated_at'=>$this->timestamp()->defaultValue('NOW()'),
        ]);


        $this->createTable('catalog_item_promo_link',array(
            'promo_id'=>$this->integer()->notNull(),
            'catalog_item_id'=>$this->integer()->notNull(),
            'PRIMARY KEY(promo_id, catalog_item_id)'

        ));

        $this->addForeignKey('catalog_item_promo_link-promo_id-fkey','catalog_item_promo_link','promo_id','promo','id','CASCADE','CASCADE');
        $this->addForeignKey('catalog_item_promo_link-catalog_item_id-fkey','catalog_item_promo_link','catalog_item_id','catalog_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-catalog_item_promo_link-promo_id','catalog_item_promo_link','promo_id');
        $this->createIndex('idx-catalog_item_promo_link-catalog_item_id', 'catalog_item_promo_link', 'catalog_item_id');


        $this->createTable('restaurant_promo_link',array(
            'promo_id'=>$this->integer()->notNull(),
            'restaurant_id'=>$this->integer()->notNull(),
            'PRIMARY KEY(promo_id, restaurant_id)'

        ));

        $this->addForeignKey('restaurant_promo_link-promo_id-fkey','restaurant_promo_link','promo_id','promo','id','CASCADE','CASCADE');
        $this->addForeignKey('restaurant_promo_link-catalog_item_id-fkey','restaurant_promo_link','restaurant_id','restaurant','id','CASCADE','CASCADE');
        $this->createIndex('idx-restaurant_promo_link-promo_id','restaurant_promo_link','promo_id');
        $this->createIndex('idx-restaurant_promo_link-catalog_item_id', 'restaurant_promo_link', 'restaurant_id');

        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropTable('restaurant_promo_link');
        $this->dropTable('catalog_item_promo_link');
        $this->dropTable('promo');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m180412_080115_create_catalog_item_modificator_count_link
 */
class m180412_080115_create_catalog_item_modificator_count_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('catalog_item_modificator_count_link',array(
            'catalog_item_modificator_id' => $this->integer()->notNull(),
            'catalog_item_id' => $this->integer()->notNull(),
            'count' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("now()"),
            'updated_at' => $this->timestamp()->defaultExpression("now()"),
            'PRIMARY KEY(catalog_item_modificator_id, catalog_item_id)'

        ));

        $this->addForeignKey(
            'catalog_item_modificator_count_link-catalog_item_modificator_id-fkey',
            'catalog_item_modificator_count_link',
            'catalog_item_modificator_id',
            'catalog_item_modificator',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'catalog_item_modificator_count_link-catalog_item_id-fkey',
            'catalog_item_modificator_link',
            'catalog_item_id',
            'catalog_item',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->createIndex(
            'catalog_item_modificator_count_link-catalog_item_modificator_id-idx',
            'catalog_item_modificator_count_link',
            'catalog_item_modificator_id'
        );

        $this->createIndex(
            'catalog_item_modificator_count_link-catalog_item_id-idx', 
            'catalog_item_modificator_count_link', 
            'catalog_item_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('catalog_item_modificator_count_link-catalog_item_modificator_id-fkey','catalog_item_modificator_count_link');
        $this->dropForeignKey('catalog_item_modificator_count_link-catalog_item_id-fkey','catalog_item_modificator_count_link');
        $this->dropTable('catalog_item_modificator_count_link');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `stop_list_element`.
 */
class m170110_102857_create_stop_list_element_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('stop_list_element', [
            'restaurant_id'=>$this->integer()->notNull(),
            'catalog_item_id'=>$this->integer()->notNull(),
            'catalog_item_pizza_options'=>$this->integer()->defaultValue(0),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()"),
            'PRIMARY KEY(restaurant_id, catalog_item_id,catalog_item_pizza_options)'
        ]);

        $this->addForeignKey('stop_list_element-restaurant_id-fkey','stop_list_element','restaurant_id','restaurant','id','CASCADE','CASCADE');
        $this->addForeignKey('stop_list_element-catalog_item_id-fkey','stop_list_element','catalog_item_id','catalog_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-stop_list_element-restaurant_id','stop_list_element','restaurant_id');
        $this->createIndex('idx-stop_list_element-catalog_item_id', 'stop_list_element', 'catalog_item_id');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('stop_list_element');
    }
}

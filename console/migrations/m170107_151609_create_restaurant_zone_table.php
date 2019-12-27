<?php

use yii\db\Migration;

/**
 * Handles the creation of table `restaurant_zone`.
 */
class m170107_151609_create_restaurant_zone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('restaurant_zone', [
            'id' => $this->primaryKey(),
            'restaurant_id'=>$this->integer(),
            'zone'=>'GEOMETRY(POLYGON, 4326)',
            'min_order'=>$this->string(),
            'min_time'=>$this->string(),
            'max_time'=>$this->string(),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ]);


        $this->createIndex('restaurant_zone-restaurant_id-idx','restaurant_zone','restaurant_id');
        $this->addForeignKey('restaurant_zone-restaurant_id-fkey','restaurant_zone','restaurant_id','restaurant','id');


        $this->addColumn('restaurant','external_id',$this->integer());
        $this->createIndex('restaurant-external_id-idx','restaurant','external_id');


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('restaurant_zone');
    }
}

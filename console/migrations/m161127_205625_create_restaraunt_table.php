<?php

use yii\db\Migration;

/**
 * Handles the creation of table `restaraunt`.
 */
class m161127_205625_create_restaraunt_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('region',[
            'id'=>$this->primaryKey(),
            'title'=>$this->string(),
            'sort'=>$this->integer()->defaultValue(0),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ]);

        $this->createTable('restaurant', [
            'id' => $this->primaryKey(),
            'address'=>$this->string()->notNull(),
            'region_id'=>$this->integer(),
            'phone'=>$this->string(),
            'lat'=>'double  NOt NULL',
            'lng'=>'double  NOt NULL',
            'metro'=>$this->text(),
            'sort'=>$this->integer()->defaultValue(0),
            'is_active'=>$this->boolean()->defaultValue(false),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()"),

        ]);


        $this->addForeignKey('restaurant-region_id-fkey','restaurant','region_id','region','id','SET NULL','CASCADE');


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('restaurant');
        $this->dropTable('region');
    }
}

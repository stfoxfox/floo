<?php

use yii\db\Migration;

class m170112_132219_create_order_teble extends Migration
{
    public function safeUp()
    {



        $this->createTable('order',
            [
                'id'=>$this->primaryKey(),
                'user_id'=>$this->integer()->notNull(),
                'address_id'=>$this->integer(),
                'gift_id'=>$this->integer(),
                'order_source'=>$this->smallInteger(),
                'address'=>$this->string()->notNull(),
                'entrance'=>$this->string(),
                'floor'=>$this->string(),
                'flat'=>$this->string(),
                'lat'=>'double  NOT NULL',
                'lng'=>'double  NOT NULL',
                'points_number'=>$this->integer(),
                'discount'=>$this->integer(),
                'status'=>$this->integer(),
                'payment_id'=>$this->string(),
                'payment_type'=>$this->smallInteger(),
                'phone'=>$this->string(),
                'client_comment'=>$this->text(),
                'operator_comment'=>$this->text(),
                'change_sum'=>$this->string(),
                'payment_summ'=>$this->float(),
                'order_summ'=>$this->float(),
                'restaurant_id'=>$this->integer(),
                'created_at'=>$this->timestamp()->defaultExpression('NOW()'),
                'updated_at'=>$this->timestamp()->defaultExpression('NOW()'),

            ]
        );

        $this->addForeignKey('order-user_id-fkey','order','user_id','user','id','CASCADE','CASCADE');
        $this->createIndex('order-user_id-idx','order','user_id');


        $this->addForeignKey('order-address_id-fkey','order','address_id','address','id','SET NULL','CASCADE');
        $this->createIndex('order-address_id-idx','order','address_id');

        $this->addForeignKey('order-restaurant_id-fkey','order','restaurant_id','restaurant','id','SET NULL','CASCADE');
        $this->createIndex('order-restaurant_id-idx','order','restaurant_id');

        $this->addForeignKey('order-gift_id-fkey','order','gift_id','catalog_item','id','SET NULL','CASCADE');



        $this->createTable('cart',[
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer(),
            'order_id'=>$this->integer(),
            'order_summ'=>$this->float(),
            'created_at'=>$this->timestamp()->defaultExpression('NOW()'),
            'updated_at'=>$this->timestamp()->defaultExpression('NOW()'),

        ]);

        $this->addForeignKey('cart-user_id-fkey','cart','user_id','user','id','CASCADE','CASCADE');
        $this->createIndex('cart-user_id-idx','cart','user_id');


        $this->addForeignKey('cart-order_id-fkey','cart','order_id','order','id','CASCADE','CASCADE');
        $this->createIndex('cart-order_id-idx','cart','order_id');


        $this->createTable('cart_item',[
            'id'=>$this->primaryKey(),
            'cart_id'=>$this->integer(),
            'catalog_item_id'=>$this->integer(),
            'catalog_item_pizza_options'=>$this->smallInteger(),
            'count'=>$this->integer(),
            'created_at'=>$this->timestamp()->defaultExpression('NOW()'),
            'updated_at'=>$this->timestamp()->defaultExpression('NOW()'),
            
        ]);

        $this->addForeignKey('cart_item-catalog_item_id-fkey','cart_item','catalog_item_id','catalog_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-cart_item-catalog_item_id', 'cart_item', 'catalog_item_id');
        $this->createIndex('idx-cart_item-cart_id', 'cart_item', 'cart_id');
        $this->addForeignKey('cart_item-cart_id-fkey','cart_item','cart_id','cart','id','CASCADE','CASCADE');



        $this->createTable('cart_item_modificator',
            [
                'cart_item_id'=>$this->integer(),
                'modificator_id'=>$this->integer(),
                'count'=>$this->integer(),
                
            ]
        );


        $this->addForeignKey('cart_item_modificator-modificator_id-fkey','cart_item_modificator','modificator_id','catalog_item_modificator','id','CASCADE','CASCADE');
        $this->addForeignKey('cart_item_modificator-catalog_item_id-fkey','cart_item_modificator','cart_item_id','cart_item','id','CASCADE','CASCADE');
        $this->createIndex('idx-cart_item_modificator-catalog_item_id', 'cart_item_modificator', 'cart_item_id');

        $this->createIndex('idx-cart_item_modificator-modificator_id','cart_item_modificator','modificator_id');

    }

    public function down()
    {
        echo "m170112_132219_create_order_teble cannot be reverted.\n";

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

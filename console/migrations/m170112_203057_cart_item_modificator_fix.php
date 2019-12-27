<?php

use yii\db\Migration;

class m170112_203057_cart_item_modificator_fix extends Migration
{
    public function up()
    {

       $this->addColumn( 'cart_item_modificator','created_at',$this->timestamp()->defaultExpression('NOW()'));
        $this->addColumn( 'cart_item_modificator',  'updated_at',$this->timestamp()->defaultExpression('NOW()'));
    }

    public function down()
    {
        echo "m170112_203057_cart_item_modificator_fix cannot be reverted.\n";

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

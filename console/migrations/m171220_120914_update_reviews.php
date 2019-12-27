<?php

use yii\db\Migration;

/**
 * Class m171220_120914_update_reviews
 */
class m171220_120914_update_reviews extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('review','restaurant_id',$this->integer());
        $this->createIndex('review-restaurant_id-idx','review','restaurant_id');
        $this->addForeignKey('review-restaurant_id-fkey','review','restaurant_id','restaurant','id','CASCADE','CASCADE');
    }

    public function down()
    {
        // $this->dropForeignKey('review', 'review-restaurant_id-fkey');
        $this->dropColumn('review','restaurant_id');
    }
}

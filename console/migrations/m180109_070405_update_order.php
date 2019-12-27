<?php

use yii\db\Migration;

/**
 * Class m180109_070405_update_order
 */
class m180109_070405_update_order extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('order', 'gift_card_text', $this->text());
    }

    public function down()
    {
        $this->dropColumn('order', 'gift_card_text');
    }
}

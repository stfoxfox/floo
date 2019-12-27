<?php

use yii\db\Migration;

/**
 * Class m180418_082506_update_order
 */
class m180418_082506_update_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'is_get_point', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'is_get_point');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180418_082506_update_order cannot be reverted.\n";

        return false;
    }
    */
}

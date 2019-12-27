<?php

use yii\db\Migration;

/**
 * Class m180618_082951_update_catalog_item_modificator
 */
class m180618_082951_update_catalog_item_modificator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('catalog_item_modificator', 'active');
        $this->addColumn('catalog_item_modificator', 'active', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180618_082951_update_catalog_item_modificator cannot be reverted.\n";

        return false;
    }
    */
}

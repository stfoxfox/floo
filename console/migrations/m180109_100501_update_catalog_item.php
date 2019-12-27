<?php

use yii\db\Migration;

/**
 * Class m180109_100501_update_catalog_item
 */
class m180109_100501_update_catalog_item extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('catalog_item', 'in_basket_page', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('catalog_item', 'in_basket_page');
    }
}

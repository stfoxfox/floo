<?php

use yii\db\Migration;

/**
 * Class m180108_134622_update_catalog_item
 */
class m180108_134622_update_catalog_item extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('catalog_item', 'is_main_page', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('catalog_item', 'is_main_page');
    }
}

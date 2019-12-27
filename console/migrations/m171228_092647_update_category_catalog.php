<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m171228_092647_update_category_catalog
 */
class m171228_092647_update_category_catalog extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('catalog_category', 'is_active', $this->boolean()->defaultValue(false));
        $this->addColumn('catalog_category', 'is_main_page', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('catalog_category', 'is_active');
        $this->dropColumn('catalog_category', 'is_main_page');
    }
}

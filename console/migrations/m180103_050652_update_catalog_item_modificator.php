<?php

use yii\db\Migration;

/**
 * Class m180103_050652_update_catalog_item_modificator
 */
class m180103_050652_update_catalog_item_modificator extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('catalog_item_modificator', 'description', $this->text());
        $this->addColumn('catalog_item_modificator', 'photo', $this->string());
    }

    public function down()
    {
        $this->dropColumn('catalog_item_modificator', 'description');
        $this->dropColumn('catalog_item_modificator', 'photo');
    }
}
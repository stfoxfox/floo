<?php

use yii\db\Migration;

/**
 * Class m180123_114337_update_catalog_item_modificator
 */
class m180123_114337_update_catalog_item_modificator extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('catalog_item_modificator', 'video_link', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('catalog_item_modificator', 'video_link');
    }
}

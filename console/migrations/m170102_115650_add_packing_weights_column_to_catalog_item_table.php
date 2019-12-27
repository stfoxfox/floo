<?php

use yii\db\Migration;

/**
 * Handles adding packing_weights to table `catalog_item`.
 */
class m170102_115650_add_packing_weights_column_to_catalog_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->addColumn('catalog_item','packing_weights',$this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}

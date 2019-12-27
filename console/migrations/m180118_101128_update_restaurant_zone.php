<?php

use yii\db\Migration;

/**
 * Class m180118_101128_update_restaurant_zone
 */
class m180118_101128_update_restaurant_zone extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('restaurant_zone', 'zone');
        $this->addColumn('restaurant_zone', 'zone', 'GEOMETRY(POLYGON, 4326)');
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180118_101128_update_restaurant_zone cannot be reverted.\n";

        return false;
    }


}

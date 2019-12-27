<?php

use yii\db\Migration;

/**
 * Class m171225_170532_update_restaurant_zone
 */
class m171225_170532_update_restaurant_zone extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->db->createCommand('
            ALTER TABLE restaurant_zone  
            ALTER COLUMN zone TYPE geometry(MultiPolygonZ, 4326) 
            USING ST_Force_3D(zone);')
            ->execute();
    }

    public function down()
    {
        echo "m171225_170532_update_restaurant_zone cannot be reverted.\n";

      
    }
}

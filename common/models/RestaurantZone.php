<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/01/2017
 * Time: 17:27
 */

namespace common\models;


use common\models\BaseModels\RestaurantZoneBase;

class RestaurantZone extends RestaurantZoneBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

}
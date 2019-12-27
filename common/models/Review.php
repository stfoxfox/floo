<?php


namespace common\models;


use common\models\BaseModels\ReviewBase;
use yii\helpers\ArrayHelper;

class Review extends ReviewBase
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

}
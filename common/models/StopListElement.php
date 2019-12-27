<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 10/01/2017
 * Time: 13:43
 */

namespace common\models;


use common\models\BaseModels\StopListElementBase;

class StopListElement extends StopListElementBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItem()
    {
        return $this->hasOne(CatalogItem::className(), ['id' => 'catalog_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }


    public function getJson(){

        return array(
            'catalog_item_id'=>$this->catalog_item_id,
            'pizza_options'=>$this->catalog_item_pizza_options,
        );

    }
}
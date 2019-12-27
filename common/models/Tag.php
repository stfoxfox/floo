<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 13:54
 */

namespace common\models;


use common\models\BaseModels\TagBase;
use yii\helpers\ArrayHelper;

class Tag extends TagBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItems()
    {
        return $this->hasMany(CatalogItem::className(), ['id' => 'catalog_item_id'])->viaTable('catalog_item_tag_link', ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['id' => 'restaurant_id'])->viaTable('restaurant_tag_link', ['tag_id' => 'id']);
    }


    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'tag');
    }


    public function  getJson(){

        return array(
            'id'=>$this->id,
            'title'=>$this->tag,
        );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 15/12/2016
 * Time: 23:22
 */

namespace common\models;


use common\components\MyExtensions\MyImagePublisher;
use common\models\BaseModels\PromoBase;

class Promo extends PromoBase
{

    const ACTION_TYPE_NONE=0;
    const ACTION_TYPE_DISCOUNT=1;
    const ACTION_TYPE_GIFT=2;


    public function uploadTo($attribute){

        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/promo/{$this->$attribute}";
        else
            return null;


    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItems()
    {
        return $this->hasMany(CatalogItem::className(), ['id' => 'catalog_item_id'])->viaTable('catalog_item_promo_link', ['promo_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['id' => 'restaurant_id'])->viaTable('restaurant_promo_link', ['promo_id' => 'id']);
    }



    public function  getListJson(){


        $returnObj = array(
            'id'=>$this->id,
            'image_url'=>(new MyImagePublisher($this))->MyThumbnail(512,ceil(512/2.27)),
        );


        return $returnObj;

    }


    public  function getFullJson(){

        $returnObj = array(
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'image_url'=>(new MyImagePublisher($this))->MyThumbnail(512,ceil(512/2.27)),
        );


        if ($this->for_all_restaurants){

            $restaurants = Restaurant::find()->orderBy('sort')->all();


        }else{

            $restaurants = $this->restaurants;
        }

        $restaurants_item = array();
        /**
         * @var  Restaurant $restaurant
         */
        foreach($restaurants as $restaurant){

            $restaurants_item[] = $restaurant->getJson();

        }


            $returnObj['restaurants']=$restaurants_item;



        return $returnObj;

    }

}
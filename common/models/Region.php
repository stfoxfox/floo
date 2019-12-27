<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 28/11/2016
 * Time: 21:06
 */

namespace common\models;


use common\models\BaseModels\RegionBase;
use yii\helpers\ArrayHelper;

class Region extends RegionBase
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['region_id' => 'id']);
    }



    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }


    public function getJson(){

        return array(
            'id'=>$this->id,
            'title'=>$this->title,
        );
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12/01/2017
 * Time: 23:35
 */

namespace common\models;


use common\models\BaseModels\CartItemModificatorBase;
use yii\helpers\ArrayHelper;

class CartItemModificator extends CartItemModificatorBase
{



    /**
     * @param $modificatorXml
     * @return CartItemModificator
     */
    public static function getFromDCXml($modificatorXml)
    {

        $item_id= $modificatorXml['id'];


        $count =1;//ArrayHelper::getValue($modificatorXml,'quantity',1);

        $item = new CartItemModificator();

        $item->count=$count;
        $item->modificator_id=$item_id;

        return $item;


    }



    /**
     * @param $modificatorJson
     * @return CartItemModificator
     */
    public static function getFromArray($modificatorJson)
    {

        $item_id = ArrayHelper::getValue($modificatorJson,'item_id');
        $count = ArrayHelper::getValue($modificatorJson,'count');


        $item = new CartItemModificator();

        $item->count=$count;
        $item->modificator_id=$item_id;

        return $item;


    }

    public function getJson(){

        return array(
            'count'=>$this->count,
            'item'=>$this->modificator->getJson(),
        );
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItem()
    {
        return $this->hasOne(CartItem::className(), ['id' => 'cart_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModificator()
    {
        return $this->hasOne(CatalogItemModificator::className(), ['id' => 'modificator_id']);
    }

}
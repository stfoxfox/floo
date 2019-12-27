<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12/01/2017
 * Time: 23:35
 */

namespace common\models;


use common\models\BaseModels\CartItemBase;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cart_item".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $catalog_item_id
 * @property integer $catalog_item_pizza_options
 * @property integer $count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CatalogItem $catalogItem
 */
class CartItem extends CartItemBase
{




    public function getModificatorsList(){


        $modificatorsArray = array();
        /**
         *
         * @var CartItemModificator $modificator
         */
        foreach ($this->cartItemModificators as $modificator){

            $modificatorsArray[]= $modificator->modificator->title. "(x" .$modificator->count.")";
        }

        return implode(", ",$modificatorsArray);

    }


    public function getItemTitle(){
        $itemTitle = $this->catalogItem->title;

        switch ($this->catalog_item_pizza_options){

            case CatalogItem::PIZZA_OPTIONS_NONE:
                break;
            case CatalogItem::PIZZA_OPTIONS_st_st:
                $itemTitle = "". $this->catalogItem->title;
                break;
            case CatalogItem::PIZZA_OPTIONS_big_st:
                $itemTitle = "". $this->catalogItem->title;
                break;
        }

        return $itemTitle;


    }
    /**
     * @var CartItemModificator[] $tempModificatorsArray
     */
    public $tempModificatorsArray= array();


    public function getTempSumm(){


        $sum=0;

        if ($this->tempModificatorsArray){
            /**
             * @var CartItemModificator $itemModificator
             */
            foreach ($this->tempModificatorsArray as $itemModificator){

                $sum+=($itemModificator->count*$itemModificator->modificator->price);
            }

        }

        $sum+=$this->catalogItem->price;

        $sum+=($sum*$this->count);
        return $sum;


    }

    public static function getFromDCXml($cartJson){




        $item = new CartItem();
        $item->catalog_item_id= $cartJson['id'];
        $item->count = $cartJson['quantity'];
        $item->catalog_item_pizza_options =CatalogItem::PIZZA_OPTIONS_NONE;

        if (isset($cartJson->filler)) {

            foreach($cartJson->filler as $filler) {


                if ( $filler['id']==1){
                    $item->catalog_item_pizza_options =CatalogItem::PIZZA_OPTIONS_st_st;

                }


                if ( $filler['id']==2){
                    $item->catalog_item_pizza_options =CatalogItem::PIZZA_OPTIONS_big_st;

                }

            }
        }



        if (isset($cartJson->ingredient)) {
            foreach($cartJson->ingredient as $menuAdditive) {



                $tempModificator = CartItemModificator:: getFromDCXml($menuAdditive);

                 if ($tempModificator->count>0)
                    $item->tempModificatorsArray[]= $tempModificator;

            }
        }





        return $item;

    }

    public static function getFromArray($cartJson){

        $item = new CartItem();

        $catalog_item_id = ArrayHelper::getValue($cartJson,'catalog_item_id');
        $count = ArrayHelper::getValue($cartJson,'count');
        $modificators =  ArrayHelper::getValue($cartJson,'modificators',array());
        $pizza_options =  ArrayHelper::getValue($cartJson,'pizza_options',array());


        $item->catalog_item_id= $catalog_item_id;
        $item->count= $count;
        $item->catalog_item_pizza_options=$pizza_options;

        foreach ($modificators as $modificator){

            $tempModificator = CartItemModificator:: getFromArray($modificator);

            if ($tempModificator->count>0)
           $item->tempModificatorsArray[]= $tempModificator;
        }


        return $item;

    }

    public function getPrice(){

        $sum=0;

        if ($this->cartItemModificators){
            /**
             * @var CartItemModificator $itemModificator
             */
            foreach ($this->cartItemModificators as $itemModificator){

                $sum+=($itemModificator->count*$itemModificator->modificator->price);
            }

        }

        $price = $this->catalogItem->price;

        switch ($this->catalog_item_pizza_options){
            case CatalogItem::PIZZA_OPTIONS_NONE:
                break;
            case CatalogItem::PIZZA_OPTIONS_st_st:
                $price = $this->catalogItem->price_st_st;
                break;
            case CatalogItem::PIZZA_OPTIONS_big_st:
                $price = $this->catalogItem->price_big_st;
                break;
            case CatalogItem::PIZZA_OPTIONS_st_big:
                $price = $this->catalogItem->price_st_big;
                break;

            case CatalogItem::PIZZA_OPTIONS_big_big:
                $price = $this->catalogItem->price_big_big;
                break;

        }

        $sum+=$price;

       // $sum=($sum*$this->count);
        return $sum;
    }

    public function getSum(){

        $sum=0;

        if ($this->cartItemModificators){
            /**
             * @var CartItemModificator $itemModificator
             */
            foreach ($this->cartItemModificators as $itemModificator){

                $sum+=($itemModificator->count*$itemModificator->modificator->price);
            }

        }

        $price = $this->catalogItem->price;

        switch ($this->catalog_item_pizza_options){
            case CatalogItem::PIZZA_OPTIONS_NONE:
                break;
            case CatalogItem::PIZZA_OPTIONS_st_st:
                $price = $this->catalogItem->price_st_st;
                break;
            case CatalogItem::PIZZA_OPTIONS_big_st:
                $price = $this->catalogItem->price_big_st;
                break;
            case CatalogItem::PIZZA_OPTIONS_st_big:
                $price = $this->catalogItem->price_st_big;
                break;

            case CatalogItem::PIZZA_OPTIONS_big_big:
                $price = $this->catalogItem->price_big_big;
                break;

        }

        $sum+=$price;

        $sum=($sum*$this->count);
        return $sum;
    }


    public function getJson(){


        $returnArray =array();

        $returnArray['item']=$this->catalogItem->getJson();
        $returnArray['count']=$this->count;
        $returnArray['pizza_options_int']=$this->catalog_item_pizza_options;
        $modificators_array = array();
        foreach ($this->cartItemModificators as $modificator){
            $modificators_array[]= $modificator->getJson();

        }

        $returnArray['modificators']=$modificators_array;

        return $returnArray;

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

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
    public function getCartItemModificators()
    {
        return $this->hasMany(CartItemModificator::className(), ['cart_item_id' => 'id']);
    }
}
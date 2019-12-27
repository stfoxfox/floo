<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/04/2017
 * Time: 12:47
 */

namespace common\models;


use yii\helpers\ArrayHelper;

class CartItemJson
{


    public  $catalog_item_id;
    public  $price = 0 ;
    public  $modificators=array() ;
    public  $pizza_options=0;
    public  $count=0;


    public  function getSum(){

        $sum =  $this->price;

        foreach ($this->modificators as $mItem){

            $sum+=$mItem->getSum();

        }

        $sum = $sum*$this->count;

        return $sum;

    }
    public function getFromJson(Array $json,&$modificators){


        $this->catalog_item_id = ArrayHelper::getValue($json,'catalog_item_id',0);
        $this->count = ArrayHelper::getValue($json,'count',0);
        $this->pizza_options=ArrayHelper::getValue($json,'pizza_options',0);



        $mArray = ArrayHelper::getValue($json,'modificators',array());


        foreach ($mArray as $mJson){


            $mItem = new ModificatorJson();
            $mItem->loadFromJson($mJson);

            $modificators[]=$mItem->item_id;
            $this->modificators[]=$mItem;
        }
    }

    /**
     * @param CatalogItem[] $items
     * @param CatalogItemModificator[] $modificators
     */
    public function loadWithData($items,$modificators){


        foreach ($items as $item){

            if ($item->id == $this->catalog_item_id){

                switch ($this->pizza_options){
                    case CatalogItem::PIZZA_OPTIONS_NONE:{
                        $this->price = $item->price;
                    }
                    break;
                    case CatalogItem::PIZZA_OPTIONS_st_st:{
                       $this->price = $item->price_st_st;
                    }
                    break;
                    case CatalogItem::PIZZA_OPTIONS_big_st:
                    {
                        $this->price=$item->price_big_st;
                    }
                    break;
                    case CatalogItem::PIZZA_OPTIONS_st_big:
                    {
                        $this->price=$item->price_st_big;
                    }
                    break;
                    case  CatalogItem::PIZZA_OPTIONS_big_big:
                    {

                        $this->price=$item->price_big_big;
                    }
                    break;

                }

                break;

            }


            if (count($this->modificators)>0){


                /**
                 * @var  ModificatorJson $iModificator
                 */
                foreach ($this->modificators as $iModificator){
                     foreach ($modificators as $modificator){
                    if ($modificator->id == $iModificator->item_id){
                        $iModificator->price=$modificator->price;
                        break;

                    }

                     }

                }
            }
        }


    }

}
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12/01/2017
 * Time: 23:33
 */

namespace common\models;


use common\components\MyExtensions\MyHelper;
use common\models\BaseModels\OrderBase;
use common\models\User;

class Order extends OrderBase
{

    const STATUS_NEW=0;
    const STATUS_IN_PROGRESS=10;
    const STATUS_IN_DELIVERY=20;
    const STATUS_DELIVERED=30;
    const STATUS_CANCELED=5;


    const PAYMENT_TYPE_CASH=1;
    const PAYMENT_TYPE_CARD=2;
    const PAYMENT_TYPE_PLATRON=3;

    const TYPE_SITE = 0;
    const TYPE_APP = 1;
    const TYPE_DC = 2;
    const TYPE_DC_APP = 3;


    const PAYMENT_STATUS_DEFAULT = 0; // дефолтный
    const PAYMENT_STATUS_WAIT = 1; // дефолтный
    const PAYMENT_STATUS_PAID = 2; // оплачено
    const PAYMENT_STATUS_BAD = 3; // не оплачено

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(CatalogItem::className(), ['id' => 'gift_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getListJson(){

        $time = strtotime($this->created_at);

        $strTime =date("j F Y  H:m",$time);
        $returnArray = array(
            'id'=>$this->id,
            'order_sum'=>$this->order_summ ,
            'order_date'=>$strTime,
            'order_status'=>$this->status,
        );
        if (!$this->status){
            $returnArray['order_status']=Order::STATUS_NEW;
        }

        return $returnArray;
    }


    public function getStatusClass($status){



        if ($status == $this->status) {


            switch ($this->status) {

                case self::STATUS_NEW: {
                    return 'btn-danger';

                }
                case self::STATUS_IN_PROGRESS: {
                    return 'btn-warning';

                }
                case self::STATUS_IN_DELIVERY: {
                    return 'btn-info';

                }

                case self::STATUS_DELIVERED: {
                    return 'btn-primary';

                }

                case self::STATUS_CANCELED: {
                    return 'btn-default';

                }


            }

        }else {

            return "btn-white";
        }

    }

    public function getStatus(){
        switch ($this->status){

            case self::STATUS_NEW:{
                return '<span class="label label-danger">Новый</span>';

            }
            case self::STATUS_IN_PROGRESS: {
               return '<span class="label label-warning">В работе </span>';

            }
            case self::STATUS_IN_DELIVERY: {
               return '<span class="label label-info">На доствке </span>';

            }

            case self::STATUS_DELIVERED: {
               return '<span class="label label-primary">Завершен</span>';

            }

            case self::STATUS_CANCELED: {
               return '<span class="label">Отменен</span>';

            }



        }


    }
    public function getAddressForBackend(){

        $addressData = array(


            "Адрес: ".$this->address.", Подьезд: ".$this->entrance.", Этаж: ".$this->floor.",Квартира: ".$this->flat,
        );


        if($this->restaurant){

            $addressData[]= "Ресторан: ".$this->restaurant->address;
        }
        return implode("<br>",$addressData);

    }

    public function getClientForBackend(){

        /**
         * @var User $user
         */
        $user = $this->user;
        $clientData = array(

            "Телефон: 8".$this->user->username
        );

        if ($user->name){

            $clientData[]="Имя: ".$user->name;
        }

        if ($this->phone != $this->user->username){

            $clientData[]= "Телефон в заказе 8".$this->phone;

        }

        return implode("<br>",$clientData);

    }

    public function getJson(){


        $time = strtotime($this->created_at);

        $strTime =date("j F Y",$time);


        $returnArray = array(
            'id'=>$this->id,
            'order_summ'=>$this->order_summ,
            'order_date'=>$strTime,
            'order_status'=>$this->status,
        );

        /**
         * @var Cart $cart
         * @var CartItem  $cartItem
         */
        $cart = $this->getCarts()->one();


        $cartArray =array();
        foreach ($cart->cartItems as $cartItem){

            $cartArray[]= $cartItem->getJson();

        }


        $returnArray['cart']=$cartArray;

        return $returnArray;
    }

    public function updateSum(){

        $sum= 0;
        $cart=$this->carts[0];
        /**
         * @var CartItem $cartItem
         */
        foreach ($cart->cartItems as $cartItem){
            //\Yii::warning($cartItem->getSum());
            $sum+=  $cartItem->getSum();
        }


        /**
         * @var Promo $promo
         */

        $payment_summ = $sum;


        if ($this->promo_id && $promo = Promo::findOne($this->promo_id) ){

            if ($promo->action_type ==Promo::ACTION_TYPE_DISCOUNT){

                $payment_summ = ceil($payment_summ*(100 -$promo->discount)/100);

            }



        }


        if ($this->user->balance>=$this->points_number ){

            $payment_summ = $payment_summ - $this->points_number;
        }




        $this->payment_summ = $payment_summ;
        $this->order_summ=$sum;
        $this->save();
    }


    public function generateXML($skip_check=false){



/*
        if ($this->payment_type==Order::PAYMENT_TYPE_CASH || $skip_check) {



            if ($this->points_number>0){


               $user= $this->user;

                $user->updateCounters(['balance'=>-1*$this->points_number]);

            }

            MyHelper::generateXml('orders', 'ORDER', $this->orderToArray());

        }
*/
    }


    private function orderToArray(){
        $items =array();
        /**
         * @var Cart $cart
         * @var CartItem $cartItem
         */
        $cart = $this->carts[0];

        foreach ($cart->cartItems as $cartItem){

            $externalId = $cartItem->catalogItem->ext_code;
            $price  = $cartItem->catalogItem->price;

            switch ($cartItem->catalog_item_pizza_options){

                case  CatalogItem::PIZZA_OPTIONS_NONE;
                    break;
                case CatalogItem::PIZZA_OPTIONS_st_st;
                {
                    $externalId = $cartItem->catalogItem->ext_code_st_st;
                    $price  = $cartItem->catalogItem->price_st_st;
                }
                break;
                case CatalogItem::PIZZA_OPTIONS_big_st;
                {
                    $externalId = $cartItem->catalogItem->ext_code_big_st;
                    $price  = $cartItem->catalogItem->price_big_st;
                }
                break;
                case CatalogItem::PIZZA_OPTIONS_st_big;
                {
                    $externalId = $cartItem->catalogItem->ext_code_st_big;
                    $price  = $cartItem->catalogItem->price_st_big;
                }
                break;
                case CatalogItem::PIZZA_OPTIONS_big_big;
                {
                    $externalId = $cartItem->catalogItem->ext_code_big_big;
                    $price  = $cartItem->catalogItem->price_big_big;
                }
                break;
            }

            $items[] = array(
                'product_id' => $externalId,
                'product_parent_id' => null, // ID "базового" товара (если данный товар является модификатором к другому товару)
                'price' => $price,
                'quantity' => $cartItem->count,
                'name' => str_replace('&', '&amp;', $cartItem->catalogItem->title),
            );

            /**
             * @var CartItemModificator $modificator
             */
            foreach ($cartItem->cartItemModificators as $modificator){
                $items[] = array(
                    'product_id' => $modificator->modificator->ext_code,
                    'product_parent_id' => $externalId,
                    'product_price' => $modificator->modificator->price,
                    'quantity' => $modificator->count,
                    'name' =>str_replace('&', '&amp;', $modificator->modificator->title),
                );
            }
        }

        if ($this->gift_id){

            $items[] = array(
                'product_id' => $this->gift->ext_code,
                'product_parent_id' => null,
                'product_price' => 0,
                'quantity' => 1,
                'name' => str_replace('&', '&amp;', $this->gift->title),
            );

        }


        $orderPayment =

        array(
            'payment_id' => $this->payment_type,
         //   'payment_title' => $orderPayment->title,
            'payment_status' => $this->payment_status,
            'payment_sum' => $this->payment_summ,
            'order_sum' => $this->order_summ,
            'change_sum' => $this->change_sum,);



     //   if ($this->user->balance>$this->points_number){

            $orderPayment['bonus_payment']=$this->points_number;
       // }

        $clientStatus = 0;
        if ($this->user->status == User::STATUS_ACTIVE){
            $clientStatus =1;
        }
        $order = array(
            'attributes' => array(
                'id' => "N".$this->id,
                'source' => $this->order_source,
            ),
            'order' => array(
                'client_data_confirmed'=>$clientStatus,
                'client_id' => $this->user_id,
                'client_guid'=>$this->user->ext_uuid,
                'client_full_name' => $this->user->name,
                'client_address' => array(
                    'city' => $this->address,
                    'room' => $this->flat,
                    'floor' => $this->floor,
                    'map_latitude' => $this->lat,
                    'map_longitude' => $this->lng,
                ),
                'delivery_at' => empty($this->delivery_at) ? null : date('d.m.Y H:i:s', strtotime($this->delivery_at)),
                'client_comment' => $this->client_comment,
               // 'operator_comment' => $model->operator_comment,
                'sum' => $this->order_summ,
                'restaurant_id' => $this->restaurant->external_id,
               // 'promo' => $model->promo,
            ),
            'payment' => $orderPayment,

            'links' => array(
                'approve' => $this->dc_link_approve,
                'cancel' => $this->dc_link_cancel,
            ),
            'items' => $items,
        );

        if ($this->name != $this->user->name) {
            $order['order']['other_name'] = $this->name;
        }

        if ($this->phone != $this->user->username){

            $order['order']['other_phone'] = "8".$this->phone;
            $order['order']['phone'] = "8".$this->user->username;

        }
        else{
            $order['order']['phone'] = "8".$this->user->username;

        }
        return $order;

    }
}
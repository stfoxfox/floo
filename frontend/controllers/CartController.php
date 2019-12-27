<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Cart;
use common\models\CartItem;
use common\models\Restaurant;
use common\models\RestaurantZone;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\models\forms\CartForm;
use frontend\models\forms\CartItemFrom;
use frontend\models\forms\CartModificationFrom;
use yii\web\NotFoundHttpException;

class CartController extends FrontendController
{




    public function actionCheckZone(){


        $lat  = \Yii::$app->request->post('lat');
        $lng = \Yii::$app->request->post('lng');

        $returnObj = array();
        $found=false;
        $message ="";

        $session = Yii::$app->session;

         $session->set('restaurant_id',null);


        if ($lat && $lng){

            $zone  = RestaurantZone::find()->where(["ST_Contains(restaurant_zone.zone,ST_GeomFromText('POINT({$lng}  {$lat} )',4326))"=>true])->all();


            if (count($zone)==0){
                $found = false;
                $message="К сожалению, ваш адрес не входит в зону доставки наших ресторанов";

            }
            else{

                $found = true;

                /**
                 * @var RestaurantZone $found_zone
                 * @var  Restaurant $restaurant
                 */
                $found_zone = $zone[0];

                $restaurant = $found_zone->restaurant;

                $hours_info = $restaurant->getHoursInfo();

                if (!$hours_info['is_open']){

                    $returnObj['found']=false;
                    $returnObj['message']="К сожалению, доставка не работает ";
                    $returnObj['hours_info']=$hours_info;

                    return $this->sendJSONResponse($returnObj);
                }else {

                    $returnObj['found']=true;
                    //$returnObj['message']="К сожалению, доставка не работает ";
                     $session->set('restaurant_id',$found_zone->id);

                    return $this->sendJSONResponse($returnObj);


                }







            }


        }


        $returnObj['found']=$found;
        $returnObj['message']=$message;

        return $this->sendJSONResponse($returnObj);
    }


    public function actionSelectGift(){

        $gift_id = \Yii::$app->request->post('gift');


        $session = \Yii::$app->session;


        $session->set('selected_gift_id',$gift_id);


        return $this->sendJSONResponse(['success'=>true]);





    }


    public function actionIndex(){

        $cart = $this->getCart();




        if (!$cart || count($cart->cartItems)==0){

            return $this->redirect(Url::toRoute(['site/index']));

        }
        $additionoal = \common\models\CatalogItem::find()->limit(10)->all();
        
        $cart->order_summ = 0;
        $isPickup = false;
        $countItem = 0;
        foreach ($cart->cartItems as $cart_item) {
            $cart->order_summ += $cart_item->sum;
            if($cart_item->catalog_item_pizza_options == 1){
                $countItem++;
            }
        }
        if($countItem == count($cart->cartItems)){
            $isPickup = true;
        }

        return $this->render('index', [
            'cart' => $cart,
            'additionoal' => $additionoal,
            'isPickup' => $isPickup
        ]);

    }

    public function actionDelete(){

        $cart_id = $this->getCartId();
        $cart = \common\models\Cart::findOne($cart_id);
        $cart_items = $cart->cartItems;

        $cart_item_id = \Yii::$app->request->post('cart_item_id');
        $card_item = \common\models\CartItem::find()->where(['id' => $cart_item_id, 'cart_id' => $cart_id])->one();
        if($card_item->delete()){
            $summary_price = 0;
            $summary_count = 0;
            foreach ($cart_items as $cart_item) {
                $summary_count += $cart_item->count;
                $summary_price += $cart_item->sum;
            };
        }

        return $this->sendJSONResponse(array(
            'error'=>false,
        ));

    }

    public function actionDecreaseCount($id){

        /**
         * @var CartItem $cartItem
         */

        if ($cartItem = CartItem::find()->where(['id'=>$id])->one()){



            if (!isset($cartItem->cart->order_id)){




                $cartItem->count--;

                if ($cartItem->count==0){
                    $cartItem->delete();
                }
                else{

                    $cartItem->save() ;

                }
                return $this->redirect(Url::toRoute(['index']));
            }

        }

        throw new NotFoundHttpException();



    }


    public function actionItemDell($id){

        /**
         * @var CartItem $cartItem
         */

        if ($cartItem = CartItem::find()->where(['id'=>$id])->one()){

            /**
             * @var Cart $cart
             */
            $cart= $cartItem->cart;

            if (!isset($cart->order_id)){




                    $cartItem->delete();


                return $this->redirect(Url::toRoute(['index']));
            }

        }

        throw new NotFoundHttpException();



    }


    public function actionIncreaseCount($id){

        /**
         * @var CartItem $cartItem
         */

        if ($cartItem = CartItem::find()->where(['id'=>$id])->one()){



            if (!isset($cartItem->cart->order_id)){




                $cartItem->count++;
                $cartItem->save();
                return $this->redirect(Url::toRoute(['index']));
            }

        }

        throw new NotFoundHttpException();



    }

    public function actionAdd(){

        $catalogItem_id = \Yii::$app->request->post('catalogItem_id');
        $catalogItem_count = intval(\Yii::$app->request->post('catalogItem_count'));
        $catalogItem_size = \Yii::$app->request->post('catalogItem_size');
        $modificators = \Yii::$app->request->post('modificators');
        if(is_array($modificators)) $modificators = array_diff($modificators, array(''));

        $card_form = new CartForm();
        $cart_id = $this->getCartId();
        $card_form->addCardItem($cart_id, $catalogItem_id, $catalogItem_count, $catalogItem_size, $modificators);
        $this->setCartId($cart_id);
                
        $cart = \common\models\Cart::findOne($cart_id);
        $cart_items = $cart->cartItems;
        $summary_price = 0;
        $summary_count = 0;
        foreach ($cart_items as $cart_item) {
            $summary_count += $cart_item->count;
            $summary_price += $cart_item->sum;
        }

        return $this->sendJSONResponse(array(
            'error'=>false,
            'summary_count'=>$summary_count,
            'summary_price'=>$summary_price,

            'cart_id'=>$cart_id,
        ));

    }

    protected function getCart(){
        $cookies = \Yii::$app->request->cookies;
        if (isset($cookies['cart'])) {
            $id =  $cookies['cart']->value;
            $cart = \common\models\Cart::find()->where(['id' => $id])->one();
            if($cart){
                return $cart;
            }
        }
        return false;
    }

    protected function getCartId(){
        $id = null;
        $cookies = \Yii::$app->request->cookies;
        if (isset($cookies['cart'])) {
            $id =  $cookies['cart']->value;
            if(!\common\models\Cart::find()->where(['id' => $id])->exists()){
                $cart = new CartForm();
                $id = $cart->add();
            }
        }else{
            $cart = new CartForm();
            $id = $cart->add();
        }
        return $id;
    }

    protected function setCartId($id){
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => $id,
        ]));
        return true;
    }

    public function clearCartId(){
        $cookies = \Yii::$app->response->cookies;
        $cookies->remove('cart');
        $session= Yii::$app->session;

        $session->remove('promo_id');
        $session->remove('restaurant_id');
        unset($cookies['cart']);
    }
}
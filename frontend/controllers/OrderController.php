<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\components\MyExtensions\MyHelper;
use common\models\CartItem;
use common\models\Organisation;
use frontend\models\forms\CartForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use frontend\models\forms\OrderForm;
use common\models\RestaurantZone;
use common\models\Cart;
use common\models\Order;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use YandexCheckout\Client;

class OrderController extends FrontendController
{



    public function actionRepeat($id){


        /**
         * @var Order $order
         * @var Cart $order_cart
         * @var  CartItem $cart_item;
         */
        $order = Order::find()->where(['id'=>$id,'user_id'=>\Yii::$app->user->id])->one();


        if ($order){


            $cart_id = $this->getCartIdForRepeat();


            $this->setCartId($cart_id);

            $cart_id = $this->getCartId();



            $order_cart = $order->getCarts()->one();

            foreach ($order_cart->cartItems as $cart_item){




                $this->actionAdd($cart_item->catalog_item_id,$cart_item->count,$cart_item->catalog_item_pizza_options,array());



            }

           return $this->redirect(Url::toRoute(['cart/index']));
        }

        throw new NotFoundHttpException();

    }

    protected function setCartId($id){
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => $id,
        ]));
        return true;
    }


    public function actionValidate(){


        $model = new OrderForm();

        // validate any AJAX requests fired off by the form
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->validate();
        }

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



    public function actionIndex(){

    	$addresses = [];
    	$model = new OrderForm();

        if(!Yii::$app->user->isGuest){
            $model->userData();
            $addresses = Yii::$app->user->identity->addresses;

        }

        $isPickup = Yii::$app->request->post('is_pickup');
        if($isPickup){
            $model->address = 'Климентовский переулок, 2';
            $model->lat = 55;
            $model->lng = 66;
        }
        $cart_id = $this->getCartId();
        if($cart_id)
            $cart = Cart::findOne($cart_id);
        else {
            $error[] = "Корзина пустая";
        }


        if ($model->load(Yii::$app->request->post())){
            $zone = OrderForm::CheckZone($model->lat,$model->lng);
            if (!$zone){
                return $this->redirect(Url::toRoute(['cart/index']));
            }

            else{

                //$zone = RestaurantZone::findOne($restaurant_zone_id);
                $restaurant= $zone->restaurant;
                $min_order=$zone->min_order;
                $stop_list = $restaurant->getStopListElements()->select('catalog_item_id')->asArray()->all();


                $stop_list = \yii\helpers\ArrayHelper::getColumn($stop_list,'catalog_item_id');


                if ($min_order> $cart->sum){
                    return $this->redirect(Url::toRoute(['cart/index']));

                }

                foreach ($cart->cartItems as $item){

                    if (\yii\helpers\ArrayHelper::isIn($item->catalogItem->id,$stop_list)){

                        return $this->redirect(Url::toRoute(['cart/index']));

                    }
                }

            }

        }


        //exit();

    	if($model->load(Yii::$app->request->post()) && $order = $model->add($cart)){


            $smsPaymentMessage = "Наличные";

            /**
             * @var Order $order
             */
            if ($order->payment_type==Order::PAYMENT_TYPE_CARD){


                $smsPaymentMessage = "Карта";


                /**
                 * @var Organisation $organisation
                 */
                
                //$orderUrl = 'https://money.yandex.ru/eshop.xml?';
                //$shopID = 148537;
                //$scid = 555754;
                //$sum = $order->payment_summ;
                //$paymentType = 'AC';
                //$customerNumber = 'YRiKPdXXgZGn7bB';
                //$orderNumber = $order->id;
                //$orderUrl .= "shopid=".$shopID."&scid=".$scid."&sum=".$sum."&paymentType=PC&customerNumber=".$customerNumber."&orderNumber=".$orderNumber."&lang=ru";

                $client = new Client();
                $client->setAuth('184812', 'live_A25CMUe6Yv1ozOUH5YKHnFjccpTf3qv1ZvOdcwl0238');
                
                $idempotenceKey = uniqid('', true);
                $payment = $client->createPayment(
                    array(
                        'amount' => array(
                            'value' => $order->payment_summ,
                            'currency' => 'RUB'
                        ),
                        'confirmation' => array(
                            'type' => 'redirect',
                            'return_url' => Url::toRoute(['/order/view','id'=>$order->id],true),
                        ),
                    ),
                    uniqid('', true)
                );
                $order->payment_type = Order::PAYMENT_TYPE_CARD;
                $order->payment_status = Order::PAYMENT_STATUS_WAIT;
                $order->sber_id = $payment->id;
                $order->save(); 
                
                $orderUrl = $payment->_confirmation->_confirmationUrl;
                //if ($organisation =$order->restaurant->organisation){


//                     $merchantUser = $organisation->sber_user;
//                     $merchantPass = $organisation->sber_pass;
//                     $arrReq = array();

//                     $arrReq['userName'] = $merchantUser;
//                     $arrReq['password'] = $merchantPass;// Идентификатор магазина

//                     $arrReq['orderNumber'] = "PA".$order->id; // Идентификатор заказа в системе магазина
//                     $arrReq['amount'] = $order->payment_summ*100; // Сумма заказа
// //$arrReq['pg_lifetime'] = 3600 * 24; // Время жизни счёта (в секундах)
//                     $arrReq['description'] = 'Оплата заказа №' . $order->id; // Описание заказа (показывается в Платёжной системе)
//                     $arrReq['returnUrl'] = Url::toRoute(['/order/view','id'=>$order->id],true);
//                     $arrReq['failUrl'] = 'http://pronto24.ru';
//                     /* Параметры безопасности сообщения. Необходима генерация pg_salt и подписи сообщения. */
//                     $query = http_build_query($arrReq);
//                     $orderUrl = 'https://securepayments.sberbank.ru/payment/rest/register.do?'.$query;
//                     //$orderUrl = 'https://3dsec.sberbank.ru/payment/rest/register.do?'.$query;


//                     $orderJ = json_decode(file_get_contents($orderUrl),true);
//                     $payment_link=ArrayHelper::getValue($orderJ,'formUrl',$orderJ);
//                     $sber_id=ArrayHelper::getValue($orderJ,'orderId',false);

//                     if ($sber_id){

//                         $order->payment_type=Order::PAYMENT_TYPE_CARD;
//                         $order->payment_status=Order::PAYMENT_STATUS_WAIT;
//                         $order->sber_id=$sber_id;
//                         $order->save();

//                     }
                    $this->clearCartId();
//                     $orderUrl = $payment_link;
                    $order->generateXML();
                    //return $this->render('payment', ['order' => $order]);

                     MyHelper::sendSms("Новый заказ:№ {$order->id}. Метод оплаты: {$smsPaymentMessage}" ,"9651864336,9262270288");
                      return $this->redirect($orderUrl);
                //}




            }

            try {
                MyHelper::sendSms("Новый заказ:№ {$order->id}. Метод оплаты: {$smsPaymentMessage}", "9651864336,9262270288");
            }catch (\Exception $exception){

            }
            $this->clearCartId();
            $order->generateXML();
            return $this->redirect(Url::toRoute(['/order/view','id'=>$order->id]));








    	}
    	else

        return $this->render('index', [
            'model' => $model,
            'addresses' => $addresses,
            'cart'=>$this->getCart(),
            'isPickup' => $isPickup
        ]);

    }
    public function actionView($id){


        $order = Order::findOne($id);

        return $this->render('view',['order'=>$order]);
    }

    public function afterAction($action, $result)
    {
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->url);
        return parent::afterAction($action, $result);
    }

    protected function getCartId(){
        $id = null;
        $cookies = \Yii::$app->request->cookies;
        if (isset($cookies['cart']) && $cookies['cart']->value) {
            $id =  $cookies['cart']->value;
            if(!\common\models\Cart::find()->where(['id' => $id])->exists()){
                return false;
            }
        }else{
            return false;
        }
        return $id;
    }

    protected function clearCartId(){
        $cookies = \Yii::$app->response->cookies;
        $cookies->remove('cart');

        $session= Yii::$app->session;

        $session->remove('promo_id');
        $session->remove('restaurant_id');

        unset($cookies['cart']);
    }

    protected static function checkZone($lat,$lng){
        $returnObj = false;
        if ($lat && $lng){
            $zone  = RestaurantZone::find()->where(["ST_Contains(restaurant_zone.zone,ST_GeomFromText('POINT({$lng} {$lat} )',4326))"=>true])->all();
            if (count($zone)>0){
                $found_zone = $zone[0];
                $restaurant = $found_zone->restaurant;
                //$hours_info = $restaurant->getHoursInfo();
                if ($restaurant->checkHoursInfo()){
                    $returnObj =  $found_zone;
                }
            }
        }var_dump($returnObj);die;
        return $returnObj;
    }


    protected function getCartIdForRepeat(){
        $id = null;
        $cookies = \Yii::$app->request->cookies;
        if (isset($cookies['cart']) && $cookies['cart']->value) {
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


    public function actionAdd($catalogItem_id,$catalogItem_count,$catalogItem_size,$modificators){


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



}
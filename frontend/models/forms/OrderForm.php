<?php

namespace frontend\models\forms;

use common\components\MyExtensions\MyHelper;
use common\models\CatalogItem;
use common\models\Promo;
use common\models\Restaurant;
use common\models\RestaurantZone;
use common\models\User;
use Yii;
use yii\base\Model;
use common\models\Order;

class OrderForm extends Model
{
    public $name;
    public $phone;
    public $change_sum;
    public $address;
    public $address_id;
    public $entrance;
    public $floor;
    public $flat;
    public $client_comment;
    public $lat;
    public $lng;
    public $payment_type;
    public $gift_card_text;

    public $gift_id;
    public $promo_id;
    public $sber_id;
    public $platron_id;
    public $delivery_at;

    public $searchTitle;

    public function rules()
    {
        return [
            [['phone'], 'required','message'=>"Укажите номер вашего телефона в верном формате"],
            [['name'], 'required','message'=>"Укажите ваше имя"],
            [['phone','address', 'lat', 'lng', 'payment_type'], 'required'],
            [['gift_id', 'promo_id', 'payment_type'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['client_comment', 'gift_card_text'], 'string'],
            [['address', 'entrance', 'floor', 'flat', 'phone', 'change_sum', 'name', 'sber_id', 'platron_id', 'delivery_at'], 'string', 'max' => 255],
        ];
    }

    public function userData(){

        $this->phone = Yii::$app->user->identity->username;
		$this->name = Yii::$app->user->identity->name;

		return $this;
    }

    public function add($cart){
        $order = new Order();
        if($this->validate()){


            $phone= MyHelper::preparePhone($this->phone);


            $order->name = $this->name;
            $order->phone = $phone;
            $order->change_sum = $this->change_sum;
            $order->address = $this->address;
            $order->entrance = $this->entrance;
            $order->floor = $this->floor;
            $order->flat = $this->flat;
            $order->client_comment = $this->client_comment;
            $order->gift_card_text = $this->gift_card_text;
            $order->lat = $this->lat;
            $order->lng = $this->lng;
            $order->payment_type = $this->payment_type;

        	$order->order_source = \common\models\Order::TYPE_SITE;


        	$session = Yii::$app->session;

            //$promo_id =null;

            $promo_id=$session->get('promo_id',null);
            $gift_id = $session->get('selected_gift_id',null);
        	if ($promo_id){

               // $order->promo_id= (int)$promo_id;

                if($gift_id=$session->get('selected_gift_id') && $promo_id && $promo = Promo::find()->where(['id'=>$promo_id])->one() && $gift = CatalogItem::find()->where(['id'=>$gift_id])->one() ){
                    $order->gift_id=$gift->id;
                }
                $order->promo_id= $promo_id;
            }




        	//print_r($order->promo_id);
            if ($restaurantZone = self::CheckZone($this->lat,$this->lng)) {

                $restaurant = $restaurantZone->restaurant;


                    /**
                     * @var User $user
                     */
                    if (\Yii::$app->user->isGuest) {


                        $user = User::find()->where(['username' => $phone])->one();

                        if (!$user) {
                            $user = new User();
                            $user->username = $phone;
                            $user->name=$order->name;
                            $password = self::randomString(4);
                            $user->setPassword($password);
                            $user->generateAuthKey();
                            $user->status=User::STATUS_NOT_CONFIRMED;
                            $user->save();
                        }


                    } else {

                        $user = \Yii::$app->user->getIdentity();

                        if (!$user->name){
                            $user->name =  $order->name;
                            $user->save();
                            $user->generateXml();

                        }elseif (strlen($user->name)==0){

                            $user->name =  $order->name;
                            $user->save();
                            $user->generateXml();
                        }
                    }

                    $order->user_id = $user->id;

                    $order->restaurant_id=$restaurant->id;

                    $order->restaurant_zone_id=$restaurantZone->zone_external_id;
                    if ($order->save()) {

                        $cart->order_id = $order->id;
                        $cart->user_id = $user->id;

                        if ($cart->save()) {

                            $newOrder = Order::find()->where(['id'=>$order->id])->with(['carts.cartItems','carts.cartItems.catalogItem','carts.cartItems.cartItemModificators'])->one();

                            $newOrder->updateSum();




                            return $newOrder;
                        }
                    }
                    else{
                       // print_r($order->getErrors());
                    }
                }
                else{
                exit();
                }

            }




    }

    /**
     * @param $lat
     * @param $lng
     * @return bool|RestaurantZone
     */
    public static function  CheckZone($lat,$lng){


        $returnObj = false;

        if ($lat && $lng){

            $zone  = RestaurantZone::find()->where(["ST_Contains(restaurant_zone.zone,ST_GeomFromText('POINT({$lng}  {$lat} )',4326))"=>true])->all();

            if (count($zone)>0){



                /**
                 * @var RestaurantZone $found_zone
                 * @var  Restaurant $restaurant
                 */
                $found_zone = $zone[0];

                $restaurant = $found_zone->restaurant;


                //$hours_info = $restaurant->getHoursInfo();


                if ($restaurant->checkHoursInfo()){

                    $returnObj =  $found_zone;
                }


               // $returnObj =  $found_zone;

            }


        }


        return $returnObj;

    }

    static function randomString($length = 6) {
        $str = "";
        $characters = array_merge(  range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}

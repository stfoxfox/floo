<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19/05/2017
 * Time: 12:02
 */

namespace frontend\controllers;


use api\controllers\OrderController;
use common\components\controllers\FrontendController;
use common\components\MyExtensions\MyHelper;
use common\components\MyExtensions\MyImagePublisher;
use common\models\Cart;
use common\models\CartItem;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use common\models\Order;
use common\models\Tag;
use common\models\User;
use DOMDocument;
use yii\web\Response;

class DcController extends FrontendController
{

    public $pizza_cat_id =1;

    public function init() {



    }


    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'send-order') {
            # code...
            $this->enableCsrfValidation = false;

            \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
           // \Yii::$app->response->headers->add('Content-Type', 'text/xml');
        }else{

            \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            \Yii::$app->response->headers->add('Content-Type', 'text/xml');
        }
        return parent::beforeAction($action);
    }


    public function actionSendOrder($order_hash) {



        $orderUrl = 'http://www.delivery-club.ru/api/orders/?hash=' . $order_hash;
        $result = file_get_contents($orderUrl);
        $result = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $result);
        $orderXml = simplexml_load_string($result);

        if ($orderXml && !$orderXml->error) {
            $ordAppTemp = $orderXml;

            $ordApp = $ordAppTemp->attributes()->{'application'};


            $order  = new Order();


            $phone=$orderXml->personal_data->phone_code . ' ' . $orderXml->personal_data->phone;

            $phone= MyHelper::preparePhone($phone);



            $address_string =   (string)$orderXml->personal_data->address;



            $lat = $orderXml->personal_data->lat;
            $lng = $orderXml->personal_data->long;



            $order->name=(string)$orderXml->personal_data->name;;
            $order->phone=$phone;
            $order->address=$address_string;
            $order->lat=$lat;
            $order->lng=$lng;
            $order->order_source=Order::TYPE_DC;
            $order->flat=(string)$orderXml->personal_data->apt;
            $order->entrance=(string)$orderXml->personal_data->entrance;
            $order->floor= (string)$orderXml->personal_data->floor;

            $order->payment_type = Order::PAYMENT_TYPE_CASH;


            $comments = (string)$orderXml->comments;

            $comments .= "\nГород: " . $orderXml->personal_data->city;
            if($orderXml->order_details->is_delivery_asap ==0) {
                $order->delivery_at = $orderXml->order_details->delivery_time;
            }


            $order->client_comment = trim($comments);

            $order->phone = $phone;


            $order->dc_link_approve = trim($orderXml->links->approve);
            $order->dc_link_cancel = trim($orderXml->links->cancel);

            $cartItemsArray = array();



            foreach($orderXml->cart->product as $product) {


                $cItem = CartItem::getFromDCXml($product);

                $cartItemsArray[]=$cItem ;


            }



            if ($restaurantZone = OrderController::CheckZone($lat,$lng)) {

                $restaurant = $restaurantZone->restaurant;
                if (count($cartItemsArray) > 0) {

                    /**
                     * @var User $user
                     */



                        $user = User::find()->where(['username' => $phone])->one();

                        if (!$user) {
                            $user = new User();
                            $user->username = $phone;
                            $user->name=$order->name;
                            $password = OrderController::randomString(4);
                            $user->setPassword($password);
                            $user->generateAuthKey();
                            $user->status=User::STATUS_NOT_CONFIRMED;
                            $user->save();
                        }




                    $order->user_id = $user->id;

                    $order->restaurant_id=$restaurant->id;

                    $order->restaurant_zone_id=$restaurantZone->zone_external_id;
                    if ($order->save()) {

                        $cart = new Cart();
                        $cart->order_id = $order->id;
                        $cart->user_id = $user->id;

                        if ($cart->save()) {
                            /**
                             * @var CartItem $cartItemToSave
                             */


                            foreach ($cartItemsArray as $cartItemToSave) {
                                $cartItemToSave->cart_id = $cart->id;
                                if ($cartItemToSave->save()) {


                                    foreach ($cartItemToSave->tempModificatorsArray as $modificator) {

                                        $modificator->cart_item_id = $cartItemToSave->id;
                                        $modificator->save();
                                    }
                                }
                            }


                            /**
                             * @var Order $newOrder
                             */
                            $newOrder = Order::find()->where(['id'=>$order->id])->with(['carts.cartItems','carts.cartItems.catalogItem','carts.cartItems.cartItemModificators'])->one();

                            $newOrder->updateSum();



                            $newOrder->generateXML();

                            return $order->id;
                        }
                    }
                    else{

                        print_r($order->getErrors());
                    }
                }

            }
            else{

                return "Ресторан не работает";
            }



            }


            return "Ошибка";


    }


    public function actionExport()
    {





        //$setting = Settings::model()->findByPk(Settings::CATEGORIES_NO_CC_PAYMENT);
        $exportXmlData = "<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE dc_catalog SYSTEM 'http://www.delivery-club.ru/xml/dc.dtd'>
<dc_catalog last_update='" . CatalogCategory::findLastUpdatedAtProductOrProductGroup() . "'></dc_catalog>
";



        $exportXml = simplexml_load_string($exportXmlData);
        $exportXmlDelivery = $exportXml->addChild('delivery_service');





        $categoriesNode = $exportXmlDelivery->addChild('categories');




        /**
         * @var CatalogCategory[] $category_items
         */




        $category_items = CatalogCategory::find()->orderBy('sort')->all();


        foreach ($category_items as $category_item){

            $categoryNode = $categoriesNode->addChild('category', $category_item->title);
            $categoryNode->addAttribute('id', $category_item->id);



            $tags = Tag::find()->joinWith('catalogItems')->where(['catalog_item.category_id'=>$category_item->id])->orderBy('sort')->all();


            foreach ($tags as $tag){


                $categoryNode = $categoriesNode->addChild('category', $tag->tag);
                $categoryNode->addAttribute('id', $category_item->id*1000+$tag->id);
                $categoryNode->addAttribute('parentId', $category_item->id);


            }






        }








        $productsNode = $exportXmlDelivery->addChild('products');

        /**
         * @var CatalogItem[] $catalog_items
         */
        $catalog_items= CatalogItem::find()->where(['active'=>true])->orderBy('sort')->all();

        foreach ($catalog_items as $catalog_item){



            $itemNode = $productsNode->addChild('product');
            $itemNode->addAttribute('id', $catalog_item->id);

            if (empty($catalog_item->tags)){
                $itemNode->addChild('category_id', $catalog_item->category_id);

            }else{

                foreach ($catalog_item->tags as $tag){


                    $itemNode->addChild('category_id',$catalog_item->category_id*1000+$tag->id);



                }


            }



            $itemNode->addChild('name',htmlspecialchars( $catalog_item->title));

            $itemNode->addChild('description', str_replace(array('&'), array('&amp;'), trim(strip_tags($catalog_item->description))));



            if (!empty($catalog_item->file_name)) {
                $itemNode->addChild('picture', (new MyImagePublisher($catalog_item))->MyThumbnail(512,512));
            }

            if ($catalog_item->price_st_st && $catalog_item->price_big_st){

                $itemNode->addChild('price', $catalog_item->price_st_st);


                $variantNode = $itemNode->addChild('variants');
                $variantGroupNode = $variantNode->addChild('variants_group');
                $variantGroupNode->addAttribute('title','Размер');

                $variantGroupItem = $variantGroupNode->addChild('variant');
                $variantGroupItem->addAttribute('title','Стандартная');
                $variantGroupItem->addAttribute('id',1);
                $variantGroupItem->addAttribute('price',0);

                $variantGroupItem = $variantGroupNode->addChild('variant');
                $variantGroupItem->addAttribute('title','Большая');
                $variantGroupItem->addAttribute('id',2);
                $variantGroupItem->addAttribute('price',$catalog_item->price_big_st -$catalog_item->price_st_st );

            }else{

                $itemNode->addChild('price', $catalog_item->price);
            }



            if (!empty($catalog_item->catalogItemModificators)) {
                $ingredientsNode = $itemNode->addChild('ingredients');
                foreach($catalog_item->catalogItemModificators as $productAdditive) {
                    $itemNode = $ingredientsNode->addChild('ingredient');
                    $itemNode->addAttribute('id', $productAdditive->id);
                    $itemNode->addAttribute('title', $productAdditive->title);
                    $itemNode->addAttribute('price', $productAdditive->price);
                }
            }





        }



        $doc = new DOMDocument('1.0');
        $doc->preserveWhiteSpace = false;
        $doc->loadXML($exportXml->asXML());
        $doc->formatOutput = true;

        return $doc->saveXML();




    }
}
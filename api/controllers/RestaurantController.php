<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 23:02
 */

namespace api\controllers;


use Codeception\Coverage\Subscriber\RemoteServer;
use common\components\controllers\ApiController;
use common\components\MyExtensions\MyError;
use common\models\Region;
use common\models\Restaurant;
use common\models\RestaurantZone;
use common\models\StopListElement;
use common\models\Tag;
use yii\db\Query;

class RestaurantController extends ApiController
{

    public function actionGetRegions(){


        $regions = Region::find()->orderBy('sort')->all();

        $returnRegions = array();// = array('about_text'=>"Много текста о ресторане");

        foreach ($regions as $region){

            $returnRegions[]= $region->getJson();
        }



        return $this->sendResponse(array('about_text'=>"Собирайте трендовые букеты для себя и своих друзей!
 
Мы не продаём готовые букеты - мы продаём цветы и знания для того, чтобы пробудить Ваше творческое начало и погрузить Вас в мир флористики.

4 шага к сбору своего букета:

• Вы придумываете идею букета или черпаете вдохновение 
из наших подборок и набираете нужный состав цветов
• Мы собираем цветы и аккуратно упаковываем 
в коробку
• Наши курьеры бережно и бесплатно доставляют заказ 
• Вы воплощаете идею в жизнь - собираете цветы в задуманный букет  

Регистрируйтесь и получайте 250 баллов для покупки в нашем приложении. 
С каждого оплаченного заказа получайте 5% кэшбэк на лицевой счет в приложении.",'items'=>$returnRegions));
    }



    public function actionGetInfo($id){



        if ($restaurant = Restaurant::findOne($id)){

            $returnObj = $restaurant->getDetailedJson();

            return $this->sendResponse($returnObj);

        }






        return $this->sendError(MyError::BAD_REQUEST);



    }

    public function actionGetList($region_id,$tag_id=null){


        if ($region = Region::findOne($region_id) ){


            $items = array();

            $restaurant_ids = array();

            $restaurants_query = $region->getRestaurants()->orderBy('sort');

            if (isset($tag_id)){
                $restaurants_query->where(['id'=>(new Query())->select('restaurant_id')->from('restaurant_tag_link')->where(['tag_id'=>$tag_id])]);

            }

            $restaurants = $restaurants_query->all();
            /**
             * @var Restaurant $item
             */
            foreach ($restaurants as $item){

                $items[]= $item->getJson();
                $restaurant_ids[]=$item->id;
            }

            $tags = Tag::find()->joinWith('restaurants')->where(['restaurant.id'=>$restaurant_ids])->orderBy('sort')->all();
            $tagsArray = array();
            foreach ($tags as $tag){

                $tagsArray[]=$tag->getJson();
            }


            return $this->sendResponse(array(
                'items'=>$items,
                'tags'=>$tagsArray,
            ));

        }


        return $this->sendError(MyError::BAD_REQUEST);
    }


    public function actionCheckZone(){


        $lat  = \Yii::$app->request->post('lat');
        $lng = \Yii::$app->request->post('lng');

        $returnObj = array();
        $found=false;
        if ($lat && $lng){

            $zone  = RestaurantZone::find()->where(["ST_Contains(restaurant_zone.zone,ST_GeomFromText('POINT({$lng}  {$lat} )',4326))"=>true])->all();

            if (count($zone)==0){
                $found = false;

            }
            else{

                $found = true;

                /**
                 * @var RestaurantZone $found_zone
                 * @var  Restaurant $restaurant
                 */
                $found_zone = $zone[0];

                $restaurant = $found_zone->restaurant;

                $returnObj['restaurant'] = $restaurant->getJson();

                $hours_info = $restaurant->getHoursInfo();

                $returnObj['hours_info']=$hours_info;

                $returnObj['min_order']=$found_zone->min_order;


                /**
                 * @var StopListElement[] $stop_list_items
                 */
                $stop_list_items = $restaurant->getStopListElements()->all();

                $stop_list_array = array();
                foreach ($stop_list_items as $stop_list_item){

                    $stop_list_array[]=$stop_list_item->getJson();

                }

                $returnObj['stop_list']=$stop_list_array;


            }


        }

        $returnObj['found']=$found;

        return $this->sendResponse($returnObj);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 23:57
 */

namespace backend\controllers;


use backend\models\forms\AddRegionForm;
use backend\models\forms\RestaurantForm;
use common\components\controllers\BackendController;
use common\components\MyExtensions\MyHelper;
use common\models\Region;
use common\models\Restaurant;
use common\models\RestaurantZone;
use common\models\WorkingDays;
use common\models\WorkingHours;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RestaurantController extends BackendController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [

                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionAddRegion(){


        $title = \Yii::$app->request->post('title');
        if( $title){



            $region = new Region();
            $region->title=$title;

            if($region->save())
                return $this->sendJSONResponse(array('error'=>false,'region_title'=>$region->title,'region_id'=>$region->id));



        }

        return $this->sendJSONResponse(array('error'=>true));


    }


    public function actionEdit($id){



        if ($restaurant = Restaurant::findOne($id)){

            $this->pageHeader = $restaurant->address;
            $editForm = new RestaurantForm();


            if (\Yii::$app->request->isPost){


                if ($editForm->load(\Yii::$app->request->post())){


                    if ($editForm->saveItem($restaurant)){

                        return $this->redirect(Url::toRoute(['edit','id'=>$restaurant->id]));

                    }
                }

            }else{


                $editForm->loadFromModel($restaurant);
            }


            $workingDays=array();
            $weekDaysArray=ArrayHelper::map($restaurant->workingDays,'weekday','id');

            $restaurantZone = RestaurantZone::find()->where(['restaurant_id' => $id])->all();

            for($weekDayNumber=1;$weekDayNumber<=7;$weekDayNumber++){


                if(isset($weekDaysArray[$weekDayNumber])){


                    $wD = MyHelper::searchById($restaurant->workingDays,$weekDaysArray[$weekDayNumber]);


                }
                else{

                    $wD= new WorkingDays();
                    $wD->restaurant_id=$restaurant->id;
                    $wD->weekday=$weekDayNumber;


                }

                $workingDays[]=$wD;


            }


            return $this->render('edit',[
                'editForm'=>$editForm,
                'workingDays'=>$workingDays,
                'restaurantZone' => $restaurantZone,
                'restaurant' => $restaurant
            ]);
        }


        throw new NotFoundHttpException("Ресторан не найден");

    }

    public function actionRegionSort(){


        $sort = \Yii::$app->request->post('region_order');

        if($sort){
            $i=0;
            foreach($sort as $cat_id){
                $i++;
                Region::updateAll(['sort'=>$i],['id'=>$cat_id]);


            }

            return  $this->sendJSONResponse(array('error'=>false));


        }


        return  $this->sendJSONResponse(array('error'=>true));



    }
    public function actionItemDell(){

        $item_id = \Yii::$app->request->post('item_id');

        if($item_id){

            /** @var Restaurant $restaurant */
            if($restaurant = Restaurant::findOne(['id'=>$item_id])){
                if($restaurant->delete()){
                    return $this->sendJSONResponse(array('error'=>false,'item_id'=>$item_id));
                }
            }
        }



        return $this->sendJSONResponse(array('error'=>true));

    }


    public function actionRegionDell(){

        $category_id = \Yii::$app->request->post('category_id');

        if($category_id){

            /** @var Region $region */
            if($region = Region::findOne(['id'=>$category_id])){
                if($region->delete()){
                    return $this->sendJSONResponse(array('error'=>false,'category_id'=>$category_id));
                }
            }
        }



        return $this->sendJSONResponse(array('error'=>true));

    }


    public function actionAdd($region_id){


        if ($region = Region::findOne($region_id)){


            $addForm = new RestaurantForm();
            $addForm->region_id=$region_id;


            if ($addForm->load(\Yii::$app->request->post())){

                if ($restaurant = $addForm->createRestaurant()){


                    return $this->redirect(Url::toRoute(['edit','id'=>$restaurant->id]));
                }


            }
            return $this->render('add-restaurant',['addForm'=>$addForm]);
        }

        throw new \yii\web\NotFoundHttpException("Региона не существует");
    }

    public function actionEditRegion(){


        $title = \Yii::$app->request->post('title');
        $category_id = \Yii::$app->request->post('category_id');
        if( $title && $region = Region::findOne($category_id)) {


            $region->title=$title;

            if($region->save())
                return $this->sendJSONResponse(array('error'=>false,'region_title'=>$region->title,'region_id'=>$region->id));



        }

        return $this->sendJSONResponse(array('error'=>true));


    }

    public function actionView($id=null){


        $this->pageHeader="Управление ресторанами";


        $regions = Region::find()->orderBy('sort')->all();

        if(isset($id) && $region = Region::findOne($id) ){

            return $this->render('index',['regions'=>$regions,'selectedRegion'=>$region]);

        }elseif ($region = Region::find()->limit(1)->orderBy('sort')->one()) {

            return $this->redirect(Url::toRoute(['view','id'=>$region->id]));
        }




        $addForm = new AddRegionForm();


        if ($addForm->load(\Yii::$app->request->post()) && $newRegion= $addForm->createRegion()){

            return $this->redirect(Url::toRoute(['view']));
        }

        return $this->render('add-region',['addForm'=>$addForm]);


    }



    public function actionSetDeliveryHours(){


        $weekday = \Yii::$app->request->post('weekday');
        $startTimeFull = \Yii::$app->request->post('start_time');
        $stopTimeFull = \Yii::$app->request->post('stop_time');

        $startTime = date("H:i",strtotime($startTimeFull));
        $stopTime = date("H:i",strtotime($stopTimeFull));

        $restaurant_id=\Yii::$app->request->post('restaurant_id');

        if ($restaurant =Restaurant::findOne($restaurant_id)){


            $workingDay = WorkingDays::findOne(['restaurant_id' => $restaurant->id, 'weekday' => $weekday]);

            if (!$workingDay){

                $workingDay= new WorkingDays();
                $workingDay->restaurant_id=$restaurant->id;
                $workingDay->weekday=$weekday;
                $workingDay->status=WorkingDays::STATUS_HAS_HOURS;
                $workingDay->save();
            }


            if ( $workingDay = WorkingDays::findOne(['restaurant_id' => $restaurant->id, 'weekday' => $weekday])){


                if ($workingHours = $workingDay->getWorkingHours()->where(['type'=>WorkingHours::TYPE_DELIVERY])->one()){

                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->save();
                }
                else{

                    $workingHours= new WorkingHours();
                    $workingHours->working_day_id= $workingDay->id;
                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->type=WorkingHours::TYPE_DELIVERY;
                    $workingHours->save();
                }
            }

        }





    }

    public function actionSetHours(){


        $weekday = \Yii::$app->request->post('weekday');
        $startTimeFull = \Yii::$app->request->post('start_time');
        $stopTimeFull = \Yii::$app->request->post('stop_time');

        $startTime = date("H:i",strtotime($startTimeFull));
        $stopTime = date("H:i",strtotime($stopTimeFull));

        $restaurant_id=\Yii::$app->request->post('restaurant_id');

        if ($restaurant =Restaurant::findOne($restaurant_id)){


            $workingDay = WorkingDays::findOne(['restaurant_id' => $restaurant->id, 'weekday' => $weekday]);

            if (!$workingDay){

                $workingDay= new WorkingDays();
                $workingDay->restaurant_id=$restaurant->id;
                $workingDay->weekday=$weekday;
                $workingDay->status=WorkingDays::STATUS_HAS_HOURS;
                $workingDay->save();
            }


            if ( $workingDay = WorkingDays::findOne(['restaurant_id' => $restaurant->id, 'weekday' => $weekday])){


                if ($workingHours = $workingDay->getWorkingHours()->where(['type'=>WorkingHours::TYPE_RESTAURANT])->one()){

                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->save();
                }
                else{

                    $workingHours= new WorkingHours();
                    $workingHours->working_day_id= $workingDay->id;
                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->type=WorkingHours::TYPE_RESTAURANT;
                    $workingHours->save();
                }
            }

        }





    }


}
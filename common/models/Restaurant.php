<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 28/11/2016
 * Time: 21:09
 */

namespace common\models;


use common\models\BaseModels\RestaurantBase;
use yii\helpers\ArrayHelper;

class Restaurant extends RestaurantBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation()
    {
        return $this->hasOne(Organisation::className(), ['id' => 'organisation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromos()
    {
        return $this->hasMany(Promo::className(), ['id' => 'promo_id'])->viaTable('restaurant_promo_link', ['restaurant_id' => 'id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('restaurant_tag_link', ['restaurant_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStopListElements()
    {
        return $this->hasMany(StopListElement::className(), ['restaurant_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDays()
    {
        return $this->hasMany(WorkingDays::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancies()
    {
        return $this->hasMany(Vacancy::className(), ['id' => 'vacancy_id'])->viaTable('vacancy_restaurant_link', ['restaurant_id' => 'id']);
    }

    public function getJson(){
        $returnObj = array(
            'id'=>$this->id,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'address'=>$this->address,


        );


        if ($this->metro){

            $metroItems = array();
            $metros = explode("\n", str_replace("\r", "", $this->metro));
            foreach ($metros as $metro){
                try{

                $metroObj = explode(";", $metro);

                $metroItems[] = array('title'=>$metroObj[0],'color'=>$metroObj[1]);}
                catch (\Exception $e){
                    
                }
            }

            $returnObj['metro']=$metroItems;


        }

        return $returnObj;

    }


    public function getDetailedJson(){


        $returnObj = array(
            'id'=>$this->id,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'address'=>$this->address,


        );


        $phonesArray = array();

        if ($this->phone){

            $phonesArray[]=$this->phone;
        }


        $returnObj['phones']=$phonesArray;

        if ($this->metro){

            $metroItems = array();
            $metros = explode("\n", str_replace("\r", "", $this->metro));
            foreach ($metros as $metro){

                $metroObj = explode(";", $metro);

                $metroItems[] = array('title'=>$metroObj[0],'color'=>$metroObj[1]);
            }

            $returnObj['metro']=$metroItems;


        }


        $promos = Promo::find()->joinWith('restaurants')->where(['restaurant.id'=>$this->id])->orWhere(['for_all_restaurants'=>true])->orderBy('sort')->all();

        $promoArray = array();

        foreach ($promos as $promo){

            $promoArray[]=$promo->getListJson();
        }


        $returnObj['promo_items']=$promoArray;



        $WorkingDays = $this->getWorkingDays()->with(['workingHours'])->orderBy('weekday')->all();

        $restaurantHours= array();
        $deliveryHours =array();

        foreach ($WorkingDays as $WorkingDay){

            /**
             * @var WorkingHours $workingHour
             */
            foreach ($WorkingDay->workingHours as $workingHour){

                if ($workingHour->type == WorkingHours::TYPE_DELIVERY){
                    $deliveryHours[]= array('day'=>$WorkingDay->weekday,'hours'=>$workingHour->getJson());
                }else{
                    $restaurantHours[]= array('day'=>$WorkingDay->weekday,'hours'=>$workingHour->getJson());
                }

            }

        }

        $returnObj['restaurant_hours']=$restaurantHours;
        $returnObj['delivery_hours']=$deliveryHours;



        return $returnObj;

    }



    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'address');
    }


    public function checkHoursInfo(){

        $isOpen = false;


        $dayOfWeek =date('w');
        if ($dayOfWeek == 0) {
            $dayOfWeek = 7;
        }

        $hour = date('G');
        if($hour >=0 && $hour<10){
            $dayOfWeek --;
            if ($dayOfWeek == 0) {
                $dayOfWeek = 7;
            }
        }

        $day = $this->getWorkingDays()->where(['weekday'=>$dayOfWeek])->one();

        if ($day){
            /**
             * @var WorkingDays $day
             * @var WorkingHours $hours
             */
            $hours = $day->getWorkingHours()->where(['type'=>WorkingHours::TYPE_DELIVERY])->one();

            if ($hours){

                date_default_timezone_set( 'Europe/Moscow');



                $timeFromInt = strtotime($hours->open_time);
                $timeToInt = strtotime($hours->close_time);

                $timeNow = time();

                if ($timeFromInt >= $timeToInt) {
                    $timeToInt += 3600 * 24;
                }


                if($hour >=0 && $hour<10){
                    $timeFromInt -= 3600 * 24;
                    $timeToInt -= 3600 * 24;
                }

                if ($timeNow >= $timeFromInt && $timeNow <= $timeToInt) {
                    $isOpen = true;
                }

            }



        }

        return $isOpen;

    }

    public function getHoursInfo(){

        $isOpen = false;

        $returnObj = array();

        $dayOfWeek =date('w');
        if ($dayOfWeek == 0) {
            $dayOfWeek = 7;
        }

        $hour = date('G');
        if($hour >=0 && $hour<10){
            $dayOfWeek --;
            if ($dayOfWeek == 0) {
                $dayOfWeek = 7;
            }
        }

        $day = $this->getWorkingDays()->where(['weekday'=>$dayOfWeek])->one();

        if ($day){
            /**
             * @var WorkingDays $day
             * @var WorkingHours $hours
             */
            $hours = $day->getWorkingHours()->where(['type'=>WorkingHours::TYPE_DELIVERY])->one();

            if ($hours){

                date_default_timezone_set( 'Europe/Moscow');

                $returnObj ['hours'] = $hours->getJson();

                $timeFromInt = strtotime($hours->open_time);
                $timeToInt = strtotime($hours->close_time);

                $timeNow = time();

                if ($timeFromInt >= $timeToInt) {
                    $timeToInt += 3600 * 24;
                }

                if ($timeNow >= $timeFromInt && $timeNow <= $timeToInt) {
                    $isOpen = true;
                }

            }



        }

        $returnObj ['is_open'] = $isOpen;
       // $returnObj ['timeNow'] = $timeNow;
        //$returnObj ['timeFromInt'] = $timeFromInt;
        ///$returnObj ['timeToInt'] = $timeToInt;
        return $returnObj;



    }
}
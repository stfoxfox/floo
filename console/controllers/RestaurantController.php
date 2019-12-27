<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/01/2017
 * Time: 17:27
 */

namespace console\controllers;


use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyFileSystem;
use common\models\CatalogItem;
use common\models\Restaurant;
use common\models\RestaurantZone;
use common\models\StopListElement;
use yii\base\Exception;
use yii\console\Controller;
use yii\db\Expression;
use yii\db\Query;

class RestaurantController extends Controller
{


    public function actionImportZones(){

echo "start \n";

        foreach (MyFileSystem::readDir(\Yii::getAlias('@jupiter'. '/')) as $file) {
            echo "file name: \n";
            if (preg_match('/^RESTAURANT_ZONES/', $file)) {
                try{

                self::loadZones(
                   self::xml2array(file_get_contents(\Yii::getAlias('@jupiter'. '/' . $file)))
                );
                rename(\Yii::getAlias('@jupiter'. '/' . $file), MyFileSystem::makeDirs(\Yii::getAlias('@jupiter_archive'. '/'.date('d-m-Y'). '/' . $file)));

                //unlink(dirname(__FILE__) . '/../../xml/FROM_JUPITER/' . $file);
                //rename(dirname(__FILE__) . '/../../xml/FROM_JUPITER/' . $file, $this->_saveTo . '/' . $file);
                    }
                catch (\Exception $exception){

                        MyError::sendErrorMessage("Проблемы со структурой файла зон:{$file}. Ошибка преобразования из XML в массив:".$exception->getMessage());
                        rename(\Yii::getAlias('@jupiter'. '/' . $file), MyFileSystem::makeDirs(\Yii::getAlias('@jupiter_archive'. '/'.date('d-m-Y'). '/' . $file)));



                    }
            }
        }


    }


    public function actionImportStopList(){


        foreach (MyFileSystem::readDir(\Yii::getAlias('@jupiter'. '/')) as $file) {
            if (preg_match('/^STOP_LIST_\d+/', $file)) {


                try{
                self::loadStops(
                    self::xml2array(file_get_contents(\Yii::getAlias('@jupiter'. '/' . $file))),$file
                );
                //unlink(dirname(__FILE__) . '/../../xml/FROM_JUPITER/' . $file);
                rename(\Yii::getAlias('@jupiter'. '/' . $file), MyFileSystem::makeDirs(\Yii::getAlias('@jupiter_archive'. '/'.date('d-m-Y'). '/' . $file)));

                }
                catch (\Exception $exception){

                    MyError::sendErrorMessage("Проблемы со структурой файла стоп листа:{$file}. Ошибка преобразования из XML в массив:".$exception->getMessage());
                    rename(\Yii::getAlias('@jupiter'. '/' . $file), MyFileSystem::makeDirs(\Yii::getAlias('@jupiter_archive'. '/'.date('d-m-Y'). '/' . $file)));



                }
            }
        }

    }


    public static function xml2array($xml)
    {
        return simplexml_load_string($xml);
    }

    private static  function  loadStops($xml,$file=" нет"){

        try{

            $restaurantId = (int)$xml->restaurant['id'];
            $restaurant = Restaurant::findOne(['external_id'=>$restaurantId]);
            if ($restaurant){



                StopListElement::deleteAll(['restaurant_id'=>$restaurant->id]);

                $stopsArray = self::validateStop($xml,$restaurant);


                foreach ($stopsArray as $item){

                    try{

                        $item->save();

                    }catch (\Exception $exception){


                    }
                }



            }




        }
        catch (\Exception $e){

            MyError::sendErrorMessage("Проблемы со структурой файла стоп листа:{$file}. Ошибка преобразования из XML в массив:".$e->getMessage());


        }

    }

    private static function loadZones($xml){




        try{

            $items = self::validateZones($xml->items->item );


            if (count($items)>0){
                 $zonesCount = 0;
                RestaurantZone::deleteAll();
            foreach ($items as $item){
                /** @var  $zone */

                foreach ($item as $zone){

                   if ( $zone->save())
                      {
                          $zonesCount++;

                    }




                }

            }

            MyError::sendErrorMessage("Импорт зон завершен. Импортиовано ".$zonesCount. " зоны для ".count($items)." ресторанов");

            }

        }
        catch (\Exception $e){

            MyError::sendErrorMessage("Проблемы со структурой файла зон. Ошибка преобразования из XML в массив:".$e->getMessage());


        }



    }

    private static function validateStop($items,$restaurant){

        $returnArray = array();


        if (isset($items->items)) {
            foreach ($items->items->item as $item) {

                $itemExternalId = $item['id'];

                /**
                 *  * @property double $ext_code_st_st
                 * @property double $ext_code_big_st
                 * @property double $ext_code_st_big
                 * @property double $ext_code_big_big
                 */
                /**
                 * @var CatalogItem $menuItem
                 */
                $menuItem = CatalogItem::find()
                    ->where("ext_code='".$itemExternalId."'")
                    ->orWhere("ext_code_st_st='".$itemExternalId."'")
                    ->orWhere("ext_code_big_st='".$itemExternalId."'")
                    ->orWhere("ext_code_st_big='".$itemExternalId."'")
                    ->orWhere("ext_code_big_big='".$itemExternalId."'")
                    ->one();
               //




                if ($menuItem){


                    $stopListElement = new StopListElement();
                    $stopListElement->restaurant_id=$restaurant->id;
                    $stopListElement->catalog_item_id=$menuItem->id;
                    $stopListElement->catalog_item_pizza_options=CatalogItem::PIZZA_OPTIONS_NONE;


                    if ($menuItem->ext_code_st_st == $itemExternalId){
                        $stopListElement->catalog_item_pizza_options=CatalogItem::PIZZA_OPTIONS_st_st;
                    }


                    if ($menuItem->ext_code_st_big == $itemExternalId){
                        $stopListElement->catalog_item_pizza_options=CatalogItem::PIZZA_OPTIONS_st_big;
                    }


                    if ($menuItem->ext_code_big_st == $itemExternalId){
                        $stopListElement->catalog_item_pizza_options=CatalogItem::PIZZA_OPTIONS_big_st;
                    }



                    if ($menuItem->ext_code_big_big == $itemExternalId){
                        $stopListElement->catalog_item_pizza_options=CatalogItem::PIZZA_OPTIONS_big_big;
                    }

                  $returnArray[]=$stopListElement;
                }

            }

        }

        return $returnArray;
    }

    private static function validateZones(  $items):array {

echo var_dump($items);

        $returnArray = array();

        foreach ($items as $item){


            $restaurantId = (int)$item['restaurant_id'];
            $sumMin = (int)$item['sum_min'];
            $timeMin = (int)$item['time_min'];
            $timeMax = (int)$item['time_max'];
            $restaurantZoneId = (int)$item['id'];
            if ($restaurant = Restaurant::findOne(['external_id'=>$restaurantId])){


                $coords = trim((string)$item);

                $coordsArray = explode("\n", str_replace("\r", "", $coords)) ;

                $resultLngLatArray = array();

                foreach ($coordsArray as $coord){

                    $temp = explode(',',$coord);

                    $resultLngLatArray[]=$temp[1]." ".$temp[0];

                }


                $resultLngLatArray[]=$resultLngLatArray[0];
                $doneCoord = implode(", ", $resultLngLatArray);





                $newZone =new RestaurantZone();
                $newZone->restaurant_id= $restaurant->id;
                $newZone->min_order=(string)$sumMin;
                $newZone->max_time=(string)$timeMax;
                $newZone->min_time=(string)$timeMin;
                $newZone->zone_external_id=(string)$restaurantZoneId;
                $newZone->zone =new Expression("ST_GeomFromText('POLYGON(({$doneCoord}))',4326)");



                $returnArray['r_'.$restaurant->id][]=$newZone;


            }



        }


        return $returnArray;

    }

}
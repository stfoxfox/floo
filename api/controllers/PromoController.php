<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 25/12/2016
 * Time: 01:26
 */

namespace api\controllers;


use common\components\controllers\ApiController;
use common\components\MyExtensions\MyError;
use common\models\Promo;

class PromoController extends ApiController
{


    public function actionList(){


        $items =  Promo::find()->where('external_site_id is null')->orderBy('sort')->all();

        $returnArray = array();

        foreach ($items as $item){

            $returnArray[]= $item->getListJson();
        }



        return $this->sendResponse(['items'=>$returnArray]);
    }


    public function actionGetInfo($id){


        if ($item=Promo::findOne($id)){


            return $this->sendResponse(['item'=>$item->getFullJson()]);


        }

        return $this->sendError(MyError::BAD_REQUEST);


    }
}
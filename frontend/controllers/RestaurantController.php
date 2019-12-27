<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Restaurant;
use common\models\Region;
use common\models\Gallery;

class RestaurantController extends FrontendController
{
    public function actionIndex($city_id = null){

    	$regions = Region::find()->all();
    	if($city_id == null)
			$model = Restaurant::find()->all();
		else
			$model = Restaurant::find()->where([ 'region_id' => $city_id])->all();
		
		$images = Gallery::find()->all();
        return $this->render('index', [
        	'model' => $model,
        	'city' => Region::findOne($city_id),
			'regions' => $regions,
			'images' => $images
        ]);
                
    }

    public function actionView($id){

    	$restaurant = Restaurant::find()->one();

        return $this->render('view', [
        	'restaurant' => $restaurant
        ]);
                
    }
}
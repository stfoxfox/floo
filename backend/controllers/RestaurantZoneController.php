<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 23:57
 */

namespace backend\controllers;


use backend\models\forms\RestaurantZoneForm;
use common\components\controllers\BackendController;
use common\components\MyExtensions\MyHelper;
use common\models\Restaurant;
use common\models\RestaurantZone;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RestaurantZoneController extends BackendController
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

    public function actionItemDell(){
        $item_id = \Yii::$app->request->post('item_id');

        if($item_id){
            /** @var Restaurant $restaurant */
            if($restaurantZone = RestaurantZone::findOne(['id'=>$item_id])){
                if($restaurantZone->delete()){
                    return $this->sendJSONResponse(array('error'=>false,'item_id'=>$item_id));
                }
            }
        }
    }



    public function actionAdd($restaurant){

        if ($restaurant = Restaurant::findOne($restaurant)){
            $addForm = new RestaurantZoneForm();
            $addForm->restaurant_id = $restaurant->id;

            if ($addForm->load(\Yii::$app->request->post())){
                if ($restaurantZone = $addForm->createRestaurantZone()){
                    return $this->redirect(Url::toRoute(['restaurant/edit', 'id' => $restaurant->id]));
                }
            }
            $this->view->registerJsVar('zone', '');
            return $this->render('add',['addForm' => $addForm]);
        }
    }

    public function actionEdit($id){

        if ($restaurantZone = RestaurantZone::findOne($id)){
            $editForm = new RestaurantZoneForm();
            $editForm->loadFromItem($restaurantZone);

            if ($editForm->load(\Yii::$app->request->post())){
                if ($restaurantZone = $editForm->saveRestaurantZone($restaurantZone)){
                    return $this->redirect(Url::toRoute(['restaurant/edit', 'id' => $restaurantZone->restaurant_id]));
                }
            }

            $this->view->registerJsVar('zone', $editForm->zone);
            return $this->render('edit',['editForm' => $editForm]);
        }
    }

}
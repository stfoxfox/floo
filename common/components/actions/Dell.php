<?php

namespace common\components\actions;


use yii\web\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 16:17
 */
class Dell extends \yii\base\Action
{


    /**
     * Модель для удаления
     */
    public $_model;

    public function run()
    {

        \Yii::$app->response->format = 'json';

        $item_id = \Yii::$app->request->post('item_id');

        $model = $this->_model;

        if($item_id){

            if($item = $model::findOne($item_id)){


                $item->delete();



                return array('error'=>false,'item_id'=>$item_id);

            }
        }




        return array('error'=>true,);



    }


    protected function findModel($id)
    {

        $model = $this->_model;

        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
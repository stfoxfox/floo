<?php

namespace common\components\actions;


use yii\web\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 16:17
 */
class Sort extends \yii\base\Action
{


    /**
     * Модель для удаления
     */
    public $_model;

    public function run()
    {


        $model = $this->_model;

        \Yii::$app->response->format = 'json';

        $sort = \Yii::$app->request->post('sort_data');

        if($sort){
            $i=0;
            foreach($sort as $block_id){

                if (strlen($block_id)>0) {
                    $i++;
                    $model::updateAll(['sort' => $i], ['id' => $block_id]);

                }
            }

            return array('error'=>false,);


        } else{
            return array('error'=>true,);
        }




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
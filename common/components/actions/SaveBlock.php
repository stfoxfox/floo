<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/07/2017
 * Time: 23:22
 */

namespace common\components\actions;


use yii\base\Action;
use yii\web\BadRequestHttpException;

class SaveBlock extends Action
{

    public $_form;

    public $_views_map;


    public function run()
    {


        $formClass = $this->_form;

        $addForm = new $formClass();

        if ($addForm->load(\Yii::$app->request->post())){

            if ($item = $addForm->saveBlock()){


                return $this->controller->renderAjax($this->_views_map[$item->type],['item'=>$item]);



            }else
            {

                return $this->controller->sendJSONResponse($addForm->getErrors());
            }
        }

        throw  new BadRequestHttpException();







    }
}
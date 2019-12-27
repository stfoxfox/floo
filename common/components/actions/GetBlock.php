<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/07/2017
 * Time: 23:22
 */

namespace common\components\actions;


use yii\base\Action;

class GetBlock extends Action
{

    public $_form;

    public $_views_map;


    public function run()
    {

        $added_id=\Yii::$app->request->post('added_block_idx');
        $type_id=\Yii::$app->request->post('type_id');
        $parent_id=\Yii::$app->request->post('parent_id');




        $formClass = $this->_form;

        $addForm = new $formClass();
        $addForm->type=$type_id;
        $addForm->parent_id=$parent_id;



        return $this->controller->renderAjax($this->_views_map[$type_id],['added_id'=>$added_id,'addForm'=>$addForm,'type_id'=>$type_id]);






    }
}
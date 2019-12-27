<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/07/2017
 * Time: 23:46
 */

namespace common\components\actions;

use yii\base\Action;

class SaveBlockData extends Action
{

    public $_model;

    public function run()
    {
        $pk = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');
        $name = \Yii::$app->request->post('name');

        $model = $this->_model;

        if ($item = $model::findOne($pk)) {
            $item->$name = $value;
            $item->save();
        }
    }

}
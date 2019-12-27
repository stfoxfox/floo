<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 05/07/2017
 * Time: 00:05
 */

namespace common\components\actions;

use yii\base\Action;

class SaveBlockImage extends Action
{

    public $_form;
    public $_image_block_view = 'blocks/image-block';
    public $_model;

    public function run()
    {
        $formClass = $this->_form;

        $addForm = new $formClass();

        $addForm->load(\Yii::$app->request->post());

        if ($addForm->item_id) {
            $model = $this->_model;

            $item = $model::findOne($addForm->item_id);
            $addForm->saveItem($item);

            return $this->controller->renderAjax($this->_image_block_view, ['item' => $item]);
        }
    }

}
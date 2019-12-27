<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 05/07/2017
 * Time: 01:03
 */

namespace common\components\actions;

use common\components\MyExtensions\MyImagePublisher;
use yii\base\Action;

class BlockAddPicture extends Action
{

    public $_form;
    public $_model;
    public $related_model_path='page_block';

    public function run()
    {
        $formClass = $this->_form;
        $addPicture = new $formClass();

        if ($addPicture->load(\Yii::$app->request->post())) {

            if ($picture = $addPicture->createPicture()) {

                return $this->controller->sendJSONResponse(array(
                    'error' => false,
                    'replace_block' => false,
                    'picture_id' => $picture->id,
                    'save_url' => \yii\helpers\Url::toRoute(['save-image-data']),
                    'picture_thumb' => (new MyImagePublisher($picture))->thumbnail(100, 100,'file_name',$this->related_model_path),
                    'picture_src' => (new MyImagePublisher($picture))->getOriginalImage('file_name',$this->related_model_path)
                ));
            } elseif ($addPicture->image_id) {
                $model = $this->_model;
                $picture = $model::findOne($addPicture->image_id);

                return $this->controller->sendJSONResponse(array(
                    'error' => false,
                    'replace_block' => true,
                    'picture_id' => $picture->id,
                    'save_url' => \yii\helpers\Url::toRoute(['save-image-data']),
                    'picture_thumb' => (new MyImagePublisher($picture))->thumbnail(100, 100,'file_name',$this->related_model_path),
                    'picture_src' => (new MyImagePublisher($picture))->getOriginalImage('file_name',$this->related_model_path)
                ));
            }
        }
    }

}
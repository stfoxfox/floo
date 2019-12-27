<?php

namespace common\components\actions;

use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 02:33
 */
class Add extends \yii\base\Action
{
    /**
     * Форма для редактирования
     * @var \yii\base\Model
     */
    public $_form;

    public $_view  = "add";

    public $page_header = "Добавить элемент";

    public $breadcrumbs = [];

    public $_redirect = 'edit';

    /**
     * @param null $id
     * @return string|\yii\web\Response
     */
    public function run($id=null) {

        $this->controller->setTitleAndBreadcrumbs($this->page_header,$this->breadcrumbs);
        $formClass = $this->_form;
        $itemForm = new $formClass();

         if ($id) {
            $itemForm->parent_id = $id;
         }

        if ($itemForm->load(\Yii::$app->request->post()) && $item=$itemForm->create()) {
            return $this->controller->redirect(Url::toRoute([$this->_redirect,'id'=>$item->id]));
        }

        return $this->controller->render($this->_view,['formItem'=>$itemForm]);
    }

    protected function findModel($id) {
        $model = $this->_model;

        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
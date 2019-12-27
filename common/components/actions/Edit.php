<?php

namespace common\components\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class Edit
 * @package common\components\actions
 */

class Edit extends Action
{


    /**
     * Форма для редактирования
     * @var Model
     */
    public $_editForm;

    public $_model;


    public $_redirect='edit';


    public $_view ="edit";


    public $extra_params=array();
    /**
     * See Model::formName().
     * @var string
     */
    public $formName = null;

    /**
     * @var boolean
     */
    public $isJson = false;

    public $page_header="Изменение записи";

    public $title_column="title";

    public $breadcrumbs=array();


    public function run($id)
    {

        $model = $this->_model;

        if ( $item = $model::findOne($id)){


            $formClass = $this->_editForm;

            /* @var $itemForm Model */
            $itemForm = new $formClass();

            $title_column = $this->title_column;

            $this->controller->setTitleAndBreadcrumbs("{$this->page_header}: {$item->$title_column}",$this->breadcrumbs);



            if ($itemForm->load(Yii::$app->request->post()) && $itemForm->edit($item)){


                $redirect_path = (is_array($this->_redirect)?Url::toRoute($this->_redirect):Url::toRoute([$this->_redirect,'id'=>$item->id]));


                return $this->controller->redirect($redirect_path);
            }

            $itemForm->loadFromItem($item);

            return $this->controller->render($this->_view,ArrayHelper::merge(['formItem'=>$itemForm,'item'=>$item],$this->extra_params));

        }

        throw  new  NotFoundHttpException("Запись не найдена");


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
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 22/06/2017
 * Time: 13:18
 */

namespace backend\controllers;


use common\components\controllers\BackendController;
use common\models\Callback;
use backend\models\forms\CallbackForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class CallbackController extends  BackendController
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

    public function actionIndex(){


        $this->pageHeader = "Список заявок на звонок";



        $query = Callback::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('created_at DESC')
            ->all();

        return $this->render('index', [
            'callbacks' => $models,
            'pages' => $pages,
        ]);



    }

    public function actionClose($id){

        $callback = new CallbackForm();

        $callback->closeCallback($id);

        return $this->goBack();
    }

}
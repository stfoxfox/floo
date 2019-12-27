<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Promo;
use yii\filters\AccessControl;
use yii\helpers\Url;

class StockController extends FrontendController
{


    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [

    //                 [

    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    public function actionIndex(){

        $model=Promo::find()->where(['active' => true])->all();
        return $this->render('index', ['model' => $model]);

    }

    public function actionView($id){

        $model=Promo::findOne($id);
        return $this->render('view', ['model' => $model]);

    }
}
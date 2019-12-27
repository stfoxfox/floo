<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 16/12/2016
 * Time: 00:53
 */

namespace backend\controllers;


use backend\models\forms\PromoForm;
use common\components\controllers\BackendController;
use common\models\Promo;
use yii\filters\AccessControl;
use yii\helpers\Url;

class PromoController extends BackendController
{


    public $pageHeader= "Акции";


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


    public function  actionIndex(){



        $items = Promo::find()->orderBy('sort')->where(['active'=>true])->all();
        return $this->render("index",['promos'=>$items]);
    }


    public function actionEdit($id){


        $promo = Promo::findOne($id);

        if ($promo){

            $editForm = new PromoForm();

            if ($editForm->load(\Yii::$app->request->post())){

                $editForm->editPromo($promo);
                return $this->redirect(Url::toRoute(['edit','id'=>$promo->id]));

            }else{
                $editForm->loadFormItem($promo);
                return $this->render('edit',['editForm'=>$editForm,'item'=>$promo]);
            }
        }
    }


    public function actionAddItem(){

        $addForm = new PromoForm();


        if ($addForm->load(\Yii::$app->request->post())){

            if ($addForm->createPromo()){

                return $this->redirect(Url::toRoute('index'));
            }


        }
        return $this->render('add-item',['addForm'=>$addForm]);

    }


    public function actionItemDell(){

        $item_id= \Yii::$app->request->post('item_id');


        if (Promo::deleteAll(['id'=>$item_id])>0){
            return $this->sendJSONResponse(array('error'=>false,'item_id'=>$item_id));
        }

        return  $this->sendJSONResponse(array('error'=>true));

    }


    public function actionItemSort(){


        $sort = \Yii::$app->request->post('item_order');

        if($sort){
            $i=0;
            foreach($sort as $item_id){
                $i++;
                Promo::updateAll(['sort'=>$i],['id'=>$item_id]);


            }

            return  $this->sendJSONResponse(array('error'=>false));


        }


        return  $this->sendJSONResponse(array('error'=>true));



    }

}
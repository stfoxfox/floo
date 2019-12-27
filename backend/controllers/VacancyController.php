<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/11/2017
 * Time: 10:23
 */

namespace backend\controllers;


use backend\models\forms\VacancyForm;
use common\components\controllers\BackendController;
use common\models\Vacancy;
use yii\filters\AccessControl;
use yii\helpers\Url;

class VacancyController extends BackendController
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


    public function  actionIndex(){



        $items = Vacancy::find()->orderBy('sort')->all();
        return $this->render("index",['items'=>$items]);
    }


    public function actionEdit($id){


        $promo = Vacancy::findOne($id);

        if ($promo){

            $editForm = new VacancyForm();

            if ($editForm->load(\Yii::$app->request->post())){

                $editForm->edit($promo);
                return $this->redirect(Url::toRoute(['edit','id'=>$promo->id]));

            }else{
                $editForm->loadFormItem($promo);
                return $this->render('edit',['editForm'=>$editForm,'item'=>$promo]);
            }
        }
    }


    public function actionAddItem(){

        $addForm = new VacancyForm();


        if ($addForm->load(\Yii::$app->request->post())){

            if ($addForm->create()){

                return $this->redirect(Url::toRoute('index'));
            }


        }
        return $this->render('add-item',['addForm'=>$addForm]);

    }


    public function actionItemDell(){

        $item_id= \Yii::$app->request->post('item_id');


        if (Vacancy::deleteAll(['id'=>$item_id])>0){
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
                Vacancy::updateAll(['sort'=>$i],['id'=>$item_id]);


            }

            return  $this->sendJSONResponse(array('error'=>false));


        }


        return  $this->sendJSONResponse(array('error'=>true));



    }


}
<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:14
 */

namespace backend\controllers;


use backend\models\forms\ModificatorForm;
use backend\models\forms\ModificatorItemImageForm;
use common\components\controllers\BackendController;
use common\models\CatalogItemModificator;
use common\models\ModificatorItemImage;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;

class ModificatorController extends BackendController
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

    public function actions(){
        return [
            'gallery-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => ModificatorItemImage::className(),
            ],
            'dell-gallery-item' => [
                'class' => 'common\components\actions\Dell',
                '_model' => ModificatorItemImage::className(),
            ],
            'save-image-data' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => ModificatorItemImage::className(),
            ],
        ];
    }



    public function actionItemEditExtCode(){

        $item_id = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');


        if ($item = CatalogItemModificator::findOne($item_id)){

            $item->ext_code=$value;

            if ($item->save()){
                return $this->sendJSONResponse(array('error'=>false));
            }
        }

        return $this->sendJSONResponse(array('error'=>true));
    }


    public function actionItemEditTitle(){

        $item_id = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');


        if ($item = CatalogItemModificator::findOne($item_id)){

            $item->title=$value;

            if ($item->save()){
                return $this->sendJSONResponse(array('error'=>false));
            }
        }

        return $this->sendJSONResponse(array('error'=>true));
    }


    public function actionItemEditIcon(){

        $item_id = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');


        if ($item = CatalogItemModificator::findOne($item_id)){

            $item->icon=$value;

            if ($item->save()){
                return $this->sendJSONResponse(array('error'=>false));
            }
        }

        return $this->sendJSONResponse(array('error'=>true));
    }


    public function actionItemEditPrice(){

        $item_id = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');


        if ($item = CatalogItemModificator::findOne($item_id)){

            $item->price=$value;

            if ($item->save()){
                return $this->sendJSONResponse(array('error'=>false));
            }
        }

        return $this->sendJSONResponse(array('error'=>true));
    }

    public function actionItemEditActive(){

        $item_id = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');

        if ($item = CatalogItemModificator::findOne($item_id)){
            $item->active = $value;
            if ($item->save()){
                return $this->sendJSONResponse(array('error'=>false));
            }
        }

        return $this->sendJSONResponse(array('error'=>true));
    }

    public function actionItemDell(){

       $item_id= \Yii::$app->request->post('item_id');


        if (CatalogItemModificator::deleteAll(['id'=>$item_id])>0){
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
                CatalogItemModificator::updateAll(['sort'=>$i],['id'=>$item_id]);


            }

            return  $this->sendJSONResponse(array('error'=>false));


        }


        return  $this->sendJSONResponse(array('error'=>true));



    }



    public function actionIndex($sort = null){


        $this->pageHeader="Управление Модификаторами";

        $modificatorsList = CatalogItemModificator::find();

        if($sort == null){
            $modificatorsList = $modificatorsList->orderBy('sort')->all();
        }else if($sort == 'name'){
            $modificatorsList = $modificatorsList->orderBy('title')->all();   
        }else if($sort == 'active'){
            $modificatorsList = $modificatorsList->orderBy(['active' => SORT_DESC])->all();
        }else if($sort == 'inactive'){
            $modificatorsList = $modificatorsList->andWhere(['active' => false])->all();
        }


        return $this->render('index',['modificatorsList'=>$modificatorsList]);
    }

    public function actionInactive(){
        CatalogItemModificator::updateAll(['active' => false]);
        
        return $this->redirect(['index']);
    }

    public function actionActive(){
        CatalogItemModificator::updateAll(['active' => true]);
        
        return $this->redirect(['index']);
    }

    public function actionAddItem(){

        $this->pageHeader="Добавить Модификатор";

        $addForm = new ModificatorForm();

        if($addForm->load(\Yii::$app->request->post())){
            if($newCategory= $addForm->createModificator()){
                return $this->redirect(Url::toRoute(['index']));
            }
        }

        return $this->render('add-item',['addForm'=>$addForm]);
    }

    public function actionEditItem($id){
        $modificator = CatalogItemModificator::findOne($id);
        if ($modificator){
            $editForm = new ModificatorForm();
            if ($editForm->load(\Yii::$app->request->post())){
                $editForm->editModificator($modificator);
                return $this->redirect(Url::toRoute(['index']));
            }else{
                $editForm->loadFromItem($modificator);
                return $this->render('edit-item',['editForm'=>$editForm,'item'=>$modificator]);
            }
        }
    }    

    public function actionManageGallery($id)
    {
        $item = CatalogItemModificator::findOne($id);
        if ($item) {
            $addPictureForm = new ModificatorItemImageForm();
            $addPictureForm->item_id = $item->id;

            $this->pageHeader = "Управление галереей";
            return $this->render('manage-gallery', ['item' => $item, 'addPictureForm' => $addPictureForm]);
        }

        throw new NotFoundHttpException("Запись не найдена");
    }


    public function actionGalleryAddPicture(){
        $addPicture = new ModificatorItemImageForm();

        if ($addPicture->load(\Yii::$app->request->post())) {
            if ($picture = $addPicture->createPicture()) {
                return $this->sendJSONResponse(array(
                    'error' => false,
                    'replace_block' => false,
                    'picture_id' => $picture->id,
                    'save_url' => \yii\helpers\Url::toRoute(['save-image-data']),
                    'picture_thumb' => (new MyImagePublisher($picture))->MyThumbnail(100, 100),
                    'picture_src' => (new MyImagePublisher($picture))->getOriginalImage('file_name')
                ));
            } else if ($addPicture->image_id) {
                $picture = ModificatorItemImage::findOne($addPicture->image_id);

                return $this->sendJSONResponse(array(
                    'error' => false,
                    'replace_block' => true,
                    'picture_id' => $picture->id,
                    'save_url' => \yii\helpers\Url::toRoute(['save-image-data']),
                    'picture_thumb' => (new MyImagePublisher($picture))->MyThumbnail(100, 100),
                    'picture_src' => (new MyImagePublisher($picture))->getOriginalImage('file_name')
                ));
            }
        }
    }
}
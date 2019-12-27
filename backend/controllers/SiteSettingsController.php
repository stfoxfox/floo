<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 13:58
 */
namespace backend\controllers;
use backend\models\forms\OrganisationEditForm;
use common\components\controllers\BackendController;
use common\models\Organisation;
use common\models\Tag;
use yii\filters\AccessControl;
use yii\helpers\Url;
class SiteSettingsController extends BackendController
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
        $this->pageHeader="Настройки сайта";
        $tags = Tag::find()->orderBy('sort')->all();
        $organisations = Organisation::find()->all();
        return $this->render('index',['tags'=>$tags,'organisations'=>$organisations]);
    }
    public function actionAddOrganisation(){
        $title = \Yii::$app->request->post('title');
        if( $title){
            $organisation = new Organisation();
            $organisation->title=$title;
            if($organisation->save())
                return $this->sendJSONResponse(array('error'=>false,'tag_title'=>$organisation->title,'tag_id'=>$organisation->id));
        }
        return $this->sendJSONResponse(array('error'=>true));
    }
    public function actionTagSort(){
        $sort = \Yii::$app->request->post('tag_order');
        if($sort){
            $i=0;
            foreach($sort as $tag_id){
                $i++;
                Tag::updateAll(['sort'=>$i],['id'=>$tag_id]);
            }
            return  $this->sendJSONResponse(array('error'=>false));
        }
        return  $this->sendJSONResponse(array('error'=>true));
    }
    public function actionEditOrganisation($id){
        if ($organisation = Organisation::findOne($id)){
            $editForm = new OrganisationEditForm();
            if (\Yii::$app->request->isPost && $editForm->load(\Yii::$app->request->post())){
                if ($editForm->saveItem($organisation)){
                    return $this->redirect(Url::toRoute(['edit-organisation','id'=>$organisation->id]));
                }
            }
            else{
                $editForm->loadFormModel($organisation);
                return $this->render('edit-organisation',['editForm'=>$editForm]);
            }
        }
    }
    public function actionTagDell(){
            $tag_id = \Yii::$app->request->post('tag_id');
            if($tag_id){
                /** @var Tag $tag */
                if($tag = Tag::findOne(['id'=>$tag_id])){
                    if($tag->delete()){
                        return $this->sendJSONResponse(array('error'=>false,'tag_id'=>$tag_id));
                    }
                }
            }
            return $this->sendJSONResponse(array('error'=>true));
    }
    public function actionOrganisationDell(){
            $organisation_id = \Yii::$app->request->post('tag_id');
            if($organisation_id){
                /** @var Tag $tag */
                if($organisation = Organisation::findOne(['id'=>$organisation_id])){
                    if($organisation->delete()){
                        return $this->sendJSONResponse(array('error'=>false,'tag_id'=>$organisation_id));
                    }
                }
            }
            return $this->sendJSONResponse(array('error'=>true));
    }
    public function actionAddTag(){
        $title = \Yii::$app->request->post('title');
        if( $title){
            $tag = new Tag();
            $tag->tag=$title;
            if($tag->save())
                return $this->sendJSONResponse(array('error'=>false,'tag_title'=>$tag->tag,'tag_id'=>$tag->id));
        }
        return $this->sendJSONResponse(array('error'=>true));
    }
}
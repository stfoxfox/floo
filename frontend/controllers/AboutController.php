<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\BaseModels\RestaurantBase;
use common\models\BaseModels\ReviewBase;
use common\models\Region;
use common\models\Restaurant;
use common\models\Vacancy;
use frontend\models\forms\ReviewForm;
use frontend\models\forms\VacancyForm;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class AboutController extends FrontendController
{
    public function actionIndex(){

        return $this->render('index');
                
    }

    public function actionPayment(){
        return $this->render('payment');
    }

    public function actionMenu(){

        return $this->render('menu');
                
    }

    public function actionPartners(){

        return $this->render('partners');
                
    }

    public function actionDiscount(){

        return $this->render('discount');
                
    }

    public function actionReviews(){

        $reviewForm = new ReviewForm();


        if ($reviewForm->load(Yii::$app->request->post()) ) {
            $restaurant = Restaurant::find()->one();
            $reviewForm->restaurant_id = $restaurant->id;
            
            if($reviewForm->submit()){
                return $this->refresh();
            }           
        }
        
        // $reviews = ReviewBase::find()->where(['is_active'=>true])->orderBy('created_at')->all();
        $restaurantList = ArrayHelper::map(RestaurantBase::find()->where(['is_active' => true])->all(), 'id', 'address');
        $query = ReviewBase::find()->where(['is_active'=>true]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('created_at DESC')
            ->all();


        return $this->render('reviews',['reviewForm'=>$reviewForm,'pages'=>$pages,'reviews'=>$models, 'restaurantList' => $restaurantList]);
                
    }

    public function actionVacancies($region = null){



        $regions = Region::find()->orderBy('sort')->all();

        if (!isset($region)){

            $region= $regions[0]->id;

        }

        $vacancies= Vacancy::find()->where(['id'=>(new Query())
            ->select(['vacancy_id'])
            ->from('vacancy_restaurant_link')
            ->where(['restaurant_id'=>(new Query())->select('id')->from('restaurant')->where(['region_id'=>$region])])])->orderBy('sort')->with(['restaurants'])->all();


        $form = new VacancyForm();



        if ($form->load(Yii::$app->request->post()) && $form->submit()) {
            return $this->refresh();
        }



        return $this->render('vacancies', ['active_region' => $region,'regions'=>$regions,'vacancies'=>$vacancies,'vForm'=>$form]);
                
    }

    public function actionContacts(){

        return $this->render('contacts');
                
    }
}
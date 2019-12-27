<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use common\models\CatalogItemModificator;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;

class MenuController extends FrontendController
{
    public function actionIndex(){



        return $this->render('index');
                
    }
    
    public function actionDish($alias = null, $tag = null){

        if(ctype_digit($alias))
            $categoryObj=CatalogCategory::findOne($alias);
        else
            $categoryObj=CatalogCategory::find()->where(['alias' => $alias])->one();
        $categoryObj->tag = $tag;
        switch ($alias) {
            case 'pizza':
                return $this->render('pizza',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            case 'paste':
                return $this->render('paste',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            case 'dessert':
                return $this->render('dessert',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            case 'hot':
                return $this->render('hot',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            case 'snacks':
                return $this->render('snacks',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            case 'soup':
                return $this->render('soup',['category'=>$categoryObj, 'alias' => $alias]);
                break;
            
            default:
                return $this->render('other',['category'=>$categoryObj, 'alias' => $alias]);
                break;
        }
        
    }

    public function actionAll(){
        $query = CatalogItem::find()->where(['active'=>true,'in_basket_page'=>false])->andWhere('category_id is not null');
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize'=>24
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
           ->all();

        return $this->render('all', [
            'catalogItems' => $models,
            'pages' => $pages,
        ]);



    }

    public function actionProduct($id){

        $product=CatalogItem::find()->where(['id' => $id])->one();

        // if($product->category->alias == 'pizza')
        //     return $this->render('view_pizza',['product'=>$product]);
        // else
        //     return $this->render('view',['product'=>$product]);

        if(empty($product->price_st_st)){
            return $this->render('view',['product'=>$product]);
        }else{
            return $this->render('view_pizza',['product'=>$product]);
        }
        
    }

    public function actionChildren(){

        return $this->render('children');

    }

    public function actionModificator($id){
        $modificator = CatalogItemModificator::findOne($id);
        if($modificator){
            return $this->render('modificator',['product'=>$modificator]);
        }
    }

    public function actionModificators(){
        $modificators = CatalogItemModificator::find()->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
        return $this->render('modificators', ['modificators' => $modificators]);
    }

}
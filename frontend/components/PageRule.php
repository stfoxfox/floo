<?php

namespace frontend\components;

use Yii;
use yii\web\UrlRuleInterface;
use common\models\CatalogCategory;
use common\models\CatalogItem;


class PageRule implements UrlRuleInterface {

    public function createUrl($manager, $route, $params){
        if($route == 'restaurant/index'){
            return 'forbusiness.html';
        }else if($route == 'restaurant/view' && isset($params['id'])){
            return 'address.html';
        }else if($route == 'menu/dish' && isset($params['alias'])){
            $category = CatalogCategory::findOne(['alias' => $params['alias']]);
            if($category !== null){
                $url = '/catalog/category/'.$category->alias.".html";
                if(isset($params['tag'])){
                    return $url."?tag=".$params['tag'];
                }
                return $url;
            }
        }else if($route == 'menu/product' && isset($params['id'])){
            // $product = CatalogItem::findOne($params['id']);
            //if($product !== null){
            return '/catalog/product/'.$params['id'].'.html';
            //}
        }

        return false;
    }

    public function parseRequest($manager, $request){
        $urlString = trim($request->pathInfo, '/');
        $urlArray = explode("/", $urlString);

        if($urlString == 'forbusiness.html'){
            return ['restaurant/index', []];
        }else if($urlString == 'address.html'){
            return ['restaurant/view', ['id' => 1]];
        }

        if($urlString !== '' && count($urlArray) == 3){            
            $item = str_replace('.html', '', end($urlArray));
            if($urlArray[1] == 'category'){                
                $category = CatalogCategory::findOne(['alias' => $item]);
                if($category !== null){
                    return ['menu/dish', ['alias' => $category->alias]];
                }
            }else if($urlArray[1] == 'product'){
                $product = CatalogItem::findOne($item);
                if($product !== null){
                    return ['menu/product', ['id' => $product->id]];
                }
            }
        }
        return false;
    }
}
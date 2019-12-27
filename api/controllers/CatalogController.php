<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 01:09
 */

namespace api\controllers;


use common\components\controllers\ApiController;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use common\models\Tag;
use yii\db\Query;

class CatalogController extends ApiController
{




    public function actionGetCategories(){

        $categoryList = CatalogCategory::find()->where(['show_in_app'=>true])->orderBy('sort')->all();


        $returnArray= array();

        /**
         * @var CatalogCategory $item
         */
        foreach ($categoryList as $item) {

            $returnArray[]= $item->getJson();


        }

        return $this->sendResponse(['items'=>$returnArray]);

    }

    public function actionGetItemsByIds($ids){


        $ids_array = explode(',',$ids);


        $items = CatalogItem::find()
            ->where(['catalog_item.id'=>$ids_array,'catalog_item.active'=>true])
            ->andWhere(['not in','id',(new Query())
            ->select('catalog_item_modificator_count_link.catalog_item_id')
            ->from('catalog_item_modificator_count_link')
            ->where(['catalog_item_modificator_count_link.catalog_item_modificator_id'=>
                (new Query())
                    ->select('catalog_item_modificator.id')
                    ->from('catalog_item_modificator')
                    ->where(['catalog_item_modificator.active'=>false])])


        ])->orderBy('sort')->all();

        $itemsArray = array();
        /**
         * @var CatalogItem $item
         */
        foreach ($items as $item){

            $itemsArray[]=$item->getJson();
        }

        return $this->sendResponse(array(
            'items'=>$itemsArray,

        ));


    }

    public function actionGetItems($category_id,$tag_id=null){

        if ($category = CatalogCategory::findOne($category_id)){

            $items_query = $category->getCatalogItems()->with(['catalogItemModificatorCountLinks','catalogItemModificatorCountLinks.modificator'])->andWhere(['catalog_item.active'=>true]);

            if (isset($tag_id)){
                $items_query->andWhere(['id'=>(new Query())->select('catalog_item_id')->from('catalog_item_tag_link')->where(['tag_id'=>$tag_id])]);

            }


            $items_query->andWhere(['not in','id',(new Query())
                ->select('catalog_item_modificator_count_link.catalog_item_id')
                ->from('catalog_item_modificator_count_link')

                ->where(['catalog_item_modificator_count_link.catalog_item_modificator_id'=>
                    (new Query())
                        ->select('catalog_item_modificator.id')
                        ->from('catalog_item_modificator')
                        ->where(['catalog_item_modificator.active'=>false])])


            ]);




            $items = $items_query->orderBy('sort')->all();
            $itemsArray = array();
            /**
             * @var CatalogItem $item
             */
            foreach ($items as $item){

                $itemsArray[]=$item->getJson();
            }


            $tags = Tag::find()->joinWith('catalogItems')->where(['catalog_item.category_id'=>$category->id])->andWhere(['not in','catalog_item.id',(new Query())
                ->select('catalog_item_modificator_count_link.catalog_item_id')
                ->from('catalog_item_modificator_count_link')

                ->where(['catalog_item_modificator_count_link.catalog_item_modificator_id'=>
                    (new Query())
                        ->select('catalog_item_modificator.id')
                        ->from('catalog_item_modificator')
                        ->where(['catalog_item_modificator.active'=>false])])


            ])
            ->orderBy('sort')->all();
            $tagsArray = array();
            foreach ($tags as $tag){

                $tagsArray[]=$tag->getJson();
            }


            return $this->sendResponse(array(
                'items'=>$itemsArray,
                'tags'=>$tagsArray,
            ));



        }

        return $this->sendError();
    }

}
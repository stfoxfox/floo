<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 00:57
 */

namespace common\models;


use common\models\BaseModels\CatalogCategoryBase;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class CatalogCategory extends CatalogCategoryBase
{


    public $tag;


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'sort' => 'Sort',
            'show_in_app' => 'Отображать категорию в приложении',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'alias' => 'Название в адресной строке',
            'is_active' => 'Активна',
            'is_main_page' => 'Выводить на главную страницу'
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItems()
    {
        if($this->tag != null )
            return $this->hasMany(CatalogItem::className(), ['category_id' => 'id'])
                ->joinWith(['tags'])->where('tag = :tag', [':tag' => $this->tag])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC]);
        else
            return $this->hasMany(CatalogItem::className(), ['category_id' => 'id'])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC]);;
    }


    public function getJson(){

        $returnArray = array(
            'id'=>$this->id,
            'title'=>$this->title,

        );

        return $returnArray;

    }

    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }


    public static function findLastUpdatedAtProductOrProductGroup() {
        $productGroupLastUpdatedAt = (new Query())->select('max(updated_at)')->from('catalog_category')->one();
        $productGroupLastUpdatedAt= $productGroupLastUpdatedAt['max'];



        $productLastUpdatedAt = (new Query())->select('max(updated_at)')->from('catalog_item')->one();
        $productLastUpdatedAt= $productLastUpdatedAt['max'];



        if (strtotime($productGroupLastUpdatedAt) > strtotime($productLastUpdatedAt)) {
            $lastUpdatedAt = $productGroupLastUpdatedAt;
        } else {
            $lastUpdatedAt = $productLastUpdatedAt;
        }

        return date('Y-m-d H:i', strtotime($lastUpdatedAt));
    }

    public function getTags()
    {
        return Tag::find()->joinWith(['catalogItems'])->where(['category_id'=>$this->id])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
        //return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('catalog_item_tag_link', ['catalog_item_id' => 'id'])->viaTable('catalog_item', ['category_id' => 'id']);
    }

}
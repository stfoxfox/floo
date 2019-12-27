<?php
namespace common\models;

use common\components\MyExtensions\MyImagePublisher;
use common\models\BaseModels\CatalogItemBase;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "catalog_item".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $sort
 * @property string $file_name
 * @property string $ext_code
 * @property integer $category_id
 * @property boolean $active
 * @property string $created_at
 * @property string $updated_at
 * @property double $price
 * @property double $price_st_st
 * @property double $price_big_st
 * @property double $price_st_big
 * @property double $price_big_big
 * @property double $ext_code_st_st
 * @property double $ext_code_big_st
 * @property double $ext_code_st_big
 * @property double $ext_code_big_big
 * @property string $css_class
 * @property boolean $is_main_page
 * @property boolean $in_basket_page
 */
class CatalogItem extends CatalogItemBase
{
    const PIZZA_OPTIONS_NONE=0;
    const PIZZA_OPTIONS_st_st=1;
    const PIZZA_OPTIONS_big_st=2;

    const PIZZA_OPTIONS_st_big=3;
    const PIZZA_OPTIONS_big_big=4;




    public function uploadTo($attribute){

        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/catalog_items/{$this->category_id}/{$this->$attribute}";
        else
            return null;


    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStopListElements()
    {
        return $this->hasMany(StopListElement::className(), ['catalog_item_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'category_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemModificators()
    {
        return $this->hasMany(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id'])->viaTable('catalog_item_modificator_link', ['catalog_item_id' => 'id']);
    }

    public function getCatalogItemModificatorCounts(){
        return $this->hasMany(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id'])
            ->viaTable('catalog_item_modificator_count_link', ['catalog_item_id' => 'id']);
    }

    public function getCatalogItemModificatorCountLinks(){
        return $this->hasMany(CatalogItemModificatorCountLink::className(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModificators()
    {
        return $this->hasMany(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id'])->viaTable('catalog_item_modificator_link', ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveModificators()
    {
        return $this->hasMany(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id'])->viaTable('catalog_item_modificator_link', ['catalog_item_id' => 'id'])->andWhere(['active'=>true]);
    }


    public function getOrderedModificators(){

        return $this->hasMany(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id'])->viaTable('catalog_item_modificator_link', ['catalog_item_id' => 'id'])->select(['*',


            'is_default'=>
                new Expression('EXISTS(SELECT * FROM "catalog_item_modificator_count_link" WHERE ("catalog_item_modificator_count_link"."catalog_item_id"=:item_id) AND (catalog_item_modificator_count_link.catalog_item_modificator_id = catalog_item_modificator.id))',
                    ['item_id'=>$this->id]

                    )
        ])->orderBy('is_default DESC')->where(['active'=>true]);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromos()
    {
        return $this->hasMany(Promo::className(), ['id' => 'promo_id'])->viaTable('catalog_item_promo_link', ['catalog_item_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('catalog_item_tag_link', ['catalog_item_id' => 'id']);
    }

    public function getJson(){

        $returnObj = array(
            'id'=>$this->id,
            'title'=>$this->title,
        );
        if ($this->description){

            $returnObj['description']=$this->description;
        }

        if ($this->file_name){

            $returnObj['image_url']=(new MyImagePublisher($this))->MyThumbnail(512,512);
            $returnObj['full_image_url']=(new MyImagePublisher($this))->MyThumbnail(1024,1024);
        }

        if ($this->price){
            $returnObj['price']=$this->price;
        }

        if ($this->price_st_st){
            $returnObj['pizza_options']['price_st_st']=$this->price_st_st;

        }

        if ($this->price_big_st){
            $returnObj['pizza_options']['price_big_st']=$this->price_big_st;

        }
        if ($this->price_st_big){
            $returnObj['pizza_options']['price_st_big']=$this->price_st_big;

        }

        if ($this->price_big_big){
            $returnObj['pizza_options']['price_big_big']=$this->price_big_big;

        }

        if ($this->packing_weights){
            $returnObj['packing_weights'] = $this->packing_weights;
        }

        $modificatorsArray = array();
        if ($this->orderedModificators){

            /**
             * @var CatalogItemModificator $modificator
             */
            foreach ($this->orderedModificators as $modificator){

                $modificatorsArray[]= $modificator ->getJson();
            }

        }

        $catalogModificatorArray = [];
        if($this->catalogItemModificatorCountLinks){
            /**
             * @var CatalogItemModificatorCountLink $modificatorCount
             */
            foreach($this->catalogItemModificatorCountLinks as $modificatorCount){
                $catalogModificatorArray[] = [
                    'modificator' => $modificatorCount->modificator->getJson(),
                    'count' => $modificatorCount->count
                ];
            }
        }

        $returnObj['modificators']= $modificatorsArray;
        $returnObj['start_modificators'] = $catalogModificatorArray;

        return $returnObj;

    }

    public static function getItemsForSelect(){
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

}
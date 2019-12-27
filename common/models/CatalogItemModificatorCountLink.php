<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:11
 */

namespace common\models;


use common\models\BaseModels\CatalogItemModificatorCountLinkBase;
use yii\helpers\ArrayHelper;

class CatalogItemModificatorCountLink extends CatalogItemModificatorCountLinkBase
{
    public function getModificator(){
        return $this->hasOne(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id']);
    }

    public function getCatalogItem(){
        return $this->hasOne(CatalogItem::className(), ['id' => 'catalog_item_id']);
    }

    public static function getItemsForSelect($catalogItemID){
        $modificators = CatalogItemModificator::find()->where([
            'NOT IN', 
            'id', 
            CatalogItemModificatorCountLink::find()->select('catalog_item_modificator_id')->where(['catalog_item_id' => $catalogItemID])
        ])->orderBy('title')->all();

        return ArrayHelper::map($modificators, 'id', 'title');
    }
}
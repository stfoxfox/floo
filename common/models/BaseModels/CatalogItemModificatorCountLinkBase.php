<?php

namespace common\models\BaseModels;

use Yii;
use common\models\CatalogItem;
use common\models\CatalogItemModificator;

/**
 * This is the model class for table "catalog_item_modificator_count_link".
 *
 * @property integer $catalog_item_modificator_id
 * @property integer $catalog_item_id
 * @property integer $count
 * @property string $created_at
 * @property string $updated_at
 */
class CatalogItemModificatorCountLinkBase extends \common\components\MyExtensions\MyActiveRecord
{
    public $file_name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_modificator_count_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_item_modificator_id', 'catalog_item_id'], 'required'],
            [['catalog_item_modificator_id', 'catalog_item_id', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'catalog_item_modificator_id' => 'Catalog Item Modificator ID',
            'catalog_item_id' => 'Catalog Item ID',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCatalogItemModificator(){
        return $this->hasOne(CatalogItemModificator::className(), ['id' => 'catalog_item_modificator_id']);
    }

    public function getCatalogItem(){
        return $this->hasOne(CatalogItem::className(), ['id' => 'catalog_item_id']);
    }
}

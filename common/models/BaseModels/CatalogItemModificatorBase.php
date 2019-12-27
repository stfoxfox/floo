<?php

namespace common\models\BaseModels;

use Yii;
use common\models\ModificatorItemImage;

/**
 * This is the model class for table "catalog_item_modificator".
 *
 * @property integer $id
 * @property string $title
 * @property double $price
 * @property string $icon
 * @property string $ext_code
 * @property boolean $active
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 */
class CatalogItemModificatorBase extends \common\components\MyExtensions\MyActiveRecord
{
    public $file_name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_modificator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price', 'ext_code', 'photo'], 'required'],
            [['price'], 'number'],
            [['active'], 'boolean'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at', 'photo', 'description'], 'safe'],
            [['title', 'icon', 'ext_code', 'video_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'icon' => 'Icon',
            'ext_code' => 'Ext Code',
            'active' => 'Active',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'description' => 'Description',
            'photo' => 'Photo',
            'video_link' => 'Video Link'
        ];
    }

    public function getModificatorItemImages()
    {
        return $this->hasMany(ModificatorItemImage::className(), ['modificator_item_id' => 'id']);
    }
}

<?php

namespace common\models\BaseModels;

use Yii;

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
 * @property string $packing_weights
 * @property string $ext_code_st_st
 * @property string $ext_code_big_st
 * @property string $ext_code_st_big
 * @property string $ext_code_big_big
 * @property string $css_class
 * @property boolean $is_main_page
 * @property boolean $in_basket_page
 */
class CatalogItemBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['sort', 'category_id'], 'integer'],
            [['active', 'is_main_page', 'in_basket_page'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['price', 'price_st_st', 'price_big_st', 'price_st_big', 'price_big_big'], 'number'],
            [['title', 'file_name', 'ext_code', 'packing_weights', 'ext_code_st_st', 'ext_code_big_st', 'ext_code_st_big', 'ext_code_big_big', 'css_class'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'sort' => 'Sort',
            'file_name' => 'File Name',
            'ext_code' => 'Ext Code',
            'category_id' => 'Category ID',
            'active' => 'Active',
            'is_main_page' => 'Is Main Page',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'price' => 'Price',
            'price_st_st' => 'Price St St',
            'price_big_st' => 'Price Big St',
            'price_st_big' => 'Price St Big',
            'price_big_big' => 'Price Big Big',
            'packing_weights' => 'Packing Weights',
            'ext_code_st_st' => 'Ext Code St St',
            'ext_code_big_st' => 'Ext Code Big St',
            'ext_code_st_big' => 'Ext Code St Big',
            'ext_code_big_big' => 'Ext Code Big Big',
            'css_class' => 'Css class',
            'in_basket_page' => 'In Basket Page'
        ];
    }
}

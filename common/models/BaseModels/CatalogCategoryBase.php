<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "catalog_category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 * @property boolean $show_in_app
 * @property string $created_at
 * @property string $updated_at
 * @property string $alias
 */
class CatalogCategoryBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['show_in_app', 'is_active', 'is_main_page'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            ['title', 'string', 'max' => 75],
            ['alias', 'string', 'max' => 255],
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
            'sort' => 'Sort',
            'show_in_app' => 'Show In App',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'alias' => 'Url Alias',
            'is_active' => 'Is Active',
            'is_main_page' => 'Is Main Page'
        ];
    }
}

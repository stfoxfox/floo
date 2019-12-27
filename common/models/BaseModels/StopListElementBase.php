<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "stop_list_element".
 *
 * @property integer $restaurant_id
 * @property integer $catalog_item_id
 * @property integer $catalog_item_pizza_options
 * @property string $created_at
 * @property string $updated_at
 */
class StopListElementBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stop_list_element';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'catalog_item_id', 'catalog_item_pizza_options'], 'required'],
            [['restaurant_id', 'catalog_item_id', 'catalog_item_pizza_options'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'restaurant_id' => 'Restaurant ID',
            'catalog_item_id' => 'Catalog Item ID',
            'catalog_item_pizza_options' => 'Catalog Item Pizza Options',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

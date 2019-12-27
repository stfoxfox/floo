<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "cart_item".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $catalog_item_id
 * @property integer $catalog_item_pizza_options
 * @property integer $count
 * @property string $created_at
 * @property string $updated_at
 */
class CartItemBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'catalog_item_id', 'catalog_item_pizza_options', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'catalog_item_id' => 'Catalog Item ID',
            'catalog_item_pizza_options' => 'Catalog Item Pizza Options',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

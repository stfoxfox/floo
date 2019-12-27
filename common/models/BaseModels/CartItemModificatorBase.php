<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "cart_item_modificator".
 *
 * @property integer $cart_item_id
 * @property integer $modificator_id
 * @property integer $count
 * @property string $created_at
 * @property string $updated_at
 */
class CartItemModificatorBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_item_modificator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_item_id', 'modificator_id', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cart_item_id' => 'Cart Item ID',
            'modificator_id' => 'Modificator ID',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property double $order_summ
 * @property string $created_at
 * @property string $updated_at
 */
class CartBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id'], 'integer'],
            [['order_summ'], 'number'],
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
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'order_summ' => 'Order Summ',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

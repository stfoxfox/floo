<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $address_id
 * @property integer $gift_id
 * @property integer $order_source
 * @property string $address
 * @property string $entrance
 * @property string $floor
 * @property string $flat
 * @property double $lat
 * @property double $lng
 * @property integer $points_number
 * @property integer $discount
 * @property integer $status
 * @property string $payment_id
 * @property integer $payment_type
 * @property string $phone
 * @property string $client_comment
 * @property string $operator_comment
 * @property string $change_sum
 * @property double $payment_summ
 * @property double $order_summ
 * @property integer $restaurant_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $sber_id
 * @property string $platron_id
 * @property integer $payment_status
 * @property string $restaurant_zone_id
 * @property integer $promo_id
 * @property string $delivery_at
 * @property string $dc_link_approve
 * @property string $dc_link_cancel
 * @property string $gift_card_text
 * @property boolean $is_get_point
 */
class OrderBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'address'], 'required'],
            [['is_get_point'], 'boolean'],
            ['lat', 'required', 'message' => 'Необходимо указать точный и корректный адрес доставки'],
            ['lng', 'required', 'message' => ''],
            [['user_id', 'address_id', 'gift_id', 'order_source', 'points_number', 'discount', 'status', 'payment_type', 'restaurant_id', 'payment_status', 'promo_id'], 'integer'],
            [['lat', 'lng', 'payment_summ', 'order_summ'], 'number'],
            [['client_comment', 'operator_comment', 'dc_link_approve', 'dc_link_cancel'], 'string'],
            [['created_at', 'updated_at', 'gift_card_text'], 'safe'],
            [[ 'address', 'entrance', 'floor', 'flat', 'payment_id', 'phone', 'change_sum', 'name', 'sber_id', 'platron_id', 'restaurant_zone_id', 'delivery_at'], 'string', 'max' => 255],
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
            'address_id' => 'Address ID',
            'gift_id' => 'Gift ID',
            'order_source' => 'Order Source',
            'address' => 'Address',
            'entrance' => 'Entrance',
            'floor' => 'Floor',
            'flat' => 'Flat',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'points_number' => 'Points Number',
            'discount' => 'Discount',
            'status' => 'Status',
            'payment_id' => 'Payment ID',
            'payment_type' => 'Payment Type',
            'phone' => 'Phone',
            'client_comment' => 'Client Comment',
            'operator_comment' => 'Operator Comment',
            'change_sum' => 'Change Sum',
            'payment_summ' => 'Payment Summ',
            'order_summ' => 'Order Summ',
            'restaurant_id' => 'Restaurant ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'sber_id' => 'Sber ID',
            'platron_id' => 'Platron ID',
            'payment_status' => 'Payment Status',
            'restaurant_zone_id' => 'Restaurant Zone ID',
            'promo_id' => 'Promo ID',
            'delivery_at' => 'Delivery At',
            'dc_link_approve' => 'Dc Link Approve',
            'dc_link_cancel' => 'Dc Link Cancel',
            'gift_card_text' => 'Gift Card Text',
            'is_get_point' => 'Is Get Point',
        ];
    }
}

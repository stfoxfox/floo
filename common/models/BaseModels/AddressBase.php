<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $entrance
 * @property string $floor
 * @property string $flat
 * @property double $lat
 * @property double $lng
 * @property string $location
 * @property string $created_at
 * @property string $updated_at
 * @property string $full_address
 */
class AddressBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'address', 'lat', 'lng', 'location'], 'required'],
            [['user_id'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['location'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['address', 'entrance', 'floor', 'flat', 'full_address'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'entrance' => 'Entrance',
            'floor' => 'Floor',
            'flat' => 'Flat',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'location' => 'Location',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'full_address' => 'Full Address',
        ];
    }
}

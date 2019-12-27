<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "restaurant".
 *
 * @property integer $id
 * @property string $address
 * @property integer $region_id
 * @property string $phone
 * @property double $lat
 * @property double $lng
 * @property string $metro
 * @property integer $sort
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property integer $external_id
 * @property integer $organisation_id
 */
class RestaurantBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'lat', 'lng'], 'required'],
            [['region_id', 'sort', 'external_id', 'organisation_id'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['metro'], 'string'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['address', 'phone'], 'string', 'max' => 255],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'region_id' => 'Region ID',
            'phone' => 'Phone',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'metro' => 'Metro',
            'sort' => 'Sort',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'external_id' => 'External ID',
            'organisation_id' => 'Organisation ID',
        ];
    }
}

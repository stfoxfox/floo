<?php

namespace common\models\BaseModels;

use Yii;
use nanson\postgis\behaviors\GeometryBehavior;

/**
 * This is the model class for table "restaurant_zone".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $zone
 * @property string $min_order
 * @property string $min_time
 * @property string $max_time
 * @property string $created_at
 * @property string $updated_at
 * @property string $zone_external_id
 */
class RestaurantZoneBase extends \common\components\MyExtensions\MyActiveRecord
{

    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => GeometryBehavior::className(),
    //             'type' => GeometryBehavior::GEOMETRY_MULTIPOLYGON,
    //             'attribute' => 'zone',
    //         ],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_zone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_id'], 'integer'],
            [['zone'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['min_order', 'min_time', 'max_time', 'zone_external_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant ID',
            'zone' => 'Zone',
            'min_order' => 'Min Order',
            'min_time' => 'Min Time',
            'max_time' => 'Max Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'zone_external_id' => 'Zone External ID',
        ];
    }
}

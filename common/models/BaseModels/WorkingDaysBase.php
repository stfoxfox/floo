<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "working_days".
 *
 * @property integer $id
 * @property integer $weekday
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $restaurant_id
 */
class WorkingDaysBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_days';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weekday', 'status', 'restaurant_id'], 'required'],
            [['weekday', 'status', 'restaurant_id'], 'integer'],
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
            'weekday' => 'Weekday',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'restaurant_id' => 'Restaurant ID',
        ];
    }
}

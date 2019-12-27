<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "working_hours".
 *
 * @property integer $id
 * @property string $open_time
 * @property string $close_time
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $working_day_id
 */
class WorkingHoursBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_hours';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_time', 'close_time', 'created_at', 'updated_at'], 'safe'],
            [['type', 'working_day_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'open_time' => 'Open Time',
            'close_time' => 'Close Time',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'working_day_id' => 'Working Day ID',
        ];
    }
}
